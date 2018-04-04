<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pck31 extends Model
{
    //
    protected $table = 'pck31s';

    protected $dates = ['input_date'];
    protected $casts =['total_qty' => 'integer'];
}
