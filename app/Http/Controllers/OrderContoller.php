<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Reservations;
use App\Models\Meals;
use App\Models\Order_Details;
use App\Models\Orders;

class OrderContoller extends Controller
{
    public function order(Request $request){
        $validator = Validator::make($request->all() ,[
            'waiter_id' =>  'required|int|exists:waiters',
            'id'        => 'required|int|exists:reservations',
            'meals'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 442,
                'messages'=>  $validator->messages(),
            ]);
        }
        else
        {
            $total = 0;
            $check_meal = [];
            $reservation = Reservations::find($request->id);
            $meals = Meals::find($request->meals);

            foreach($request->meals as $meal){

                $meals = Meals::find($meal);

                if($meals->quantity_avaliable == 0)
                {
                    array_push($check_meal, $meals->id);
                }

                //Send Order
                $order = new Orders;
                $order->table_id       =  $reservation->table_id;
                $order->reservation_id =  $request->id;
                $order->customer_id    =  $reservation->customer_id ;
                $order->waiter_id      =  $request->waiter_id ;
                $order->total          = $total ;
                $order->paid           = 0 ;
                $order->date           = Carbon::now();
                $order->save();
            }
            //Check if all quantity is avabile for required meal
            if(count($check_meal) > 0){
                return response()->json([
                    'status'   => 200,
                    'message'  => 'Please check meals quantity' 
                ]); 
            }
            else{
                foreach($request->meals as $meal){
                    $meals = Meals::find($meal);
                    
                    //Discount 
                    if($meals->discount == 0 || $meals->discount == null){
                        $price = $meals->price;
                     }
                        else{
                        $price = ( $meals->price * 50 ) / 100;    
                    }
    
                    $order_details = new Order_Details;
                    $order_details->order_id = $order->id;
                    $order_details->meal_id = $meal;
                    $order_details->amount_to_pay = $price ;
                    $order_details ->save();    
                }
            }
            return response()->json([
                'status'   => 200,
                'message'  => 'waiter no. ' . $request->waiter_id . ' -- Custmor : ' .   $order->customername->name. ' -- Table no. ' .  $reservation->table_id . 
                ' -- total : '. $total,    
            ]);
        }    
    }
}
