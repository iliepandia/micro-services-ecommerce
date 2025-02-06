<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class ProductController extends Controller
{
    public function list (Request $request) {
        return response()->json([
            [
                'id' => 1,
                'name' => 'Product 1',
                'description' => 'Product description 1'
            ],
        ]);
    }
}
