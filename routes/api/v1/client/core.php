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
| api/v1/client/core
|
*/

$router->get('/provinces',                      	'CityController@provinces');
$router->get('/counties/{province_id:[0-9]+}',  	'CityController@counties');
$router->get('/cites/{county_id:[0-9]+}',       	'CityController@cities');
$router->get('/city/{get}/{id:[0-9]+}',				'CityController@get');

$router->get('/vehicle-types',                       'VehicleSystemController@list');
$router->get('/vehicle-types/capacity/{id:[0-9]+}',	 'VehicleSystemController@capacity');
$router->get('/vehicle-types/list',					 'VehicleSystemController@listUnlimited');
$router->get('/vehicle-types/{id:[0-9]+}',           'VehicleSystemController@get');

$router->get('/vehicle-brands',                      'VehicleTypeController@list');
$router->get('/vehicle-brands/list',				 'VehicleTypeController@listUnlimited');
$router->get('/vehicle-brands/{id:[0-9]+}',          'VehicleTypeController@get');

$router->get('/destinations',                      	'DestinationController@list');
$router->get('/destinations/list',					'DestinationController@listUnlimitedWithoutMe');
$router->get('/destinations/{id:[0-9]+}',          	'DestinationController@get');

$router->get('/banks',                              'BankController@listUnlimited');
$router->get('/banks/{id:[0-9]+}',                  'BankController@get');

$router->get('/insurance-companies',                'InsuranceController@list');
$router->get('/insurance-companies/list',			'InsuranceController@listUnlimited');
$router->get('/insurance-companies/{id:[0-9]+}',    'InsuranceController@get');

$router->get('/travel-types',                       'TravelTypeController@list');
$router->get('/travel-types/list',					'TravelTypeController@listUnlimited');
$router->get('/travel-types/{id:[0-9]+}',           'TravelTypeController@get');

$router->get('/credits',                			'CreditController@list');
$router->get('/credits/list',						'CreditController@listUnlimited');
$router->get('/credits/{id:[0-9]+}',				'CreditController@get');

$router->get('/modules',                			'ModuleController@list');
$router->get('/modules/list',						'ModuleController@listUnlimited');
$router->get('/modules/{id:[0-9]+}',				'ModuleController@get');


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
