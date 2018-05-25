<?php

namespace App;
use App\Part;
use App\Tool;
use App\Tool_detail;
use App\Machine;
use App\Forecast;
use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ToolPart extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates  = ['deleted_at'];
    protected $table  = 'tool_part';

    protected $casts = [
        'part_id' => 'integer',
        'tool_id' => 'integer',
        'cavity' => 'float',
        'is_independent' => 'integer'
    ];

    protected $fillable =[
        'tool_id',
        'part_id',
        'cavity',
        'is_independent',
    ];

    public function tool(){
        return $this->hasOne('App\Tool', 'id', 'tool_id'); //model, id of foreign key, id of it's model primarry key
    }

    public function part(){
        return $this->hasOne('App\Part', 'id', 'part_id'); //model, foreign key, local_id;
    }
}
