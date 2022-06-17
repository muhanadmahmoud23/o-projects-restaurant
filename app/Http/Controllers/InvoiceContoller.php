<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order_Details;
use App\Models\Order;
use App\Traits\DiscountCalc;

class InvoiceContoller extends Controller
{
    use DiscountCalc;
    public function print(Request $request){
        $validator = Validator::make($request->all() ,[
            'paid'      =>  'required|int',
            'id'  =>  'required|exists:order',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'status'  => 442,
                'messages'=>  $validator->messages(),
            ]);
        }
        else
        {
            $order_details = Order_Details::where('order_id' , $request->id)->get();
            $items = [];
            $i = 1 ;
            $total = 0;

             //Get Meals Name And Total Price
            foreach($order_details as $meal){
                array_push($items , 'Meal No '. $i++ . " : " . $meal->meals->description . ', Price : ' . $meal->amount_to_pay);
            }

            //Update Paid in Order
            $order = Order::find($request->id);
            if($request->paid >= $order->total){
            $order->paid = $request->paid;
            $order->update();
        }
        else{
            return response()->json([
                'status'  => 200,
                'messages'=>  "Please Pay More Than " . $order->total . ' EG',
                
            ]);
        }
            return response()->json([
                'status'  => 200,
                'customer Name'  => $order->customername->name,
                'total'   => $order->total,
                'Order Details'=>  $items,
            ]);
        }
        
    }
}
