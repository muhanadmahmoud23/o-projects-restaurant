<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meals;

class Order_Details extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = [
        'id' ,
        'order_id',
        'meal_id',
        'amount_to_pay',
        'created_at',
        'updated_at'
    ];

    public function meals(){
        return $this->belongsTo(Meals::class, 'meal_id', 'id');
    }

}
