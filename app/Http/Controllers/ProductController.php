<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use PHPUnit\TestRunner\TestResult\Collector;

class ProductController extends Controller
{
public function getAllProductsData()
{
    return Product::with('collection')->get();
}

public function allProducts()
{
    $products = $this->getAllProductsData();

    return response()->json([
        'status' => true,
        'count' => $products->count(),
        'products' => $products
    ]);
}
  // public function index($id)
  // {
  //   $products = Product::get();
  //   return view("index", compact("products"));
  // }
    public function collectionProducts($id)
  {
    $collectionId = Collection::where($id)->get("id");
    $products=Product::where('collection_id',$collectionId)->get();

      return response()->json([
        'status' => true,
        'count' => $products->count(),
        'products' => $products
    ]);
  }
public function show($id)
{
    // استرجاع المنتج مع علاقة collection
    $product = Product::with('collection','images')->findOrFail($id);

    return view("product.show", compact("product"));
}


}
