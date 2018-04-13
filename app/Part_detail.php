<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part_detail extends Model
{
    protected $casts = [
        'first_value' => 'integer',
        'total_delivery' => 'integer',
        'total_qty' => 'integer'
    ];

    public function part(){
    	return $this->belongsTo('App\Part');
    }

    public function pck31 (){
    	//get summary of pck31 where part no = $part_no and date untill $date
    	
    }
}
