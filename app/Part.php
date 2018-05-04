<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ToolPart;
use App\Pck31;
use App\Part_detail;
use Carbon\Carbon;
use DB;

class Part extends Model
{	
	use SoftDeletes;

	// protected $dates = ['deleted_at'];
    protected $hidden = ['is_deleted', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'first_value' => 'integer',
        'total_delivery' => 'integer',
        'total_qty' => 'integer'
    ];

    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }

    public function pck31($partNo=null, $startDate = null, $finishDate = null){
        //setup startDate
        if (is_null($startDate)) {
            $startDate = '1990/01/01';
        }else{
            $startDate = Carbon::parse($startDate)->format('Y/m/d');
        }

        //setup finish date
        if (is_null($finishDate)) {
            $finishDate = date('Y/m/d');
        }else{
            $finishDate = Carbon::parse($finishDate)->format('Y/m/d');
        }

        // return $startDate;
        if (is_null($partNo)) {
            $partNo = $this->no;                  
        }

        $pck31 = Pck31::select(
            DB::raw('month,part_no,sum(qty) as total_qty')
        )
        ->where('part_no', $partNo )
        ->whereBetween('input_date', [$startDate, $finishDate ] )
        ->groupBy('part_no')
        ->groupBy('month');

        $pck31= $pck31->first();
        return $pck31;
    }

    public function tools()
    {
        return $this->belongsToMany('App\Tool', 'tool_part')
        // ->withTimestamps()
        ->withPivot('cavity', 'is_independent');
    }

    public function parentParts(){
        return $this->hasMany('App\Part_relation', 'children_part_id' )->with('parentPart');
    }

    public function details(){
        return $this->hasMany('App\Part_detail');
    }

    public function detail($trans_date = null){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        return $this->hasOne('App\Part_detail')
        ->where('trans_date','=', $trans_date )
        ->orderBy('total_delivery', 'desc'); //menurun

    }

    public function detailBackup(){
        $id = $this->id;
        $part_detail = Part_detail::select([
            'total_delivery',
            'total_qty',
            'trans_date'
        ])->where('part_id', '=', $id )
        ->orderBy('trans_date', 'desc')
        ->first();
        
        return $part_detail;
    }

    public function getHighestTotalDelivery(){
        //dengan order by, maka yang pertama muncul adalah yang paling gede
        return $this->hasOne('App\Part_detail')->orderBy('total_delivery', 'desc');
    }

    protected static function boot() { //cascade on soft delete
        parent::boot();

        static::deleting(function($part) {
            $id = $part->id;
            $toolpart = ToolPart::where('part_id','=', $id )->get();
            $toolpart->each(function($model){
                $model->delete();
            });
        });
    }
}
