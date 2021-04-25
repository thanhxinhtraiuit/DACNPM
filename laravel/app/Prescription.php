<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use Carbon\Carbon;
class Prescription extends Model

{
    protected $table = 'prescriptions';

    protected $model;

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
    public function Search(array $request){

        $model = $this;

        $abc = $this->generateCode();
        dd($abc);
        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['name']) && $request['name']){
            $model = $model->where('name','LIKE','%'.$request['name'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['from_date']) && $request['from_date']){
            $from_date=Carbon::create($request['from_date'])->startOfDay();
            $model = $model->where('created_at','>',$from_date);
        }

        if(isset($request['to_date']) && $request['to_date']){
            $to_date=Carbon::create($request['to_date'])->endOfDay();
            $model = $model->where('created_at','<',$to_date);
        }

        if(isset($request['data_customer']) && $request['data_customer']){
            $model->with('customer');
        }

        $results = $model->get();

        return $results;
    }

    public function insert(Array $request)
    {

        $code = $this->generateCode;
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

    public function generateCode()
    { 
        $now =  Carbon::now();
        $model = $this->where('created_at','>',$now->startOfDay())->get();
        $id = '';
        if ($model) 
        {
            $postfix = count($model)+1;
            if ($postfix < 10)
                $id = "000". $postfix;
            else if ($postfix < 100)
                $id = "00". $postfix;
            else if ($postfix < 1000)
                $id = "0". $postfix;
        } 
        else
        {
            $id = "0001";
        }
        $stringCode = 120 .$now->format('ymd') . $id ;
        return $stringCode;
    }
}

