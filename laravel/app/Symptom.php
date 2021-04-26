<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $table = 'symptoms';

    protected $fillable = [
        'code',
        'disease_code',
        'symptom_code',
        'created_at',
        'updated_at'
    ];
}
