<?php

namespace App;
use App\Part;
use App\Tool;
use App\Tool_detail;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ToolPart extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
    protected $table='tool_part';

    public function tools($id = null){
    	if (!isset($id)) {
    		// return [];
            $id = $this->tool_id;
    	}

    	$tool = Tool::select([
            'no',
            'name',
            'no_of_tooling',
            'total_shoot',
            'guarantee_shoot',
            'guarantee_remains',
            'delivery_date',
            'balance_shoot',
            'supplier_id',
        ])->find($id);

        $tooldetails = Tool_detail::select(['machine_counter', 'note'])
        ->where('tool_id', '=', $this->tool_id )
        ->orderBy('id', 'desc') //biar yang paling bawah jd diatas.    
        ->first();

        if ( empty( $tooldetails) ) {
            $tooldetails = null;
            $note = null;
        }else{
            $note = $tooldetails->note;
            $tooldetails = (int) $tooldetails->machine_counter; //change to int
        }


        //set machine counter di tool
        $tool->machine_counter = $tooldetails;
        $tool->note = $note;
        //set toolS_detail

        $this->tool = $tool;

    	return  $this;
    }

    public function parts($id = null){
    	if (!isset($id)) {
    		// return [];
            $id = $this->part_id;
    	}

    	$part = Part::select([
            'no',
            'name',
            'supplier_id',
            'model',
            'first_value',
            'total_delivery',
            'total_qty',
        ])->find($id);

        

        $this->part = $part;
    	return $this;
    }
}
