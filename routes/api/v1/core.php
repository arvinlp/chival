<?php
/*
--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', 'CoreRestApiController@CoreV1');

$router->group(['middleware' => 'auth:chival'], function () use ($router) {

	$router->get('/provinces',                      'CityController@provinces');
	$router->get('/counties/{province_id:[0-9]+}',  'CityController@counties');
	$router->get('/cites/{county_id:[0-9]+}',       'CityController@cities');
	$router->get('/city/{get}/{id:[0-9]+}',			'CityController@get');

	$router->get('/vehicle-types',                       'VehicleSystemController@list');
	$router->get('/vehicle-types/capacity/{id:[0-9]+}',	 'VehicleSystemController@capacity');
	$router->get('/vehicle-types/list',					 'VehicleSystemController@listUnlimited');
	$router->get('/vehicle-types/{id:[0-9]+}',           'VehicleSystemController@get');

	$router->get('/vehicle-brands',                      'VehicleTypeController@list');
	$router->get('/vehicle-brands/list',				 'VehicleTypeController@listUnlimited');
	$router->get('/vehicle-brands/{id:[0-9]+}',          'VehicleTypeController@get');
	
	$router->get('/destinations',                      	'DestinationController@list');
	$router->get('/destinations/list',					'DestinationController@listUnlimited');
	$router->get('/destinations/{id:[0-9]+}',          	'DestinationController@get');
	
	$router->get('/banks',                              'BankController@list');
	$router->get('/banks/{id:[0-9]+}',                  'BankController@get');

	$router->get('/insurance-companies',                'InsuranceController@list');
	$router->get('/insurance-companies/list',			'InsuranceController@listUnlimited');
	$router->get('/insurance-companies/{id:[0-9]+}',    'InsuranceController@get');
	
	$router->get('/travel-types',                       'TravelTypeController@list');
	$router->get('/travel-types/list',					'TravelTypeController@listUnlimited');
	$router->get('/travel-types/{id:[0-9]+}',           'TravelTypeController@get');

	$router->get('/credits',                'CreditController@list');
	$router->get('/credits/list',			'CreditController@listUnlimited');
	$router->get('/credits/{id:[0-9]+}',    'CreditController@get');

	$router->get('/modules',                'ModuleController@list');
	$router->get('/modules/list',			'ModuleController@listUnlimited');
	$router->get('/modules/{id:[0-9]+}',    'ModuleController@get');

	/**
	 * 
	 */
	$router->post('/vehicle-types/new',                  'VehicleSystemController@add');
	$router->put('/vehicle-types/{id:[0-9]+}',           'VehicleSystemController@update');
	$router->delete('/vehicle-types/{id:[0-9]+}',        'VehicleSystemController@delete');
	
	$router->post('/vehicle-brands/new',                 'VehicleTypeController@add');
	$router->put('/vehicle-brands/{id:[0-9]+}',          'VehicleTypeController@update');
	$router->delete('/vehicle-brands/{id:[0-9]+}',       'VehicleTypeController@delete');

	$router->post('/destinations/new',                 	'DestinationController@add');
	$router->put('/destinations/{id:[0-9]+}',			'DestinationController@update');
	$router->delete('/destinations/{id:[0-9]+}',		'DestinationController@delete');
	
	$router->post('/banks/new',                         'BankController@add');
	$router->put('/banks/{id:[0-9]+}',                  'BankController@update');
	$router->delete('/banks/{id:[0-9]+}',               'BankController@delete');

	$router->post('/insurance-companies/new',           'InsuranceController@add');
	$router->put('/insurance-companies/{id:[0-9]+}',    'InsuranceController@update');
	$router->delete('/insurance-companies/{id:[0-9]+}', 'InsuranceController@delete');
	
	$router->post('/travel-types/new',                  'TravelTypeController@add');
	$router->put('/travel-types/{id:[0-9]+}',           'TravelTypeController@update');
	$router->delete('/travel-types/{id:[0-9]+}',        'TravelTypeController@delete');
	
	$router->post('/credits/new',           'CreditController@add');
	$router->put('/credits/{id:[0-9]+}',    'CreditController@update');
	$router->delete('/credits/{id:[0-9]+}', 'CreditController@delete');
	
	$router->post('/modules/new',           'ModuleController@add');
	$router->put('/modules/{id:[0-9]+}',    'ModuleController@update');
	$router->delete('/modules/{id:[0-9]+}', 'ModuleController@delete');

	/**
	 * 
	 */

	$router->group(['prefix' => '/rmto'], function () use ($router) {
		$router->post('/driver',                            'RMTOController@getDriverWithNationCode');
		$router->get('/driver/{nation_code:[0-9]+}',        'RMTOController@getDriverWithNationCode');
		$router->post('/driver/check',                      'RMTOController@checkDriverStatus');
		$router->get('/driver/check/{nation_code:[0-9]+}',  'RMTOController@checkDriverStatus');

		$router->post('/vehicle',                       'RMTOController@getCar');
		$router->get('/vehicle/{card_no:[0-9]+}',       'RMTOController@getCar');
		$router->post('/vehicle/check',                 'RMTOController@checkCarStatus');
		$router->get('/vehicle/check/{card_no:[0-9]+}', 'RMTOController@checkCarStatus');
	});
	
	$router->group(['prefix' => '/askok'], function () use ($router) {
		$router->get('/driver/{code:[0-9]+}',   'ASKOKController@getDriver');
		$router->get('/vehicle/{code:[0-9]+}',  'ASKOKController@getCar');
	});
});
