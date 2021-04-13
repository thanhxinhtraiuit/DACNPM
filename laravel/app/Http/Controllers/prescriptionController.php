<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\prescription;
use Illuminate\Support\Facades\Auth;
use App\User;

class prescriptionController extends Controller
{
    public function index(Request $request){
        $model = prescription::where([]);

        if(isset($request->status) && $request->status){
            $model = $model->where('status',$request->status);
        }
        if(isset($request->name) && $request->name){
            $model = $model->where('name','LIKE','%'.$request->name.'%');
        }
        if(isset($request->id) && $request->id){
            $model = $model->where('id',$request->id);
        }

        if(isset($request->data_customer) && $request->data_customer){
            $model->with('customer');
        }


        $resuals = $model->get();
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $resuals
        ];
        return response()->json($return);

    }

    public function insert(Request $request)
    {
        $request->validate([
            'customer_id'=>'required|integer',
        ]);
        $code = 'A000' . rand();
        $arrayInput = [
            'customer_id' => $request->customer_id,
            'code' => $code,
            'status' => '1',
        ];
        $results = prescription::create($arrayInput);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];

        return response()->json($return);

    }

    public function detail(Request $request, $id)
    {
        
        $prescription = prescription::where('id', $id)->first();

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $prescription
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $prescription = prescription::where('id', $id)->first();
        $prescription->update(['status'=>'2']);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $prescription
        ];
        return response()->json($return);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'string',
            'customer_id'=>'integer',
        ]);
        $arrayInput = [
            'name' => $request->name,
            'customer_id' => $request->customer_id,
            'status' =>  $request->status,
        ];
        $prescription = prescription::where('id', $id)->first();
        $results =$prescription->update($arrayInput);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];
        
        return response()->json($return);
    }
}
