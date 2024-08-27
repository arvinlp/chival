<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function() use ($router){
    return $router->getRoutes();
});

$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->post('/signup',            ['as'=>'signup',            'namespace'=>'Auth' ,'uses'=>'RegisterController@companyRegister']);
    $router->post('/login',             ['as'=>'company_login',     'namespace'=>'Auth' ,'uses'=>'LoginController@companyUserLogin']);
    $router->post('/portal/login',      ['as'=>'chival_login',      'namespace'=>'Auth' ,'uses'=>'LoginController@chivalUserLogin']);
    $router->post('/portal/login/tw',   ['as'=>'chival_login_60',   'namespace'=>'Auth' ,'uses'=>'LoginController@chivalUserLoginHoure']);
});