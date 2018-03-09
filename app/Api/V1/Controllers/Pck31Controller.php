<?php

namespace App\Api\V1\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Dingo\Api\Routing\Helpers;

class Pck31Controller extends Controller
{
    //
    public function getcsv(){
        $path = storage_path('app\data.csv');
        $file = fopen($path, "r");
        $array = array();
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ) {

            /*$name = $data[0];
            $city = $data[1];
            $all_data = $name. " ".$city;*/

            array_push($array, $data[1]);

          }
        fclose($file);

        return $array;
    }
}
