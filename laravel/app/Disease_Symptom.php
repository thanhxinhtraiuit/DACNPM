<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease_Symptom extends Model
{
    protected $table='diseases_symptoms';

    protected $fillable = [
        'code',
        'symptom_name',
        'created_at',
        'updated_at'
    ];
}
