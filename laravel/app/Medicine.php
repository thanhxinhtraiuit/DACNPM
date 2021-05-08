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

    public function prescription()
    {
        return $this->hasMany(Prescription::class,'customer_id','code');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['code']) && $request['code']){
            $model = $model->where('code',$request['code']);
        }

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['amount_inventory']) && $request['amount_inventory']){
            $model = $model->where('amount_inventory','LIKE','%'.$request['amount_inventory'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['unit']) && $request['unit']){
            $model = $model->where('unit',$request['unit']);
        }

        if(isset($request['cost_per_med']) && $request['cost_per_med']){
            $model = $model->where('cost_per_med',$request['cost_per_med']);
        }

        if(isset($request['from_date']) && $request['from_date']){
            $from_date=Carbon::create($request['from_date'])->startOfDay();
            $model = $model->where('created_at','>',$from_date);
        }

        if(isset($request['to_date']) && $request['to_date']){
            $to_date=Carbon::create($request['to_date'])->endOfDay();
            $model = $model->where('created_at','<',$to_date);
        }

        $results = $model->get();

        return $results;
    }

    public function createv2(Array $request)
    {

        $code = $this->generateCode();

        $user_id = Auth::user()->id;

        $arrayInput = [
            'code' => $request['code'],
            'unit' => $request['unit'],
            'cost_per_med' => $request['cost_per_med'],
            'amount_inventory' => $request['amount_inventory'],
            'status' => '1',
            'code' => $code
        ];

        
        $results = prescription::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $prescription = prescription::where('id', $id)->first();

        return $prescription;
    }

    public function deletev2($id)
    {
        
        $prescription = prescription::where('id', $id)->first();
        $prescription->update(['status'=>'2']);

        return $prescription;
    }

    public function updatev2(Array $request, $id)
    {

        $arrayInput = [];
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] = $request['status'];
        }

        if(isset($request['amount_inventory']) && $request['amount_inventory']){
            $arrayInput['amount_inventory'] =$request['amount_inventory'];
        }

        if(isset($request['unit']) && $request['unit']){
            $arrayInput['unit'] = $request['unit'];
        }

        if(isset($request['cost_per_med']) && $request['cost_per_med']){
            $arrayInput['cost_per_med'] = $request['cost_per_med'];
        }

        $prescription = prescription::where('id', $id)->first();
        $results =$prescription->update($arrayInput);
        
        return $results;
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
