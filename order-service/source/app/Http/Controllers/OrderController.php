<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ProductService;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list (Request $request) {
        return Order::with('orderLines')
            ->where('user_id', $request->_auth_user_id )
            ->paginate(10);
    }
    public function order( Request $request, int $id )
    {
        return Order::with('orderLines')
            ->where('user_id', $request->_auth_user_id)
            ->where('id', $id)->first();
    }

    public function create(Request $request) : Order{
        $productService = new ProductService();

        $request->validate([
            "order_lines" => "required|array|min:1",
            "order_lines.*.product_id" => ["required","numeric",function($attribute, $value, Closure $fail) use ($productService){
                try{
                    if(!$productService->getProduct(intval($value))){
                        $fail("Could not validate the product id!");
                    }
                }catch (ModelNotFoundException $e){
                    $fail("Could not validate the product id!");
                }
            }],
            "order_lines.*.quantity" => "required|numeric|min:1|max:1000",
        ]);

        $order =  Order::create([
            'status' => 'open',
            'user_id' => $request->_auth_user_id,
        ]);

        $order->orderLines()->createMany($request->order_lines);
        $order->load('orderLines');
        $order->refresh();


        return $order;
    }
}
