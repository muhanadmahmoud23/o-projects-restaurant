<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;

trait Reservation_Waiting_list {

    public function send_reservation($id , $avalaible , $datetime , $to_date  , $waiting_list ){

        $reservtion = Reservation::create([
            'customer_id' => $id ,
            'table_id'    => $avalaible ,
            'from_time'   => $datetime ,
            'to_time'     => $to_date ,
            'waiting_list'=> $waiting_list,
        ]);

        return $reservtion;
    }
}