<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    
    protected $casts = [
    	'counter' => 'integer'
    ];

    public function tools(){
    	return $this->belongsTo('App\Tool');
    }


}
