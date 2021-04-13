<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Carbon\Carbon;


class customerController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|integer',
        ]);

        $code = $this->generateCode();
        
        $arrayInput = [
            'name' => $request->name,
            'phone' => $request->phone,
            'code' => $code
        ];

        if (isset($request->sex) && $request->sex)
            $arrayInput['sex']=$request->sex;
        if (isset($request->address) && $request->address)
            $arrayInput['address']=$request->address;
        if (isset($request->birth) && $request->birth)
            $arrayInput['birth']=$request->birth;
        $results = Customer::create($arrayInput);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];

        return response()->json($return);
    }
   
    public function generateCode()
        {
            $now = Carbon::now();
            return $now->day +  $now->month + $now->year + $now->min + $now->second + 9000000000;
        }
    
        public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'string',
            'phone'=>'integer',
        ]);

        $return = [
            'status' => '1',
            'code' => '200'
        ];

        $arrayInput = [];
        // check exist
        $customer = Customer::where('id', $id)->first();
        if (empty($customer))
        {
            $return['status']=0;
            $return['message']='Customer not found';
            return response()->json($return);
        }
        //create array input
        if (isset($request->sex) && $request->sex)
            $arrayInput['sex']=$request->sex;
        if (isset($request->address) && $request->address)
            $arrayInput['address']=$request->address;
        if (isset($request->birth) && $request->birth)
            $arrayInput['birth']=$request->birth;
        if (isset($request->name) && $request->name)
            $arrayInput['name']=$request->name;
        
        $results = Customer::create($arrayInput);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];

        return response()->json($return);
    }
}

