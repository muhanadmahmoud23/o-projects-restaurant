<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';
    
    protected $fillable = [
        'id' ,
        'table_id',
        'customer_id',
        'from_time',
        'to_time',
        'waiting_list',
        'created_at',
        'updated_at'
    ];
}
