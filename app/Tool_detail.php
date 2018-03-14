<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool_detail extends Model
{
    //
    public function tool(){
    	return $this->belongsTo('App\Tool');
    }
}
