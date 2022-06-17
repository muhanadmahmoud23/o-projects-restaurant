<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait Check_Availability {

     //Get datetime of the begining of reservation 
    public function DateTime($request){

    $datetime = $request->month.'/'.$request->day.'/'.$request->year.' '.$request->hour.":00".":00";
    $datetime = date('Y-m-d H:i:s', strtotime($datetime));

    return $datetime;
    }

     //Get Reserved Tables 
    public function reserved_tables($request , $datetime){

    $reserved = DB::table('tables')
    ->join('reservations', 'tables.id', '=', 'reservations.table_id')
    ->where('reservations.waiting_list' , 0)
    ->where('tables.capacity' , '>=' , $request->capacity)
    ->where('reservations.from_time', '<=', $datetime)
    ->where('reservations.to_time', '>=', $datetime)
    ->pluck('tables.id');

    return $reserved;
    }

     //Get Avalaible Tables 
    public function avalaible_tables($request , $reserved){

        $avalaible = DB::table('tables')
        ->where('tables.capacity' , '>=' , $request->capacity)
        ->whereNotIn('id', $reserved)
        ->orderBy('tables.capacity')
        ->pluck('tables.id');   

        return $avalaible;
    }

     //Get Reserved Tables 
     public function waiting_list_tables($request , $datetime){

        $reserved_waiting_list = DB::table('tables')
        ->join('reservations', 'tables.id', '=', 'reservations.table_id')
        ->where('reservations.waiting_list' , 1)
        ->where('tables.capacity' , '>=' , $request->capacity)
        ->where('reservations.from_time', '<=', $datetime)
        ->where('reservations.to_time', '>=', $datetime)
        ->pluck('tables.id');

        return $reserved_waiting_list;
        }
    
         //Get Avalaible Tables 
        public function avalaible_waiting_list($request , $reserved_waiting_list){

            $waiting_list = DB::table('tables')
            ->where('tables.capacity' , '>=' , $request->capacity)
            ->whereNotIn('id', $reserved_waiting_list)
            ->orderBy('tables.capacity')
            ->pluck('tables.id');   

            return $waiting_list;
        }
}