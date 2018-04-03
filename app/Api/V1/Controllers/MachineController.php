<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Machine;

class MachineController extends Controller
{
    public function index(){
    	$message = 'OK';
    	$Machine = Machine::select();

        try {
            $Machine = $Machine->get();
        } catch (Exception $e) {
            $message = $e;   
        }
            
    	return [
            '_meta' => [
                'count' => count($Machine),
                'message' => $message
            ],
            'data' =>    $Machine
        ];
    }



    public function store(Request $request){
    	$Machine = new Machine;
    	$Machine->tool_id = $request->tool_id;
    	$Machine->counter = $request->machine_counter;
    	$Machine->tanggal = $request->tanggal;
    	$Machine->note = $request->note;

    	$message = "OK";

    	try {
    		$Machine->save();
    	} catch (Exception $e) {
    		$message = $e;
    	}

    	return [
    		'_meta'=>[
    			'count' => count($Machine),
    			'message' => $message
    		],
    		'data' => $Machine
    	];

    }
}
