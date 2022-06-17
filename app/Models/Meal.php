<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meal';
    
    protected $fillable = [
        'id' ,
        'price',
        'description',
        'quantity_avaliable',
        'discount',
        'created_at',
        'updated_at'
    ];

}
