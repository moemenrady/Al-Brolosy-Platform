<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SmartCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function smartCards()
    {
        $cards = SmartCard::all();

        return view('admin.smart-cards.index', compact('cards'));
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function addProduct()
    {
        $collections = Collection::all();
        return view('admin.products.create', compact('collections'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'price'         => 'required|numeric',
            'image'         => 'required|image',
            'images.*'      => 'nullable|image',
            'collection_id' => 'required|exists:collections,id',
        ]);

        DB::beginTransaction();

        try {

            $path = '/home/u945870139/domains/nay-brand.shop/public_html/products';

            // الصورة الرئيسية
            $mainImage = $request->file('image');
            $mainImageName = time() . '_' . uniqid() . '.' . $mainImage->getClientOriginalExtension();

            $mainImage->move($path, $mainImageName);

            $product = Product::create([
                'name'          => $request->name,
                'price'         => $request->price,
                'image'         => $mainImageName,
                'hover_image'   => $mainImageName,
                'collection_id' => $request->collection_id,
            ]);

            // الصور الإضافية
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->move($path, $imageName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $imageName,
                    ]);
                }
            }

            // أول صورة إضافية تبقى hover
            $firstImage = ProductImage::where('product_id', $product->id)->first();

            if ($firstImage) {
                $product->update([
                    'hover_image' => $firstImage->image
                ]);
            }

            DB::commit();

            return back()->with('success', 'Added product successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
    public function editProduct($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $collections = Collection::all();

        return view('admin.products.edit', compact('product', 'collections'));
    }
    public function updateProduct(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'images.*' => 'nullable|image',
            'deleted_images' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {

            $path = '/home/u945870139/domains/nay-brand.shop/public_html/products';

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'collection_id' => $request->collection_id,
                'sold_out' => $request->has('sold_out'),
            ]);

            // تغيير الصورة الرئيسية
            if ($request->hasFile('image')) {

                if (
                    $product->image &&
                    file_exists($path . '/' . $product->image)
                ) {
                    unlink($path . '/' . $product->image);
                }

                $imageName = time() . '_' . uniqid() . '.' .
                    $request->image->getClientOriginalExtension();

                $request->image->move($path, $imageName);

                $product->update([
                    'image' => $imageName,
                ]);
            }

            // حذف صور مختارة
            if ($request->filled('deleted_images')) {

                $images = ProductImage::whereIn(
                    'id',
                    $request->deleted_images
                )
                    ->where('product_id', $product->id)
                    ->get();

                foreach ($images as $image) {

                    if (
                        $image->image &&
                        file_exists($path . '/' . $image->image)
                    ) {
                        unlink($path . '/' . $image->image);
                    }

                    $image->delete();
                }
            }

            // إضافة صور جديدة
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $imageName = time() . '_' . uniqid() . '.' .
                        $image->getClientOriginalExtension();

                    $image->move($path, $imageName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageName,
                    ]);
                }
            }

            // تحديث hover image
            $firstImage = ProductImage::where(
                'product_id',
                $product->id
            )->first();

            $product->update([
                'hover_image' => $firstImage
                    ? $firstImage->image
                    : $product->image,
            ]);

            DB::commit();

            return back()->with(
                'success',
                'Product updated successfully'
            );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
    public function deleteProduct($id)
    {
        $product = Product::with('images')->findOrFail($id);

        DB::beginTransaction();

        try {

            $path = '/home/u945870139/domains/nay-brand.shop/public_html/products';

            if (
                $product->image &&
                file_exists($path . '/' . $product->image)
            ) {
                unlink($path . '/' . $product->image);
            }

            if (
                $product->hover_image &&
                $product->hover_image != $product->image &&
                file_exists($path . '/' . $product->hover_image)
            ) {
                unlink($path . '/' . $product->hover_image);
            }

            foreach ($product->images as $image) {

                if (
                    $image->image &&
                    file_exists($path . '/' . $image->image)
                ) {
                    unlink($path . '/' . $image->image);
                }

                $image->delete();
            }

            $product->delete();

            DB::commit();

            return back()->with(
                'success',
                'Product deleted successfully'
            );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
    public function addCollection()
    {
        $collections = Collection::latest()->get();
        return view('admin.collections.create', compact('collections'));
    }


    public function storeCollection(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Collection::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.collections.create')
            ->with('success', 'Added collection successfully');
    }
    public function showCollection($id)
    {
        $collection = Collection::findOrFail($id);
        return view('admin.collections.show', compact('collection'));
    }
    public function  indexOrders()
    {
        $orders = Order::with("items")->get();
        return view('admin.orders.index', compact('orders'));
    }


    public function editHeroImage()
    {
        return view('admin.hero.edit');
    }

    public function updateHeroImage(Request $request)
    {
        $request->validate([
            'desktop_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
            'mobile_image'  => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
        ]);

        // تحديد مسار الـ public_html بناءً على هيكل السيرفر الخاص بك
        // نستخدم dirname(base_path()) للرجوع خطوة للخلف من مجلد المشروع إلى المجلد الرئيسي للموقع
        $publicHtmlPath = dirname(base_path()) . '/public_html/home';

        if (!file_exists($publicHtmlPath)) {
            mkdir($publicHtmlPath, 0755, true);
        }

        // تحديث صورة الديسكتوب
        if ($request->hasFile('desktop_image')) {
            $request->file('desktop_image')->move($publicHtmlPath, 'base_image_desktop.png');
        }

        // تحديث صورة الموبايل
        if ($request->hasFile('mobile_image')) {
            $request->file('mobile_image')->move($publicHtmlPath, 'base_image_mobile.png');
        }

        if (!$request->hasFile('desktop_image') && !$request->hasFile('mobile_image')) {
            return back()->with('error', 'Please select at least one image to update.');
        }

        return back()->with('success', 'Hero images updated successfully in public_html');
    }



    public function ordersIndex()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        $order->load('items'); // جلب المنتجات المرتبطة بالطلب
        return view('admin.orders.show', compact('order'));
    }
    public function showOrder($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    public function updateStatusOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }
}
