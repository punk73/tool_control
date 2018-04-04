<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool_detail extends Model
{
    //
    public function tool(){
    	return $this->belongsTo('App\Tool');
    }

    protected $casts = [ 
        'total_shoot' => 'integer', 
        'balance_shoot' => 'integer', 
        'guarantee_after_forecast' => 'float'
    ];
}
