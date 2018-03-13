<?php

use Illuminate\Database\Seeder;
use App\Part;
use App\Tool;
use App\ToolPart;

class Toolpart extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tool = Tool::all();
        $part = Part::all();

        for ($i=0; $i < 100 ; $i++) { 
        	$tool_id = $tool[ ceil( rand(0,100 ) )]->id;
        	$part_id = $part[ ceil( rand(0,100 ) )]->id;

        	$toolPart = new ToolPart;
        	$toolPart->tool_id = $tool_id;
        	$toolPart->part_id = $part_id;
        	$toolPart->save();
        	
        }
    }
}
