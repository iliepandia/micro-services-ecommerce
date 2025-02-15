<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\OrderService;
use App\Services\ProductService;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function list (Request $request) {
        return Payment::where('user_id', $request->_auth_user_id )
            ->paginate(10);
    }
    public function payment( Request $request, int $id )
    {
        return Payment::where('user_id', $request->_auth_user_id)
            ->where('id', $id)->firstOrFail();
    }

    public function create(Request $request) : Payment{
        $orderService = new OrderService($request);

        $request->validate([
            "order_id" => ['unique:payments','required','numeric','min:1', function($attribute, $value, Closure $fail) use ($orderService){
                try{
                    if(!$orderService->getOrder(intval($value))){
                        $fail("Could not validate the order id!");
                    }
                }catch (ModelNotFoundException $e){
                    $fail("Could not validate the order id!");
                }
            } ],
            "notes" => "string|nullable",
            "transaction_id" => "required|size:20"
        ]);

        $payment =  Payment::create([
            'status' => 'pending',
            'order_id' => $request->order_id,
            'user_id' => $request->_auth_user_id,
            'processor_name' => 'PayPal',
            'transaction_id' => $request->transaction_id,
            'notes'=>$request->notes,
        ]);
        $payment->refresh();

        return $payment;
    }
}
