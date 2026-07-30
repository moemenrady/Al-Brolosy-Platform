<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
  public function collection($id)
  {
 $collection = Collection::find($id);

    if(!$collection){
      
        abort(404); // لو مش موجود

    }

    $collectionName = $collection->name;
    $products = Product::where('collection_id', $collection->id)->get();
    return view("collection.collection_products", compact("products", "collectionName"));

  }
}
