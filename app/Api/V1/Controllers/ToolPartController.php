<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ToolPart;
use App\Tool;
use App\Part;
use DB;

class ToolPartController extends Controller
{
    //

    public function index(Request $request){
    	$toolPart = ToolPart::with([
            'tool:id,no,name,supplier_id', 
            'part:id,no,name',
            'tool.supplier:id,name,code'
        ]);
    
    	$message = 'OK';

        if (isset($request->limit)) {
            $limit = $request->limit;
        }else{
            $limit = 25;
        }


        //searching tool number first
        if ($request->tool_number && $request->tool_number !='' ) {
            $toolPart = $toolPart->whereHas('tool', function ($query) use ($request){
                $query->where('no', 'like', $request->tool_number . '%' );
            });
        }

        if ($request->part_number && $request->part_number != '' ) {
            $toolPart = $toolPart->whereHas('part', function($query) use($request){
                $query->where('no', 'like', $request->part_number  . '%');
            });
        }

        if ($request->supplier_name && $request->supplier_name != '' ) {
            $toolPart = $toolPart->whereHas('tool.supplier', function($query) use($request){
                $query->where('name', 'like', $request->supplier_name  . '%' );
            });
        }

        if ($request->cavity) {
            $toolPart = $toolPart->where('cavity', '=', $request->cavity );
        }

    	if ($request->tool_id) {
    		$toolPart = $toolPart->where('tool_id', '=', $request->tool_id );
    	}

		if ($request->part_id) {
    		$toolPart = $toolPart->where('part_id', '=', $request->part_id );
    	}    	

    	$toolPart = $toolPart->orderBy('id', 'desc')->paginate($limit);

        return $toolPart;

    	/*return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		],
    		'data' => $toolPart
    	];*/
    }

    public function store(Request $request){
    	
        /*$toolPart = new ToolPart;
    	$toolPart->part_id = $request->part_id;
    	$toolPart->tool_id = $request->tool_id;
        $toolPart->is_independent = $request->is_independent;
        $toolPart->cavity = $request->cavity;*/

        $tool = Tool::find($request->tool_id);
        
    	$message = 'OK';

    	try {
            
            if ($request->cavity == 0 ) {
                $request->cavity = 1;
            }

            $tool->parts()->attach($request->part_id , [
                'is_independent' => $request->is_independent,
                'cavity' => $request->cavity
            ]);

            $toolpart = ToolPart::with([
                'tool' => function($query){
                    $query->select([
                        'id',
                        'no'
                    ]);
                },

                'part' => function($query){
                    $query->select([
                        'id',
                        'no'
                    ]);
                },

            ])->where('tool_id', $tool->id )
            ->where('part_id', $request->part_id )
            ->first();

            if (!empty($toolpart)) {

                $tool = $toolpart;
            }

    	} catch (Exception $e) {
    		$message = $e;
    	}

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($tool)
    		],
    		'data' => $tool
    	];
    }

    public function delete($id){


    	$toolPart = ToolPart::find($id);
    	
        if (!empty($toolPart)) {
    		$toolPart->forceDelete(); 

            //softdelete causing some problem with relation
    		/* so instead using delete() we using forceDelete to permanently delete toolpart instead of using soft delete*/
            $message = 'OK';
    	}else{
    		$message = 'Data not found';
    	}

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		]
    	];
    }

    public function update (Request $request, $id){
        $toolpart = ToolPart::find($id);

        if (!empty($toolpart)) {

            $toolpart->is_independent = (isset($request->is_independent)) ? $request->is_independent : $toolpart->is_independent;
            
            
            $toolpart->cavity = (isset($request->cavity)) ? $request->cavity : $toolpart->cavity;

            //cek supaya toolpart cavity tidak 0
            if ($toolpart->cavity == 0) {
                $toolpart->cavity = 1;
            }

            $message = 'OK';

            try {
                $toolpart->save();        
            } catch (Exception $e) {
                $message = $e;
            }
        }

        return [
            '_meta' => [
                'message' => $message,
                'count' => count($toolpart)
            ],
            'data' => $toolpart
        ];
    }

    public function download(){
        $do = DB::table('tool_part');
        // return $do->get();

        $do = $do->select([
            'tool_part.id',
            // 'tool_id',
            'tool.no as tool_no',
            // 'part_id',
            'part.no as part_no',
            'cavity',
            'is_independent',
        ])->where('part.deleted_at', null)
        ->where('tool.deleted_at', null)
        ->join('parts as part', 'tool_part.part_id', '=', 'part.id')
        ->join('tools as tool', 'tool_part.tool_id', '=', 'tool.id')
        ->get();

        // return $do;

        $fname = 'Cavity.csv';

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$fname");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $fp = fopen("php://output", "w");
        
        $headers = 'id,tool_no,part_no,cavity,is_suffix_number'."\n";

        fwrite($fp,$headers);

        foreach ($do as $key => $value) {
            # code...
            $row = [
                $value->id,
                $value->tool_no,
                $value->part_no,
                $value->cavity,
                $value->is_independent,
            ];
            
            fputcsv($fp, $row);
        }

        fclose($fp);
    }

}
