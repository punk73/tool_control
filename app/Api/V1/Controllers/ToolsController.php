<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Tool;



class ToolsController extends Controller
{
    use Helpers;

    public function index(Request $request){

    	$tool = Tool::where('is_deleted', '=' , 0);
        $message = 'OK';

    	if (isset($request->supplier_id) && $request->supplier_id != "" ) {
    		$tool = $tool->where('supplier_id', '=', $request->supplier_id );
    	}

        if (isset($request->no) && $request->no != "" ) {
            $tool = $tool->where('no', '=', $request->no );
            
        }

    	$tool = $tool->paginate();

    	$additional_message = collect(['_meta'=> [
            'message'=>$message,
            'count'=> count($tool)
        ] ]);

        $tool = $additional_message->merge($tool)->toArray();
        return $tool;
    }

    public function all(){
        $tool = Tool::where('is_deleted', '=' , 0);
        $message = 'OK';

        $tool = $tool->get();
        
        return [
            '_meta' =>[
                'count' => count($tool),
                'message' => $message
            ],
            'data' => $tool
        ];
    }

    public function show($id){
    	$tool = Tool::find($id);
        
        if (!empty($tool) && $tool->is_deleted == 0 ) {
            $parts = Tool::find($id)->parts;
            $details = Tool::find($id)->details;

            $tool->details = $details;
            $tool->parts = $parts;
            
            $message = "OK";
        }else{
            $message = 'Data not found';
            $tool = null;
        }

        return [
            "_meta" => [
                "count" => count($tool),
                "message" => $message
            ],
            "data" => $tool
        ];
    }

    public function store(Request $request){
    	$tool = new Tool;
        $tool->no = $request->no;
        $tool->name = $request->name;
        $tool->supplier_id = $request->supplier_id;
        $tool->no_of_tooling = $request->no_of_tooling;
        $tool->total_shoot = $request->total_shoot;
        $tool->guarantee_shoot = $request->guarantee_shoot;
        $tool->guarantee_remains = $request->guarantee_remains;
        $tool->delivery_date = $request->delivery_date;
        $tool->balance_shoot = $request->balance_shoot;

        try {
            $tool->save();
            $message = 'OK';
        } catch (Exception $e) {
            $message = $e;
        }

        return [
            "_meta" => [
                "count" => count($tool),
                "message" => $message
            ],
            "data" => $tool
        ];
    }

    public function update(Request $request, $id){
    	$tool = Tool::find($id);
        //jika ada dan part belum dihapus
        if ( !empty($tool) && $tool->is_deleted == 0 ) {
            // $retVal = (condition) ? a : b ;
            $tool->no =  (isset($request->no) ) ? $request->no : $tool->no;
            
            $tool->name = (isset($request->name) ) ? $request->name : $tool->name;

            $tool->supplier_id = (isset($request->supplier_id) ) ? $request->supplier_id : $tool->supplier_id;

            $tool->no_of_tooling = (isset($request->no_of_tooling) ) ? $request->no_of_tooling : $tool->no_of_tooling;
            
            $tool->total_shoot = (isset($request->total_shoot) ) ? $request->total_shoot : $tool->total_shoot;

            $tool->guarantee_shoot = (isset($request->guarantee_shoot) ) ? $request->guarantee_shoot : $tool->guarantee_shoot;

            $tool->guarantee_remains = (isset($request->guarantee_remains) ) ? $request->guarantee_remains : $tool->guarantee_remains;
			
			$tool->delivery_date = (isset($request->delivery_date) ) ? $request->delivery_date : $tool->delivery_date;
            
            $tool->balance_shoot = (isset($request->balance_shoot) ) ? $request->balance_shoot : $tool->balance_shoot;


            try {
                $tool->save();
                $message = 'OK';
            } catch (Exception $e) {
                $message = $e;
            }

        }else{ //jika tidak ada atau data sudah dihapus
            $message = "Data not found";
            $tool = null;
        }

        return [
            "_meta" => [
                "count" => count($tool),
                "message" => $message
            ],
            "data" => $tool
        ];
    }

    public function delete($id){
    	$tool = Tool::find($id);
        if (!empty($tool) ) {
            $tool->is_deleted = 1;
            $tool->save();
            $message = "OK";
        }else{
            $message = "Data not found";
        }

        return [
            "_meta" => [
                "count" => count($tool),
                "message" => $message,
            ]
        ];
    }

}
