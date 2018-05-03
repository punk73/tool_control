<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Part_relation;

class PartRelationController extends Controller
{
    public function index(Request $request){
        if (isset($request->limit)) {
            $limit = $request->limit;
        }else{
            $limit = 25;
        }

    	$part_relation = Part_relation::with([
            
            'parentPart' =>  function($query){
                $query->select([
                    'id',
                    'no',
                    'name',
                ]);
            },

            'childrenPart' =>  function($query){
                $query->select([
                    'id',
                    'no',
                    'name',
                ]);
            }
        ])->orderBy('id', 'desc')->get();
    	$message = 'OK';
    	
        /**/

    	return [
            "_meta" => [
                "count" => count($part_relation),
                "message" => $message
            ],
            "data" => $part_relation
        ];
    }

    public function store(Request $request){
    	$part_relation = new Part_relation;
    	$part_relation->parent_part_id = $request->parent_part_id;
    	$part_relation->children_part_id = $request->children_part_id;
    	
    	try {
    		$part_relation->save();
    		$message = 'OK';

            $part_relation->parentPart;
            $part_relation->childrenPart;


    	} catch (Exception $e) {
    		$message = $e;
    	}

    	return [
            "_meta" => [
                "count" => count($part_relation),
                "message" => $message
            ],
            "data" => $part_relation
        ];
    }

    public function update(Request $request){
    	$part_relation = Part_relation::find($request->id);
    	$part_relation->parent_part_id = $request->parent_part_id;
    	$part_relation->children_part_id = $request->children_part_id;
    	
    	try {
    		$part_relation->save();
    		$message = 'OK';
    	} catch (Exception $e) {
    		$message = $e;
    	}
    	
    	return [
            "_meta" => [
                "count" => count($part_relation),
                "message" => $message
            ],
            "data" => $part_relation
        ];
    }

    public function delete(Request $request){
    	$part_relation = Part_relation::find($request->id);
    	if (!empty($part_relation)) {
    		$message = 'OK';
    		$part_relation->delete();
    	}else{
    		$message = 'data not found';
    	}

    	return [
    		'_meta' => [
    			"count" => count($part_relation),
    			'message' => $message
    		]
    	];
    }
}
