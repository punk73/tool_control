<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{	

	protected $hidden = ['is_deleted'];

    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }

    public function tools()
    {
        return $this->belongsToMany('App\Tool', 'tool_part');
    }
}
