<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ToolPart;
use App\Part;
use App\Tool_detail;
use App\Machine;
use App\Forecast;
use Carbon\Carbon;
use DB;

class Tool extends Model
{
    //
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $hidden = ['is_deleted', 'deleted_at', 'created_at', 'updated_at'];
    
    protected $casts = [ 
        'start_value' => 'integer', 
        'guarantee_shoot' => 'integer'
    ];
    
    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }

    public function parts()
    {
        return $this->belongsToMany('App\Part', 'tool_part')
        ->withTimestamps()
        ->withPivot('cavity', 'is_independent');
    }

    public function forecast($PartNo, $trans_date = null ){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $trans_date = Carbon::createFromFormat('Y-m-d', $trans_date )->format('m/d/Y');
        // return $trans_date;
            $trans_date = Forecast::select(DB::raw('convert(datetime,TransDate)'))
            ->where('TransDate', '!=', 'EOF')
            // ->where('SuppCode', '=', $SuppCode )
            // ->where('PartNo', '=', $PartNo )
            ->where('transDate', '<', $trans_date )
            // ->where('PartNo', 'like', $PartNo .'%' )
            ->orderByRaw('convert(datetime,TransDate) desc')
            ->first();
            
            return $trans_date;

            $trans_date = $trans_date->toArray();

            $trans_date =  $trans_date['TransDate'];
  
        if (is_null($trans_date)) { //cek hasil query
            return '';    
        }


        $forecast = Forecast::select(DB::raw('
            TransDate as trans_date,
            RT,
            SuppCode,
            PartNo,
            DTQTY30 as month1,
            DTQTY31 as month2,
            DTQTY32 as month3,
            DTQTY33 as month4,
            DTQTY34 as month5
        '))->where('RT', '=', 'D' );

        $forecast = $forecast->where('TransDate','=', $trans_date);    

        // $forecast = $forecast->where('PartNo','like', $PartNo . '%');
        $forecast = $forecast->where('PartNo','=', $PartNo);

        $forecast = $forecast->get();

        $forecast->each(function($model){
            $model->total = ($model->month1+$model->month2+$model->month3+$model->month4+$model->month5);
        });

        return $forecast;
    }

    public function partWithHighestTotalDelivery($trans_date = null){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $parts = $this->parts;

        $highest_total_delivery = 0;

        foreach ($parts as $key => $part) {
            $part->detail; //get part_details
                
            $total_delivery = $part->first_value;

            if (isset( $part->detail->total_delivery )) {
                $total_delivery += $part->detail->total_delivery;     
            }

            /*there will be a serious problem if user set two part suffix and not suffix in the same tools. the result of this logic will not apply properly*/

            //cek if it's suffix number or not
            if ($part->pivot->is_independent == "0" || $part->pivot->is_independent == 0 ) {
                if ($highest_total_delivery < $total_delivery ) {
                   $highest_total_delivery = $total_delivery;
                }
            }else {
                $highest_total_delivery += $total_delivery;
                //if it's not suffix number, get the forecast, then summary 
            }

            $part->total_delivery = $highest_total_delivery;
            //ceil itu pembulatan ke atas. in case hasilnya 12.5 maka akan jadi 13;
            $part->total_shoot_based_on_part = ceil($highest_total_delivery / (int) $part->pivot->cavity) ;
            $result = $part;
        
        }

        if (!isset($result)) {
            $result = null;
        }

        if ($part->pivot->is_independent == "0" || $part->pivot->is_independent == 0 ) {
            $this->forecast_result = $this->forecast($part->no , $trans_date ); 
        }

        $this->part = $result;
    }
        
    public function toolpart(){
        $id = $this->id;

        $toolpart = ToolPart::where('tool_id', '=', $id )->get();
        $toolpart->each(function($model){
            //get the highest total shoot
            $model->parts();
            $model->tools();

        });

        $this->toolpart = $toolpart;

        return $this;
    }

    public function machines(){
        return $this->hasMany('App\Machine');
    }

    public function machine(){
        // $machine = Machine::select()
    }

    public function hasToolPart(){
        $toolpart = ToolPart::where('tool_id', '=', $this->id )->get();
        return !$toolpart->isEmpty(); //return true if it's not empty
    }

    public function details($trans_date = null){ //get all detail
    	return $this->hasMany('App\Tool_detail');
    }

    public function detail($trans_date = null){ //get all detail
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        return $this->hasOne('App\Tool_detail')
        ->where('trans_date', $trans_date )
        ->orderBy('total_shoot', 'desc');
    }

    public function getHighestTotalShoot(){
        return $this->hasOne('App\Tool_detail')->orderBy('total_shoot', 'desc');
    }
 
    public function detailBackUp($tool_id, $trans_date = null){ //get detail with specific trans date
        if (!isset($tool_id)) {
            return false;
        }

        if (!isset($trans_date)) {
            return false;
        }

        $Tool_detail = Tool_detail::select([
            'tool_id',
            'total_shoot',
            'guarantee_after_forecast',
            'balance_shoot',
            'trans_date',
        ])
        ->where('trans_date', '=', $trans_date )
        ->where('tool_id', '=', $tool_id )
        ->first();
        
        if ( is_null( $Tool_detail ) ) {
            # isi dulu // hitung melalui pck31
            $this->detail = null;
        }else {
            //langsung return
            $this->detail = $Tool_detail;
        }
    }

    protected static function boot() { //cascade on soft delete
        parent::boot();

        static::deleting(function($tool) {
            $id = $tool->id;
            $toolpart = ToolPart::where('tool_id', '=', $id )->get();
            $toolpart->each(function($model){
                $model->delete();
            });
            
        });
    }
}
