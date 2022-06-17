<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;

class MealsContoller extends Controller
{
    public function allmeals(){

        $meals = Meal::where('quantity_avaliable' , '>' , 0)->get();

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
