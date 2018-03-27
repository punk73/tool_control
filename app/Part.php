<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ToolPart;
use App\Pck31;

class Part extends Model
{	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $hidden = ['is_deleted'];

    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }

    public function tools()
    {
        return $this->belongsToMany('App\Tool', 'tool_part')->withTimestamps();
    }

    public function pck31(){

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
