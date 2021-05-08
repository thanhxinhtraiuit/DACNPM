<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine_inventory extends Model
{
    protected $table = 'medicines_inventory';
    protected $fillable = [
        'month',
        'medicine_id',
        'type',
        'amount_left',
        'created_at',
        'updated_at'
    ];

    public function prescription()
    {
        return $this->hasMany(Prescription::class,'customer_id','code');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['type']) && $request['type']){
            $model = $model->where('type',$request['type']);
        }

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['medicine_id']) && $request['medicine_id']){
            $model = $model->where('medicine_id','LIKE','%'.$request['medicine_id'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['amount']) && $request['amount']){
            $model = $model->where('amount',$request['amount']);
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
            'medicine_id' => $request['medicine_id'],
            'amount' => $request['amount'],
            'type' => '1',
            'status' => '1',
            'medicine_id' => $medicine_id
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
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['medicince_id']) && $request['medicince_id']){
            $arrayInput['medicince_id'] =$request['medicince_id'];
        }

        if(isset($request['type']) && $request['type']){
            $arrayInput['type'] =$request['type'];
        }

        if(isset($request['amount']) && $request['amount']){
            $arrayInput['amount'] =$request['amount'];
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
