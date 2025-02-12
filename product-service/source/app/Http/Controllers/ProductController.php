<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

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
