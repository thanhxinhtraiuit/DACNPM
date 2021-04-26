<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'code',
        'PD_code',
        'total_price',
        'analysis_price',
        'created_at',
        'updated_at'
    ];
}
