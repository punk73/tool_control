<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        $api->get('auth/me', 
            function() {
                $user = Auth::user();
                $user->default_line;
                return $user->toArray();
            }
        );

        $api->group(['prefix' => 'suppliers'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\SuppliersController@index' );
            $api->get('/all', 'App\\Api\\V1\\Controllers\\SuppliersController@all' );
            $api->get('/{id}', 'App\\Api\\V1\\Controllers\\SuppliersController@show' );
        });

        $api->group(['prefix' => 'parts'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\PartsController@index' );
            $api->get('/all', 'App\\Api\\V1\\Controllers\\PartsController@all' );
            $api->post('/', 'App\\Api\\V1\\Controllers\\PartsController@store' );
            $api->put('/{id}', 'App\\Api\\V1\\Controllers\\PartsController@update' );
            $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\PartsController@delete' );
            $api->get('/{id}', 'App\\Api\\V1\\Controllers\\PartsController@show' );
        });

        $api->group(['prefix' => 'tools'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\ToolsController@index' );
            $api->get('/all', 'App\\Api\\V1\\Controllers\\ToolsController@all' );
            $api->post('/', 'App\\Api\\V1\\Controllers\\ToolsController@store' );
            $api->put('/{id}', 'App\\Api\\V1\\Controllers\\ToolsController@update' );
            $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\ToolsController@delete' );
            $api->get('/{id}', 'App\\Api\\V1\\Controllers\\ToolsController@show' );
        });

        $api->group(['prefix' => 'tool_details'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\ToolDetailController@index' );
        });

        $api->group(['prefix' => 'part_details'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\PartDetailController@index' );
        });

        $api->group(['prefix' => 'toolparts'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\ToolPartController@index' );
            $api->post('/', 'App\\Api\\V1\\Controllers\\ToolPartController@store' );
            $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\ToolPartController@delete' );
            $api->put('/{id}', 'App\\Api\\V1\\Controllers\\ToolPartController@update' );
        });

        $api->group(['prefix' => 'datas'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\DataController@index' );
            $api->get('/count', 'App\\Api\\V1\\Controllers\\DataController@getCount' );
            $api->get('/{tool_id}', 'App\\Api\\V1\\Controllers\\DataController@show' );

        });

        $api->group(['prefix' => 'machines'], function(Router $api){ //machine counter
            $api->get('/', 'App\\Api\\V1\\Controllers\\MachineController@index' );
            $api->post('/', 'App\\Api\\V1\\Controllers\\MachineController@store' );
        });

        $api->group(['prefix' => 'forecasts'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\ForecastController@index' );
        });

        $api->group(['prefix' => 'pck31s'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\Pck31Controller@index' );
            $api->get('/sync', 'App\\Api\\V1\\Controllers\\Pck31Controller@sync' );
            $api->get('/copy', 'App\\Api\\V1\\Controllers\\Pck31Controller@copy' );
        });

        $api->group(['prefix' => 'part_relations'], function(Router $api){
            $api->get('/', 'App\\Api\\V1\\Controllers\\PartRelationController@index' );
            $api->post('/', 'App\\Api\\V1\\Controllers\\PartRelationController@store' );
            $api->put('/{id}', 'App\\Api\\V1\\Controllers\\PartRelationController@update' );
            $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\PartRelationController@delete' );
        });    

    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
    
});
