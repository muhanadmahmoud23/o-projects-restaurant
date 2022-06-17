<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'id' ,
        'table_id',
        'reservation_id',
        'customer_id',
        'waiter_id',
        'total',
        'paid',
        'date',
        'created_at',
        'updated_at'
    ];

    public function customername(){
        return $this->belongsTo( Customers::class , 'customer_id' , 'id' );
    }

}
