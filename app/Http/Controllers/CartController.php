<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function index(Request $request)
    {
        // فقط لعرض الصفحة الفارغة التي ستملأ بالـ JS
        $cart = $this->getCart($request);
        return view('cart.index', compact('cart'));
    }
    // جلب محتويات Cart
    public function indexApi(Request $request)
    {
        $cart = $this->getCart($request);
        return response()->json([
            'items' => $cart->items()->with('product')->get(),
            'total' => $cart->total()
        ]);
    }

    // إضافة منتج
public function addApi(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'integer|min:1',
        'options'    => 'nullable|array',
    ]);

    $cart = $this->getCart($request);
    $product = Product::findOrFail($request->product_id);

    $height = $request->options['height'] ?? null;
    $weight = $request->options['weight'] ?? null;
    $qty    = $request->quantity ?? 1;

    $cartItem = $cart->items()
        ->where('product_id', $product->id)
        ->where('height', $height)
        ->where('weight', $weight)
        ->first();

    if ($cartItem) {
        // نفس المنتج + نفس المقاسات → زوّد الكمية
        $cartItem->quantity += $qty;
        $cartItem->save();
    } else {
        // منتج جديد أو مقاسات مختلفة → item جديد
        $cart->items()->create([
            'product_id'     => $product->id,
            'quantity'       => $qty,
            'price_snapshot' => $product->price,
            'height'         => $height,
            'weight'         => $weight,
            'options'        => $request->options,
        ]);
    }

    $cart->load('items.product');

    return response()->json([
        'message' => 'تمت الإضافة إلى السلة',
        'cart'    => $cart,
    ]);
}





  public function buyProduct(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'integer|min:1',
        'options' => 'nullable|array'
    ]);

    $cart = $this->getCart($request);

    $product = Product::findOrFail($request->product_id);

    // تحقق إذا المنتج موجود بالفعل
    $cartItem = $cart->items()->where('product_id', $product->id)->first();

    if ($cartItem) {
        // زود الكمية بدل ما تستبدل
        $cartItem->quantity += $request->quantity ?? 1;
        $cartItem->save();
    } else {
        $cartItem = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity ?? 1,
            'price_snapshot' => $product->price,
            'options' => $request->options
        ]);
    }

    // إعادة الكارت كامل مع حساب total لو عايز
    $cart->load('items.product'); // لو عايز ترجع بيانات المنتجات مع الكارت

    return redirect("chechout.show");
}

public function add(Request $request)
{
    $productId = $request->product_id;

    $cart = session()->get('cart', []);

    if(isset($cart[$productId])) {
        // المنتج موجود، زود الكمية
        $cart[$productId]['quantity']++;
    } else {
        $product = Product::findOrFail($productId);
        $cart[$productId] = [
            'product_id' => $product->id,
            'product' => $product,
            'quantity' => 1,
            'price_snapshot' => $product->price,
        ];
    }

    session()->put('cart', $cart);

    // تحسب المجموع الكلي
    $total = array_sum(array_map(fn($item) => $item['price_snapshot'] * $item['quantity'], $cart));

    return response()->json([
        'items' => array_values($cart),
        'total' => $total,
    ]);
}

    // تحديث كمية المنتج
// تحديث كمية الـ Item المحدد
public function updateApi(Request $request, CartItem $item) // لارافيل سيبحث عن الـ Item بالـ ID تلقائياً
{
    // نتأكد أن الـ Item ينتمي لسلة المستخدم الحالية (لأمان الكود)
    $cart = $this->getCart($request);
    if ($item->cart_id !== $cart->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    if ($request->type === 'inc') {
        $item->quantity++;
    } elseif ($request->type === 'dec') {
        $item->quantity = max(1, $item->quantity - 1);
    }

    $item->save();

    return response()->json([
        'message' => 'Cart updated',
        'total' => $cart->total(),
        'items' => $cart->items()->with('product')->get()
    ]);
}

// إزالة الـ Item المحدد
public function removeApi(Request $request, CartItem $item)
{
    $cart = $this->getCart($request);
    
    if ($item->cart_id === $cart->id) {
        $item->delete();
    }

    return response()->json([
        'message' => 'Item removed',
        'items' => $cart->items()->with('product')->get(),
        'total' => $cart->total()
    ]);
}


    // Helper: جلب Cart الحالي (Guest أو User)
    private function getCart(Request $request)
    {
        if ($request->user()) {
            return Cart::firstOrCreate(['user_id' => $request->user()->id]);
        } else {
            $guestId = $request->cookie('guest_id') ?? uniqid('guest_', true);
            $cart = Cart::firstOrCreate(['guest_id' => $guestId]);
            // حفظ cookie
            cookie()->queue(cookie()->forever('guest_id', $guestId));
            return $cart;
        }
    }
}
