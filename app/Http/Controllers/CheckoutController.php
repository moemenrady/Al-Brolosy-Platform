<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
  // في CheckoutController
  public function show(Request $request)
  {
    $cart = $this->getCart($request);

    // 👇 الحل هنا
    if ((!$cart || $cart->items->isEmpty()) && !session()->has('show_modal')) {
      return redirect('/')->with('error', 'Cart is empty');
    }

    $subtotal = $cart ? $cart->total() : 0;
    $deposit = $subtotal * 0.15;

    return view('checkout.index', compact('cart', 'subtotal', 'deposit'));
  }

  public function submit(Request $request)
  {
    $request->validate([
      'first_name' => 'required',
      'last_name' => 'required',
      'phone' => 'required',
      'address' => 'required',
      'city' => 'required',
      'governorate' => 'required',
    ]);


    $cart = $this->getCart($request);

    if (!$cart || $cart->items->isEmpty()) {
      return back()->withErrors('Cart is empty');
    }

    $order = Order::create([
      'user_id' => optional($request->user())->id,
      'email' => $request->email,
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'phone' => $request->phone,
      'address' => $request->address,
      'apartment' => $request->apartment,
      'city' => $request->city,
      'governorate' => $request->governorate,
      'postal_code' => $request->postal_code,
      'status' => "pending",
      'is_deposited' => false,
      'total' => $cart->total(),
    ]);

    foreach ($cart->items as $item) {
      $order->items()->create([
        'product_id' => $item->product_id,
        'name' => $item->product->name,
        'price' => $item->price_snapshot,
        'quantity' => $item->quantity,
        'options' => $item->options,
      ]);
    }

    // حفظ قيمة الديبوزيت قبل تفريغ السلة
    $deposit = $cart->total() * 0.15;

    // تفريغ الكارت بعد الطلب
    $cart->items()->delete();

    return redirect()->route('checkout.index')->with([
      'show_modal' => true,
      'order_id' => $order->id,
      'customer_name' => $request->first_name . ' ' . $request->last_name,
      'total_amount' => $order->total,
      'deposit_amount' => $deposit,
      'whatsapp' => '201094619040'
    ]);
  }
  public function success(Request $request)
  {
    $name = session('name');   // جايه من with()
    $phone = session('phone');

    return view("checkout.success", compact("name", "phone"));
  }
  private function getCart(Request $request)
  {
    return Cart::where(function ($query) use ($request) {

      if ($request->user()) {
        $query->where('user_id', $request->user()->id);
      } else {
        $query->where('guest_id', $request->cookie('guest_id'));
      }
    })->with('items.product')->first();
  }
}
