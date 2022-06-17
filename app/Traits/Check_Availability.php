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

    $reserved = DB::table('table')
    ->join('reservation', 'table.id', '=', 'reservation.table_id')
    ->where('reservation.waiting_list' , 0)
    ->where('table.capacity' , '>=' , $request->capacity)
    ->where('reservation.from_time', '<=', $datetime)
    ->where('reservation.to_time', '>=', $datetime)
    ->pluck('table.id');

    return $reserved;
    }

     //Get Avalaible Tables 
    public function avalaible_tables($request , $reserved){
        
        $avalaible = DB::table('table')
        ->where('table.capacity' , '>=' , $request->capacity)
        ->whereNotIn('id', $reserved)
        ->orderBy('table.capacity')
        ->pluck('table.id');   

        return $avalaible;
    }

     //Get Reserved Tables 
     public function waiting_list_tables($request , $datetime){

        $reserved_waiting_list = DB::table('table')
        ->join('reservation', 'table.id', '=', 'reservation.table_id')
        ->where('reservation.waiting_list' , 1)
        ->where('table.capacity' , '>=' , $request->capacity)
        ->where('reservation.from_time', '<=', $datetime)
        ->where('reservation.to_time', '>=', $datetime)
        ->pluck('table.id');

        return $reserved_waiting_list;
        }
    
         //Get Avalaible Tables 
        public function avalaible_waiting_list($request , $reserved_waiting_list){

            $waiting_list = DB::table('table')
            ->where('table.capacity' , '>=' , $request->capacity)
            ->whereNotIn('id', $reserved_waiting_list)
            ->orderBy('table.capacity')
            ->pluck('table.id');   

            return $waiting_list;
        }
}