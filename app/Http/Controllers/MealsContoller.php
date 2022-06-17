<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meals;

class MealsContoller extends Controller
{
    public function allmeals(){

        $meals = Meals::where('quantity_avaliable' , '>' , 0)->get();

        if($meals)
        {
            return response()->json([
                'status'     => 200,
                'meals'      => $meals ,
            ]);
        }

        else
        {
           return response()->json([
                'status'     =>   404,
                'message'      => "No Meals Found" ,
            ]);
        }
    }
}
