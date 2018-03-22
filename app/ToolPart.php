<?php

namespace App;
use App\Part;
use App\Tool;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ToolPart extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table='tool_part';

    public function tools($id){
    	if (!isset($id)) {
    		return [];
    	}

    	$tool = Tool::find($id);

    	return $tool;
    }

    public function parts($id){
    	if (!isset($id)) {
    		return [];
    	}

    	$part = Part::find($id);

    	return $part;
    }
}
