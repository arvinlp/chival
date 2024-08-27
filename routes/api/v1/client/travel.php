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
| api/v1/client/travels
| 
*/
$router->get('/',		[ 'as'=>'Travel List',                	'uses'=>'TravelController@getList']);
$router->get('/turns',	[ 'as'=>'Turn List',                	'uses'=>'TravelController@getTurnList']);
$router->get('/check-passenger/{nation_code:[0-9]+}',	[ 'as'=>'Find Passenger by Nation Code',	'uses'=>'TravelController@getPassengerInfo']);

$router->group(['prefix' => 'turn-list'], function () use ($router) {
	$router->get('/',						[ 'as'=>'Turn List',                			'uses'=>'TurnListTempController@getList']);
	// Get Selling List
	$router->get('/selling',				[ 'as'=>'Turn List Selling Section',			'uses'=>'TurnListTempController@getSellingList']);
	// Login to List
	$router->post('/',              		[ 'as'=>'Login to Turn List',       			'uses'=>'TurnListTempController@loginVehicle']);
	// Login to List
	$router->post('/login-selling',			[ 'as'=>'Login to Selling List',       			'uses'=>'TurnListTempController@loginVehicleInSelling']);
	// Change Status 
	$router->post('/{id:[0-9]+}',			[ 'as'=>'Add to Waiting List',					'uses'=>'TurnListTempController@checkVehicle']);
	// Get
	$router->get('/{id:[0-9]+}',			[ 'as'=>'Get Item in Turn List',				'uses'=>'TurnListTempController@getItem']);
	// Login to List
	$router->post('/sell/{id:[0-9]+}/{status:[0-9]+}',	[ 'as'=>'Change Status to Selling',	'uses'=>'TurnListTempController@pushToSelling']);
	// Report
	$router->post('/report/{id:[0-9]+}',	[ 'as'=>'Report Item in Turn List',				'uses'=>'TurnListTempController@reportItem']);
	// Cancel
	$router->post('/cancel/{id:[0-9]+}',	[ 'as'=>'Cancel Travel',						'uses'=>'TurnListTempController@cancelTravel']);
	// Reject
	$router->post('/reject/{id:[0-9]+}',	[ 'as'=>'Reject Item',							'uses'=>'TurnListTempController@rejectItem']);
	// Status
	$router->post('/status/{id:[0-9]+}',	[ 'as'=>'Change Item Status',					'uses'=>'TurnListTempController@statusItem']);
	// Change Travel Between TurnListItems
	$router->post('/change/{id:[0-9]+}',	[ 'as'=>'Change Travel',						'uses'=>'TurnListTempController@changeVehicle']);
});

$router->group(['prefix' => 'selling-list'], function () use ($router) {
	$router->get('/',								[ 'as'=>'Turn List Selling Section',		'uses'=>'TurnListTempController@getSellingList']);
	// Login to List
	$router->get('/{id:[0-9]+}/{status:[0-9]+}',	[ 'as'=>'Change Status to Selling',			'uses'=>'TurnListTempController@pushToSelling']);
	// Get
	$router->get('/{id:[0-9]+}',					[ 'as'=>'Get Item in Turn List & Travel',	'uses'=>'TravelController@getItemTravel']);
	// Add/Update
	$router->post('/{id:[0-9]+}',					[ 'as'=>'Add/Update Travel Item',			'uses'=>'TravelController@updateItemTravel']);
	// Print
	$router->get('/print/{id:[0-9]+}',				[ 'as'=>'Add/Update Travel Item',			'uses'=>'TravelController@getItemTravel']);
	// in Selling
	$router->post('/selling/{id:[0-9]+}',			[ 'as'=>'Lock or unLock Travel in selling',	'uses'=>'TravelController@userSellingTravel']);
	// Cancel
	$router->post('/cancel/{id:[0-9]+}',			[ 'as'=>'Cancel Travel',					'uses'=>'TurnListTempController@cancelTravel']);
	// Change Travel Between TurnListItems
	$router->post('/change/{id:[0-9]+}',			[ 'as'=>'Cancel Travel',					'uses'=>'TurnListTempController@changeRoute']);
});

// Tracking List
$router->group(['prefix' => 'tracking-list'], function () use ($router) {
	$router->get('/',								[ 'as'=>'Tracking List',				'uses'=>'TrackingController@getList']);
	$router->get('/get/{id:[0-9]+}',				[ 'as'=>'Tracking Item',				'uses'=>'TrackingController@getItem']);
	$router->get('/records',						[ 'as'=>'Records List',					'uses'=>'TrackingController@getRecordList']);
	$router->post('/',								[ 'as'=>'Add Tracking',					'uses'=>'TrackingController@newOrUpdate']);
	$router->put('/{id:[0-9]+}',					[ 'as'=>'Update Tracking',				'uses'=>'TrackingController@newOrUpdate']);
	$router->get('/{id:[0-9]+}',					[ 'as'=>'Check Tracking',				'uses'=>'TrackingController@check']);
	$router->get('/{id:[0-9]+}/try',				[ 'as'=>'Try Get Tracking Code',		'uses'=>'TrackingController@try']);
	$router->post('/cancel',						[ 'as'=>'Cancel Tracking',				'uses'=>'TrackingController@cancel']);
	$router->get('/cancel/{code:[0-9]+}',			[ 'as'=>'Cancel Tracking By Code',		'uses'=>'TrackingController@cancelByCode']);
});

// Drivers List
$router->group(['prefix' => 'drivers'], function () use ($router) {
	$router->get('/',				[ 'as'=>'Drivers List',				'uses'=>'PreparingController@getDriversList']);
	$router->get('/{code:[0-9]+}',	[ 'as'=>'Drivers List By Code',		'uses'=>'PreparingController@getDriversList']);
});

// Cars List
$router->group(['prefix' => 'cars'], function () use ($router) {
	$router->get('/',				[ 'as'=>'Cars List',				'uses'=>'PreparingController@getCarsList']);
	$router->get('/{code:[0-9]+}',	[ 'as'=>'Cars List By Code',		'uses'=>'PreparingController@getCarsList']);
});

// Routes List
$router->group(['prefix' => 'routes'], function () use ($router) {
	$router->get('/',				[ 'as'=>'Route List',				'uses'=>'PreparingController@getRouteList']);
	$router->get('/{code:[0-9]+}',	[ 'as'=>'Route List By Code',		'uses'=>'PreparingController@getRouteList']);
});


$router->group(['prefix' => 'exclusives'], function () use ($router) {
	$router->get('/',		[ 'as'=>'Exclusive Travels', 'uses'=>'ExclusiveTravelController@getList']);
	$router->post('/new',	[ 'as'=>'New Exclusive Travel', 'uses'=>'ExclusiveTravelController@newTravel']);
});