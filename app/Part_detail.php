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
}
