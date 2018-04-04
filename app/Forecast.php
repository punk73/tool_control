<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'ForecastN';
    protected $casts = [ 
        'month1' => 'integer', 
        'month2' => 'integer',
        'month3' => 'integer',
        'month4' => 'integer',
        'month5' => 'integer',

    ];
}
