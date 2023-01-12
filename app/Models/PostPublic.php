<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPublic extends Model
{
    //use HasFactory;

    protected $fillable = [
        'plantname',
        'body',
        'image'
    ];

    public $timestamps = false;

}
