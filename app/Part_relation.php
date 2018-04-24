<?php

namespace App;
use App\Part;
use Illuminate\Database\Eloquent\Model;

class Part_relation extends Model
{
    //
    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function parentPart(){
    	/*$parent_id = $this->parent_part_id;
    	$part = Part::select([
    		'name',
    		'no'
    	])->find($parent_id);
    	$this->parent_part = $part;
    	return $this;*/
        return $this->hasOne('App\Part', 'id', 'parent_part_id');
        //$this->hasOne('model', 'foreign_key', 'localkey');
    }

    /*public function childrenPart(){
    	$children_id = $this->children_part_id;
    	$part = Part::select([
    		'name',
    		'no'
    	])->find($children_id);
    	$this->children_part = $part;
    	return $this;
    }*/

    public function childrenPart(){
        return $this->hasOne('App\Part', 'id', 'children_part_id');
    }

    public function part(){
        return $this->belongsTo('App\Part');
    }


}
