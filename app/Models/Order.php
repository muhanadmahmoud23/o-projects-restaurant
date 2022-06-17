<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Waiter;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    
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
        return $this->belongsTo( Customer::class , 'customer_id' , 'id' );
    }

    public function order(){
        return $this->belongsTo( Customer::class , 'customer_id' , 'id' );
    }

    public function waiter(){
        return $this->belongsTo( Waiter::class , 'waiter_id' , 'waiter_id' );
    }
}
