<?php

namespace App;
use App\Part;
use App\Tool;
use App\Tool_detail;
use App\Machine;
use App\Forecast;
use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ToolPart extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
    protected $table='tool_part';

    public function tools($id = null, $PartNo = null ){
    	if (!isset($id)) {
    		// return [];
            $id = $this->tool_id;
    	}

    	$tool = Tool::select([
            'id',
            'no',
            'name',
            'no_of_tooling',
            'start_value',
            'guarantee_shoot',
            // 'guarantee_remains',
            'delivery_date',
            // 'balance_shoot',
            'supplier_id',
        ])->find($id);

        $tooldetails = Machine::select(['counter', 'note'])
        ->where('tool_id', '=', $this->tool_id )
        ->orderBy('id', 'desc') //biar yang paling bawah jd diatas.    
        ->first();

        if ( empty( $tooldetails) ) {
            $tooldetails = null;
            $note = null;
        }else{
            $note = $tooldetails->note;
            $tooldetails = (int) $tooldetails->counter; //change to int
        }


        //set machine counter di tool
        $tool->counter = $tooldetails;
        $tool->note = $note;

        //set toolS_detail
        if (isset($PartNo)) {
            # code...
            $trans_date = Forecast::select(DB::raw('TransDate'))
            ->where('TransDate', '!=', 'EOF')
            ->where('PartNo', '=', $PartNo )
            ->orderByRaw('convert(datetime,TransDate) desc')
            ->first();
            //change format to Y-m-d
            if (isset($trans_date)) {
                # code...
                $trans_date = Carbon::createFromFormat('m/d/Y', $trans_date['TransDate'] )->format('Y-m-d');
            }
            $tool->detail($id, $trans_date);

        }

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
