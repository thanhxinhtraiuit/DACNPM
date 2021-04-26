<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';

    protected $fillabe = [
        'code',
        'amount_inventory',
        'unit',
        'cost_per_med',
        'created_at',
        'updated_at'
    ];
}
