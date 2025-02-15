<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list (Request $request) {
        return Product::query()->paginate(10);
    }

    public function product( int $id )
    {
        return Product::findOrFail($id);
    }

    public function create(Request $request ) : Product
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product =  Product::create([
            'name' => $request->name,
            'in_stock' => true,
            'price' => $request->price,
            'description' => $request->description
        ]);
        $product->refresh();

        return $product;
    }
}
