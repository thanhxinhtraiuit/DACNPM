<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescriptions_details extends Model
{
    protected $table = 'prescriptions_details';

    protected $fillable = [
        'code',
        'prescription_id',
        'price_medicines',
        'created_at',
        'updated_at'
    ];
}
