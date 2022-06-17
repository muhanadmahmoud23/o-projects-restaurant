<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Meal;
use App\Models\Order_Details;
use App\Models\Order;
use App\Traits\DiscountCalc;

class OrderContoller extends Controller
{
    use DiscountCalc;

    public function order(Request $request){
        $validator = Validator::make($request->all() ,[
            'waiter_id' =>  'required|int|exists:waiter',
            'id'        => 'required|int|exists:reservation',
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
            $price = 0;
            $check_meal = [];
            $reservation = Reservation::find($request->id);

            foreach($request->meals as $meal){

                $meals = Meal::find($meal);

                if($meals->quantity_avaliable == 0)
                {
                    array_push($check_meal, $meals->description);

                }
                //Get Total Price
                $price = $this->discount($meals);
                $total += $price;
            }
               //Send Order
               $order = new Order;
               $order->table_id       =  $reservation->table_id;
               $order->reservation_id =  $request->id;
               $order->customer_id    =  $reservation->customer_id ;
               $order->waiter_id      =  $request->waiter_id ;
               $order->total          = $total ;
               $order->paid           = 0 ;
               $order->date           = Carbon::now();
               $order->save();

            //Check if all quantity is avabile for required meals
            if(count($check_meal) > 0){
                return response()->json([
                    'status'   => 200,
                    'message'  => 'Please check meals quantity' ,
                    'UnAvalaible Meals'   => $check_meal
                ]); 
            }
            else{
                foreach($request->meals as $meal){
                    //Get Price
                    $meals = Meal::find($meal);
                    $price = $this->discount($meals) ;

                    $order_details = new Order_Details;
                    $order_details->order_id = $order->id;
                    $order_details->meal_id = $meal;
                    $order_details->amount_to_pay = $price ;
                    $order_details ->save();    

                    //Quaninty Update
                    $meals->quantity_avaliable -= 1;
                    $meals->update();
                }
            }
            return response()->json([
                'status'   => 200,
                'message'  => 'waiter : ' . $order->waiter->name. ' -- Custmor : ' .   $order->customername->name. ' -- Table no. ' .  $reservation->table_id . 
                ' -- total : '. $total,    
            ]);
        }    
    }
}
