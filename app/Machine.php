<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    public function tools(){
    	return $this->belongsTo('App\Tool');
    }
}
