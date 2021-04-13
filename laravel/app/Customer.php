<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'code',
        'name',
        'sex',
        'birth',
        'phone',
        'address',
        'created_at',
        'updated_at'
    ];
}
