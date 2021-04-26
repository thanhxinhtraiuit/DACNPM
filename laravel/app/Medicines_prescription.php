<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicines_prescription extends Model
{
    protected $table = 'medicines_prescription';

    protected $fillable = [
        'code',
        'medicine_code',
        'PD_code',
        'amount',
        'uses',
        'created_at',
        'updated_at'
    ];
}
