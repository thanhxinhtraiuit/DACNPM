<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Customer;
use Prescription;
use Carbon\Carbon;

class Guide extends Model
{
    public $CODE_CUSTOMER = 23;

    public $CODE_PRESCRIPTION = 12;

    public function generate($type)
    {
        $string_code = $type . Carbon::Create('ymd');

        dd($string_code);
    }
}
