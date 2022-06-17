<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiters extends Model
{
    use HasFactory;
    protected $table = 'waiters';
    protected $fillable = [
        'id' ,
        'name',
        'created_at',
        'updated_at'
    ];
}