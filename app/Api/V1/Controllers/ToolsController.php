<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Tool;
use DB;
use JWTAuth;


class ToolsController extends Controller
{
    use Helpers;

    public function index(Request $request){
        $limit = (isset($request->limit)) ? $request->limit : 15 ;

    	$tool = Tool::where('is_deleted', '=' , 0);
        $message = 'OK';

        if (isset($request->supplier_id) && $request->supplier_id != "" && $request->supplier_id != null ) {

            /*for auth purpose but we can handle it by simply always sending supplier id as paramter;*/

    		// $currentUser = JWTAuth::parseToken()->authenticate();
            // return $currentUser;
            /*if (  $currentUser->access_level == 3 && $currentUser->supplier_id != null && ($currentUser->supplier_id == $request->supplier_id) ) {
                $tool = $tool->where('supplier_id', '=', $request->supplier_id );
            }else {
                $tool = $tool->where('supplier_id', '=', $request->supplier_id );
            }*/

            $tool = $tool->where('supplier_id', '=', $request->supplier_id );

    	}

        if (isset($request->no) && $request->no != "" ) {
            $tool = $tool->where('no', '=', $request->no );
            
        }

    	$tool = $tool->orderBy('id', 'desc')->paginate($limit);

    	$additional_message = collect(['_meta'=> [
            'message'=>$message,
            'count'=> count($tool)
        ] ]);

        $tool = $additional_message->merge($tool)->toArray();
        return $tool;
    }

    public function all(Request $request){
        $limit = (isset($request->limit)) ? $request->limit : 1000 ;

        $tool = Tool::select([
            'id',
            'no',
            'name',
            'no_of_tooling',
            
        ])->where('is_deleted', '=' , 0);

        if ($request->get('query') !== null ) {
            
            $tool = $tool->where('no', 'like', $request->get('query').'%' );
        }

        if ($request->get('supplier_id') !== null && preg_match('/^\d+$/', $request->supplier_id ) ) {   
            $tool = $tool->where('supplier_id', '=', $request->get('supplier_id') );
        }


        $message = 'OK';

        $tool = $tool->orderBy('id', 'desc')->get();
        // $tool = $tool->paginate($limit);
        
        // return $tool;
        
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
        $tool->guarantee_shoot = $request->guarantee_shoot;
        $tool->delivery_date = $request->delivery_date;
        $tool->start_value = $request->start_value;
        $tool->start_value_date = $request->start_value_date;
        
        // $tool->total_shoot = $request->total_shoot;
        // $tool->guarantee_remains = $request->guarantee_remains;
        // $tool->balance_shoot = $request->balance_shoot;

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
            
            $tool->guarantee_shoot = (isset($request->guarantee_shoot) ) ? $request->guarantee_shoot : $tool->guarantee_shoot;
            
            $tool->delivery_date = (isset($request->delivery_date) ) ? $request->delivery_date : $tool->delivery_date;

            $tool->start_value_date = (isset($request->start_value_date) ) ? $request->start_value_date : $tool->start_value_date;

            // $tool->total_shoot = (isset($request->total_shoot) ) ? $request->total_shoot : $tool->total_shoot;

            // $tool->guarantee_remains = (isset($request->guarantee_remains) ) ? $request->guarantee_remains : $tool->guarantee_remains;
            
            
            // $tool->balance_shoot = (isset($request->balance_shoot) ) ? $request->balance_shoot : $tool->balance_shoot;


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
            // $tool->save();
            
            $tool->delete();
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

    public function download(){
        $do = DB::table('tools');

        $do = $do->select([
            'tools.id',
            'no',
            'tools.name',
            'no_of_tooling',
            'start_value',
            'guarantee_shoot',
            'delivery_date',
            'start_value_date',
            'suppliers.name as supplier_name',
        ])->where('deleted_at', null)
        ->join('suppliers', 'tools.supplier_id', '=', 'suppliers.id')
        ->get();

        // return $do;

        $fname = 'Tools.csv';

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$fname");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $fp = fopen("php://output", "w");
        
        $headers = 'id,no,name,no_of_tooling,start_value,guarantee_shoot,delivery_date,start_value_date,supplier_name'."\n";

        fwrite($fp,$headers);

        foreach ($do as $key => $value) {
            # code...
            $row = [
                $value->id,
                $value->no,
                $value->name,
                $value->no_of_tooling,
                $value->start_value,
                $value->guarantee_shoot,
                $value->delivery_date, 
                $value->start_value_date, 
                $value->supplier_name, 
                 
            ];
            
            fputcsv($fp, $row);
        }

        fclose($fp);
    }

}
