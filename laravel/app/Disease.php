<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $table = 'diseases';

    protected $fillable = [
        'code',
        'disease_name',
        'created_at',
        'updated_at'
    ];
}
