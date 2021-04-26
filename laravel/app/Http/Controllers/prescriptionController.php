<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\prescription;
use Illuminate\Support\Facades\Auth;
use App\User;

class prescriptionController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new prescription;
        $results = $model->Search($arrayInput);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];
        return response()->json($return);

    }

    public function create(Request $request)
    {
        $request->validate([
            'customer_id'=>'required|integer',
        ]);
        $arrayInput = $request->all();
        $model = new prescription;
        $results = $model->createv2($arrayInput);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];

        return response()->json($return);

    }

    public function detail(Request $request, $id)
    {
        $model = new prescription;

        $prescription =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $prescription
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new prescription;

        $prescription =  $model->deletev2( $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'message' => 'deleted'
        ];
        return response()->json($return);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'string',
        ]);
        
        $arrayInput = $request->all();
        $model = new prescription;

        $prescription =$model->updatev2($arrayInput, $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $prescription
        ];
        
        return response()->json($return);
    }
}
