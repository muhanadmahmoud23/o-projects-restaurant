<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Meal;

trait DiscountCalc {

    public function discount($meals){
    if($meals->discount == 0 || $meals->discount == null){
        $price = $meals->price;
    }
    else{
        $discount = ( $meals->price * $meals->discount ) / 100;       
        $price = $meals->price - $discount; 
    }

    return $price;
}
}