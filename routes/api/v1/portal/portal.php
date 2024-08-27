<?php
/*
-------------------------------------------------------------------------
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

$router->post('/upload',   [ 'as'=>'Upload Files',  'uses'=>'Core\UploadController@upload']);

$router->group(['prefix' => 'setting'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Get All Setting',		'uses'=>'Core\ChivalSettingController@get']);
	$router->get('/{key}',					[ 'as'=>'Get Setting',			'uses'=>'Core\ChivalSettingController@get']);
	$router->post('/',                      [ 'as'=>'Update Setting',		'uses'=>'Core\ChivalSettingController@update']);
	$router->put('/',						[ 'as'=>'Update Setting',		'uses'=>'Core\ChivalSettingController@update']);
});

$router->group(['prefix' => 'roles'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Roles',                'uses'=>'Core\RoleController@list']);
	$router->get('/chival',                 [ 'as'=>'Roles For Chival',     'uses'=>'Core\RoleController@listChival']);
	$router->get('/company',                [ 'as'=>'Roles For Companies',  'uses'=>'Core\RoleController@listCompany']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Show Role',            'uses'=>'Core\RoleController@get']);
	$router->post('/new',                   [ 'as'=>'New Role',             'uses'=>'Core\RoleController@add']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Update Role',          'uses'=>'Core\RoleController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Delete Role',          'uses'=>'Core\RoleController@delete']);
});

$router->group(['prefix' => 'worktimes'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Work Times',                   'uses'=>'Core\WorkTimeController@list']);
	$router->get('/chival',                 [ 'as'=>'Work Times List For Chival',   'uses'=>'Core\WorkTimeController@listChival']);
	$router->get('/company',                [ 'as'=>'Work Times List For Company',  'uses'=>'Core\WorkTimeController@listCompany']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Show Work Times',              'uses'=>'Core\WorkTimeController@get']);
	$router->post('/new',                   [ 'as'=>'New Work Times',               'uses'=>'Core\WorkTimeController@add']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Update Work Times',            'uses'=>'Core\WorkTimeController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Delete Role',                  'uses'=>'Core\WorkTimeController@delete']);
});

$router->group(['prefix' => 'users'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Admins',		'uses'=>'Core\ChivalUserController@list']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Show Admin',	'uses'=>'Core\ChivalUserController@get']);
	$router->post('/new',                   [ 'as'=>'New Admin',	'uses'=>'Core\ChivalUserController@add']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Update Admin',	'uses'=>'Core\ChivalUserController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Delete Admin',	'uses'=>'Core\ChivalUserController@delete']);

	$router->get('/list',                   [ 'as'=>'All Admins',	'uses'=>'Core\ChivalUserController@listUnlimite']);
	$router->group(['prefix' => 'logs'], function () use ($router) {
		$router->get('/',					[ 'as'=>'Admins Logs List',	'uses'=>'Core\UserHistoriesController@chivalList']);
	});
});
