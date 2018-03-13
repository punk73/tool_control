<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    //
    protected $hidden = ['is_deleted'];
    
    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }

    public function parts()
    {
        return $this->belongsToMany('App\Part', 'tool_part');
    }
}
