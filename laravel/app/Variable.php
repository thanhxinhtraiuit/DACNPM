<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $table = 'variables';

    protected $fillable = [
        'id',
        'key',
        'value',
        'status',
        'created_at',
        'updated_at'
    ];

    public function Search(array $request){

        $model = $this;

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['key']) && $request['key']){
            $model = $model->where('key',$request['key']);
        }

        if(isset($request['value']) && $request['value']){
            $model = $model->where('value',$request['value']);
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
            'key' => $request['key'],
            'value' => $request['value']
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
        if(isset($request['key']) && $request['key']){
            $arrayInput['key'] = $request['key'];
        }

        if(isset($request['value']) && $request['value']){
            $arrayInput['value'] = $request['value'];
        }

        $prescription = prescription::where('id', $id)->first();
        $results = $prescription->update($arrayInput);
        
        return $results;
    }
}
