<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'table';
    
    protected $fillable = [
        'id' ,
        'capacity',
        'created_at',
        'updated_at'
    ];
}
