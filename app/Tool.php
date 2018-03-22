<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ToolPart;

class Tool extends Model
{
    //
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $hidden = ['is_deleted'];
    
    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }

    public function parts()
    {
        return $this->belongsToMany('App\Part', 'tool_part');
    }

    public function details(){
    	return $this->hasMany('App\Tool_detail');
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
