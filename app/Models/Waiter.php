<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;
    protected $table = 'waiter';
    protected $fillable = [
        'id' ,
        'name',
        'created_at',
        'updated_at'
    ];
}