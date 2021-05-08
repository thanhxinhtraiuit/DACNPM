<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicines_prescription extends Model
{
    protected $table = 'medicines_prescription';

    protected $fillable = [
        'code',
        'medicine_code',
        'PD_code',
        'amount',
        'uses',
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

        if(isset($request['medicince_code']) && $request['medicince_code']){
            $model = $model->where('medicince_code',$request['medicince_code']);
        }

        if(isset($request['PD_code']) && $request['PD_code']){
            $model = $model->where('PD_code','LIKE','%'.$request['PD_code'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['amount']) && $request['amount']){
            $model = $model->where('amount',$request['amount']);
        }

        if(isset($request['uses']) && $request['uses']){
            $model = $model->where('uses',$request['uses']);
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
            'medicine_code' => $request['medicine_code'],
            'PD_code' => $request['PD_code'],
            'amount' => $request['amount'],
            'uses' => $request['uses'],
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
        if(isset($request['medicine_code']) && $request['medicine_code']){
            $arrayInput['medicine_code'] = $request['medicine_code'];
        }

        if(isset($request['PD_code']) && $request['PD_code']){
            $arrayInput['PD_code'] =$request['PD_code'];
        }

        if(isset($request['amount']) && $request['amount']){
            $arrayInput['amount'] = $request['amount'];
        }

        if(isset($request['uses']) && $request['uses']){
            $arrayInput['uses'] = $request['uses'];
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
