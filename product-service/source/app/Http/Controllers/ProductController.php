<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list (Request $request) {
        return Product::query()->paginate(10);
    }

    public function product( int $id )
    {
        return Product::find($id);
    }
}
