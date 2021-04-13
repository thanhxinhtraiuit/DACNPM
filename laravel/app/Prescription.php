<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
class Prescription extends Model
{
    protected $table = 'prescriptions';

    protected $fillable = [
        'code',
        'name',
        'status',
        'customer_id',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }
}
