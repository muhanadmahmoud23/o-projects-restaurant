<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;
    protected $table = 'reservations';
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
