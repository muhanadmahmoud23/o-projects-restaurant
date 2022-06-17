<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order_Details;
use App\Models\Orders;

class InvoiceContoller extends Controller
{
    public function print(Request $request){
        $validator = Validator::make($request->all() ,[
            'paid'      =>  'required|int',
            'id'  =>  'required|exists:orders',
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

             //Get Meals Name
            foreach($order_details as $meal){
                array_push($items , 'Meal No '. $i++ . " : " . $meal->meals->description . ', Price : ' . $meal->meals->price);
                //Disount
                if( $meal->meals->discount == 0 ||  $meal->meals->discount == null)
                {
                    $price =  $meal->meals->price;
                   }
               else
               {
                $price = (  $meal->meals->price* 50 ) / 100;    
                   }      
               $total += $price ;
            }

            //Update Paid in Order
            $order = Orders::find($request->id);
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
                'customer Name : '  => $order->customername->name,
                'total'   => $total,
                'Order Details'=>  $items,
           
            ]);
        }
        
    }
}
