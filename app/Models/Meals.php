<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    use HasFactory;
    protected $table = 'meals';
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
