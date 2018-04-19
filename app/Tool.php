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
        ->with('parentPart')
        ->withPivot('cavity', 'is_independent');
    }

    public function forecast($PartNo, $trans_date = null ){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $trans_date = Carbon::createFromFormat('Y-m-d', $trans_date )->format('m/d/Y');

        $forecast = Forecast::select(DB::raw('
            TransDate as trans_date,
            SuppCode,
            PartNo,
            DTQTY30 as month1,
            DTQTY31 as month2,
            DTQTY32 as month3,
            DTQTY33 as month4,
            DTQTY34 as month5,
            (cast(ltrim(DTQTY30) as int) + cast(ltrim(DTQTY31) as int) + cast(ltrim(DTQTY32) as int) + cast(ltrim(DTQTY33) as int) + cast(ltrim(DTQTY34) as int))  as total
        '))->where('RT', '=', 'D' );

        $forecast = $forecast->whereRaw('rtrim(PartNo) = ?', [ trim($PartNo) ] )
        ->whereRaw('TransDate = (select top 1 transDate from ForecastN where TransDate <= ?)', [$trans_date] ); // ? = parameter yg akan diganti oleh trim($partNo)

        $forecast = $forecast->first();

        if (empty( $forecast) ) {
            //harus diset as object karena eloquent return nya object
            $forecast = (object) [
                'trans_date' => $trans_date,
                'SuppCode' => null,
                'PartNo' => $PartNo,
                'month1' => 0,
                'month2' => 0,
                'month3' => 0,
                'month4' => 0,
                'month5' => 0,
                'total' => 0
            ];
        }

        return $forecast;
    }

    public function partWithHighestTotalDelivery($trans_date = null){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $parts = $this->parts;

        $highest_total_delivery = 0;
        // setting variable for not suffix number
            $month1 = 0;
            $month2 = 0;
            $month3 = 0;
            $month4 = 0;
            $month5 = 0;
            $total = 0;
        //
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
                $forecast = $this->forecast($part->no, $trans_date );
                if ($forecast != null) {
                    # code...
                    $month1 += $forecast->month1;
                    $month2 += $forecast->month2;
                    $month3 += $forecast->month3;
                    $month4 += $forecast->month4;
                    $month5 += $forecast->month5;
                    $total += $forecast->total;
                    $PartNo = $forecast->PartNo;
                }
            }

            $part->total_delivery = $highest_total_delivery;
            //ceil itu pembulatan ke atas. in case hasilnya 12.5 maka akan jadi 13;
            $part->total_shoot_based_on_part = ceil($highest_total_delivery / (int) $part->pivot->cavity) ;
            $result = $part;
        }

        //what happen if result == null ??
        if (!isset($result)) {
            $result = null;
        }

        //get forecast

        if ($result->pivot->is_independent == "0" || $result->pivot->is_independent == 0 ) {
            $this->forecast = $this->forecast($result->no , $trans_date ); 
        }else {
            //setup forecast untuk yang suffix number
            $this->forecast = (object) [
                'trans_date' => $trans_date,
                'SuppCode' => null,
                'PartNo' => $PartNo,
                'month1' => $month1,
                'month2' => $month2,
                'month3' => $month3,
                'month4' => $month4,
                'month5' => $month5,
                'total' => $total
            ];
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
