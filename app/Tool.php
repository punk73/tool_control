<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ToolPart;
use App\Part;
use App\Tool_detail;
use App\Machine;

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

    public function partWithHighestTotalDelivery($trans_date = null){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $parts = $this->parts;

        $highest_total_delivery = 0;

        foreach ($parts as $key => $part) {
            $part->detail;
            
            $total_delivery = $part->first_value;

            if (isset( $part->detail->total_delivery )) {
                $total_delivery += $part->detail->total_delivery;     
            }

            if ($highest_total_delivery < $total_delivery ) {
               $highest_total_delivery = $total_delivery;
               
               $part->total_delivery = $highest_total_delivery;

               $result = $part;
            }   

        }

        if (!isset($result)) {
            $result = null;
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
