<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Part_relation;
use DB;

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
        ])->orderBy('id', 'desc');


        // FILTERING CODING
            if (isset($request->children_part_id) && $request->children_part_id != null ) {
                $part_relation = $part_relation->where('children_part_id', $request->children_part_id );            
            }

            if (isset($request->parent_part_id) && $request->parent_part_id != null ) {
                $part_relation = $part_relation->where('parent_part_id', $request->parent_part_id );            
            }

            if (isset($request->children_part_no) && $request->children_part_no != null ) {
                $part_relation = $part_relation->whereHas('childrenPart', function($children) use ($request){
                    $children->where('no', 'like', $request->children_part_no . '%' );
                });            
            }

            if (isset($request->parent_part_no) && $request->parent_part_no != null ) {
                $part_relation = $part_relation->whereHas('parentPart', function($parent) use ($request){
                    $parent->where('no', 'like', $request->parent_part_no . '%' );
                });            
            }
        // END OF FILTERING CODING       

        $part_relation = $part_relation->paginate($limit);
    	$message = 'OK';


    	
        /**/
        return $part_relation;

    	/*return [
            "_meta" => [
                "count" => count($part_relation),
                "message" => $message
            ],
            "data" => $part_relation
        ];*/
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

    public function download(){
        $do = DB::table('part_relations');

        $do = $do->select([
            'part_relations.id',
            // 'part_relations.children_part_id',
            'children.no as children_part_no',
            // 'part_relations.parent_part_id',
            'parent.no as parent_part_no',
        ])->where('parent.deleted_at', null)
        ->where('children.deleted_at', null)
        ->join('parts as children', 'part_relations.children_part_id', '=', 'children.id')
        ->join('parts as parent', 'part_relations.parent_part_id', '=', 'parent.id')
        ->get();

        // return $do;
        $fname = 'Semi_Parts.csv';

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$fname");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $fp = fopen("php://output", "w");
        
        $headers = 'id,children_part_no,parent_part_no'."\n";

        fwrite($fp,$headers);

        foreach ($do as $key => $value) {
            # code...
            $row = [
                $value->id,
                $value->children_part_no,
                $value->parent_part_no,
                
            ];
            
            fputcsv($fp, $row);
        }

        fclose($fp);
    }
}
