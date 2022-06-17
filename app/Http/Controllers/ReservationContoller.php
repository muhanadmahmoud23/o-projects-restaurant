<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Reservations;
use App\Models\Tables;
use App\Traits\Check_Availability;
use App\Traits\Reservation;

class ReservationContoller extends Controller
{
    use Check_Availability;
    use Reservation;

  public function check_availability(Request $request) {

    $validator = Validator::make($request->all() ,[
        'capacity'   => 'required|int|max:8',
        'year'       => 'required|int|max:2022',
        'month'      => 'required|int|max:12',
        'day'        => 'required|int|max:31',
        'hour'       => 'required|int|max:60',
    ]);

    if($validator->fails())
    {
        return response()->json([
            'status'    =>   442,
            'errors'    =>   $validator->messages(),
        ]);
    }
    else
    {
    //Get DateTime      
    $datetime = $this->DateTime($request);

    //Get Reserved Tables 
    $reserved = $this->reserved_tables($request , $datetime);

    //Get Avalaible Tables 
    $avalaible = $this->avalaible_tables($request , $reserved );
        
    if($avalaible->isEmpty())
    {
        return response()->json([
            'status'    => 200,
            'message'   => "There is no available tables for reservation"
        ]);
    }
    else
    {
        return response()->json([
            'status'    => 200,
            'message'   => "Tables number " . $avalaible. " is avaliable to be reserved",
      ]);
     }      
    }
   }

   public function Reserve(Request $request){

    $validator = Validator::make($request->all() ,[
        'capacity'       => 'required|int|max:8',
        'id'             => 'required|int|exists:customer',
        'year'           => 'required|int|min:4|max:2022',
        'month'          => 'required|int|min:2|max:12',
        'day'            => 'required|int|min:2|max:31',
        'hour'           => 'required|int|min:2|max:60',
        'reservedhours'  => 'required|int|min:1|max:4',
    ]);

    if($validator->fails())
    {
        return response()->json([
            'status'    =>   442,
            'errors'    =>   $validator->messages(),
        ]);
    }
    else
    {
    //Get DateTime      
    $datetime = $this->DateTime($request);

    //Get Reserved Tables 
    $reserved = $this->reserved_tables($request , $datetime);

    //Get Avalaible Tables 
    $avalaible = $this->avalaible_tables($request , $reserved)->first();
     
    //Get Reserved Waiting List Tables 
    $reserved_waiting_list = $this->waiting_list_tables($request , $datetime);

    //Get Waiting List 
    $waiting_list = $this->avalaible_waiting_list($request , $reserved_waiting_list)->first();

    //Get datetime of the end of the reservation
    $to_date = Carbon::parse($datetime)->addHour();

        if(!$avalaible)
        {
            if(!$waiting_list){
                return response()->json([
                    'status'    => 200,
                    'message'   => "There is no available tables for reservation"
                ]);
            }
            else
            {
                //Send Resevation With Waiting List = 1
                $this->send_reservation($request->input('id') , $waiting_list , $datetime , $to_date  , 1);

                return response()->json([
                'status'    => 200,
                'message'   => "Waiting_List For Tables number : " . $waiting_list. " -- For Customer " . $request->input('id') . "-- From : " . $datetime . " -- To : " . $to_date 
              ]);
            }
        }   
        else
        {
            // Send Resevation With Waiting List = 0 
            $this->send_reservation($request->input('id') , $avalaible , $datetime , $to_date  , 0);

            return response()->json([
                'status'    => 200,
                'message'   => "Tables number is " . $avalaible. " -- For Customer " . $request->input('id') . "-- From : " . $datetime . " -- To : " . $to_date 
          ]);
         }   
   }
}
}