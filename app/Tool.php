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
    protected $hidden = ['is_deleted'];
    
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
 
    public function detail($tool_id, $trans_date = null){ //get detail with specific trans date
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
