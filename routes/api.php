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


    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });

    $api->group(['prefix' => 'suppliers'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\SuppliersController@index' );
        $api->get('/{id}', 'App\\Api\\V1\\Controllers\\SuppliersController@show' );

        // $api->post('/', 'App\\Api\\V1\\Controllers\\SuppliersController@store' );
        // $api->put('/{id}', 'App\\Api\\V1\\Controllers\\SuppliersController@update' );
        // $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\SuppliersController@delete' );
    });

    $api->group(['prefix' => 'parts'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\PartsController@index' );
        $api->post('/', 'App\\Api\\V1\\Controllers\\PartsController@store' );
        $api->put('/{id}', 'App\\Api\\V1\\Controllers\\PartsController@update' );
        $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\PartsController@delete' );
        $api->get('/{id}', 'App\\Api\\V1\\Controllers\\PartsController@show' );
    });

    $api->group(['prefix' => 'tools'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\ToolsController@index' );
        $api->post('/', 'App\\Api\\V1\\Controllers\\ToolsController@store' );
        $api->put('/{id}', 'App\\Api\\V1\\Controllers\\ToolsController@update' );
        $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\ToolsController@delete' );
        $api->get('/{id}', 'App\\Api\\V1\\Controllers\\ToolsController@show' );
    });

    $api->group(['prefix' => 'toolpart'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\ToolPartController@index' );
        $api->post('/', 'App\\Api\\V1\\Controllers\\ToolPartController@store' );
        $api->delete('/{id}', 'App\\Api\\V1\\Controllers\\ToolPartController@delete' );
    });

    $api->group(['prefix' => 'tool_details'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\TooldetailController@index' );
        $api->post('/', 'App\\Api\\V1\\Controllers\\TooldetailController@store' );
    });

    $api->group(['prefix' => 'pck31s'], function(Router $api){
        $api->get('/', 'App\\Api\\V1\\Controllers\\Pck31Controller@index' );
        $api->get('/sync', 'App\\Api\\V1\\Controllers\\Pck31Controller@sync' );
        $api->get('/copy', 'App\\Api\\V1\\Controllers\\Pck31Controller@copy' );
    });






});
