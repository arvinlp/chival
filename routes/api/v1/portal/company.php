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

$router->get('/',                   [ 'as'=>'Companies List',       'uses'=>'Chival\CompanyController@list']);
$router->get('/list',               [ 'as'=>'Companies FullList',   'uses'=>'Chival\CompanyController@listUnlimited']);
$router->post('/new',               [ 'as'=>'Company New',          'uses'=>'Chival\CompanyController@new']);
$router->get('/{id:[0-9]+}',        [ 'as'=>'Company Info',         'uses'=>'Chival\CompanyController@get']);
$router->put('/{id:[0-9]+}',        [ 'as'=>'Company Update',       'uses'=>'Chival\CompanyController@update']);
$router->delete('/{id:[0-9]+}',     [ 'as'=>'Company Delete',       'uses'=>'Chival\CompanyController@delete']);

$router->get('/users/logs',			[ 'as'=>'Company User Logs',	'uses'=>'Chival\CompanyUsersController@historyList']);
	//7
$router->group(['prefix' => '/{company_id}/users'], function ($company_id) use ($router) {
	$router->get('/',                       [ 'as'=>'Company Users',        'uses'=>'Chival\CompanyUsersController@list']);
	$router->get('/list',					[ 'as'=>'Company Users',        'uses'=>'Chival\CompanyUsersController@listUnlimite']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Company Show User',    'uses'=>'Chival\CompanyUsersController@get']);
	$router->post('/new',                   [ 'as'=>'Company New User',     'uses'=>'Chival\CompanyUsersController@new']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Company Update User',  'uses'=>'Chival\CompanyUsersController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Company Delete User',  'uses'=>'Chival\CompanyUsersController@delete']);
});
$router->group(['prefix' => '/{company_id}/routes'], function ($company_id) use ($router) {
	$router->get('/',                       [ 'as'=>'Company Routes',        'uses'=>'Chival\CompanyRoutesController@list']);
	$router->get('/list',					[ 'as'=>'Company Routes',        'uses'=>'Chival\CompanyRoutesController@listUnlimited']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Company Show Route',    'uses'=>'Chival\CompanyRoutesController@get']);
	$router->post('/new',                   [ 'as'=>'Company New Route',     'uses'=>'Chival\CompanyRoutesController@new']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Company Update Route',  'uses'=>'Chival\CompanyRoutesController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Company Delete Route',  'uses'=>'Chival\CompanyRoutesController@delete']);
});
$router->group(['prefix' => '/{company_id}/partnears'], function ($company_id) use ($router) {
	$router->get('/',                       [ 'as'=>'Company Partners',        'uses'=>'Chival\CompanyPartnersController@list']);
	$router->get('/list',					[ 'as'=>'Company Partners',        'uses'=>'Chival\CompanyPartnersController@listUnlimite']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Company Show Partner',    'uses'=>'Chival\CompanyPartnersController@get']);
	$router->post('/new',                   [ 'as'=>'Company New Partner',     'uses'=>'Chival\CompanyPartnersController@new']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Company Update Partner',  'uses'=>'Chival\CompanyPartnersController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Company Delete Partner',  'uses'=>'Chival\CompanyPartnersController@delete']);
});
$router->group(['prefix' => '/{company_id}/vehicles'], function ($company_id) use ($router) {
	$router->get('/',                   [ 'as'=>'Vehicles List',			'uses'=>'Chival\CompanyVehiclesController@list']);
	$router->get('/list',               [ 'as'=>'Vehicles FullList',		'uses'=>'Chival\CompanyVehiclesController@listUnlimited']);
	$router->get('/{id:[0-9]+}/owner',	[ 'as'=>'Vehicle Current Owner',	'uses'=>'Chival\CompanyVehiclesController@owner']);
	$router->get('/{id:[0-9]+}/driver',	[ 'as'=>'Vehicle Current Driver',	'uses'=>'Chival\CompanyVehiclesController@driver']);
	$router->post('/new',               [ 'as'=>'Vehicle New',          	'uses'=>'Chival\CompanyVehiclesController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Info',         	'uses'=>'Chival\CompanyVehiclesController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Update',       	'uses'=>'Chival\CompanyVehiclesController@update']);
	$router->delete('/{id:[0-9]+}',     [ 'as'=>'Vehicle Delete',       	'uses'=>'Chival\CompanyVehiclesController@delete']);

	$router->get('/{id:[0-9]+}/drivers',[ 'as'=>'Vehicle Drivers List',		'uses'=>'Chival\CompanyVehiclesController@driverList']);
	
	$router->group(['prefix' => '/{vehicle_id}/technical-diagnoses'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Technical Diagnoses List',		'uses'=>'Chival\CompanyVehicleTechnicalDiagnoseController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Technical Diagnoses FullList',	'uses'=>'Chival\CompanyVehicleTechnicalDiagnoseController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Technical Diagnose New',		'uses'=>'Chival\CompanyVehicleTechnicalDiagnoseController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Technical Diagnose Info',		'uses'=>'Chival\CompanyVehicleTechnicalDiagnoseController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Technical Diagnose Update',	'uses'=>'Chival\CompanyVehicleTechnicalDiagnoseController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Vehicle Technical Diagnose Delete',	'uses'=>'Chival\CompanyVehicleTechnicalDiagnoseController@delete']);
	});
	$router->group(['prefix' => '/{vehicle_id}/routes'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Routes List',		'uses'=>'Chival\CompanyVehicleRoutesController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Routes FullList',	'uses'=>'Chival\CompanyVehicleRoutesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Route New',		'uses'=>'Chival\CompanyVehicleRoutesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Info',		'uses'=>'Chival\CompanyVehicleRoutesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Update',		'uses'=>'Chival\CompanyVehicleRoutesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Vehicle Route Delete',		'uses'=>'Chival\CompanyVehicleRoutesController@delete']);
	});
	$router->group(['prefix' => '/{vehicle_id}/destenations'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Routes List',		'uses'=>'Chival\CompanyVehicleDestenationsController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Routes FullList',	'uses'=>'Chival\CompanyVehicleDestenationsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Route New',		'uses'=>'Chival\CompanyVehicleDestenationsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Info',		'uses'=>'Chival\CompanyVehicleDestenationsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Update',		'uses'=>'Chival\CompanyVehicleDestenationsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Vehicle Route Delete',		'uses'=>'Chival\CompanyVehicleDestenationsController@delete']);
	});
	$router->group(['prefix' => '/{vehicle_id}/insurances'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Insurances List',		'uses'=>'Chival\CompanyVehicleInsurancesController@listThird']);
		$router->get('/list',               [ 'as'=>'Vehicle Insurances FullList',	'uses'=>'Chival\CompanyVehicleInsurancesController@listUnlimitedThird']);
		$router->post('/new',               [ 'as'=>'Vehicle Insurance New',		'uses'=>'Chival\CompanyVehicleInsurancesController@newThird']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Info',		'uses'=>'Chival\CompanyVehicleInsurancesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Update',		'uses'=>'Chival\CompanyVehicleInsurancesController@updateThird']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Vehicle Insurance Delete',		'uses'=>'Chival\CompanyVehicleInsurancesController@deleteThird']);
	});
	$router->group(['prefix' => '/{vehicle_id}/body-insurances'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Insurances List',		'uses'=>'Chival\CompanyVehicleInsurancesController@listBody']);
		$router->get('/list',               [ 'as'=>'Vehicle Insurances FullList',	'uses'=>'Chival\CompanyVehicleInsurancesController@listUnlimitedBody']);
		$router->post('/new',               [ 'as'=>'Vehicle Insurance New',		'uses'=>'Chival\CompanyVehicleInsurancesController@newBody']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Info',		'uses'=>'Chival\CompanyVehicleInsurancesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Update',		'uses'=>'Chival\CompanyVehicleInsurancesController@updateBody']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Vehicle Insurance Delete',		'uses'=>'Chival\CompanyVehicleInsurancesController@deleteBody']);
	});
	/**
	 * Owners have problems
	 */
	$router->group(['prefix' => '/{vehicle_id}/owners'], function ($vehicle_id) use ($router) {
		$router->get('/',                       [ 'as'=>'Vehicle Oweners List',		'uses'=>'Chival\CompanyVehicleOwnersController@list']);
		$router->get('/list',                   [ 'as'=>'Vehicle Oweners FullList',	'uses'=>'Chival\CompanyVehicleOwnersController@listUnlimited']);
		$router->get('/{id:[0-9]+}',            [ 'as'=>'Vehicle Show Owener',		'uses'=>'Chival\CompanyVehicleOwnersController@get']);
		$router->post('/new',                   [ 'as'=>'Vehicle New Owener',		'uses'=>'Chival\CompanyVehicleOwnersController@new']);
		$router->put('/{id:[0-9]+}',            [ 'as'=>'Vehicle Update Owener',	'uses'=>'Chival\CompanyVehicleOwnersController@update']);
		$router->delete('/{id:[0-9]+}',         [ 'as'=>'Vehicle Delete Owener',	'uses'=>'Chival\CompanyVehicleOwnersController@delete']);
	});
});

$router->group(['prefix' => '/{company_id}/drivers'], function ($company_id) use ($router) {
	$router->get('/',                   [ 'as'=>'Drivers List',		'uses'=>'Chival\CompanyDriversController@list']);
	$router->get('/list',               [ 'as'=>'Drivers FullList',	'uses'=>'Chival\CompanyDriversController@listUnlimited']);
	$router->post('/new',               [ 'as'=>'Driver New',		'uses'=>'Chival\CompanyDriversController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Info',		'uses'=>'Chival\CompanyDriversController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Update',	'uses'=>'Chival\CompanyDriversController@update']);
	$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Delete',	'uses'=>'Chival\CompanyDriversController@delete']);
	$router->group(['prefix' => '/{driver_id}/book-times'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Book Times List',		'uses'=>'Chival\CompanyDriverBookTimesController@list']);
		$router->get('/list',               [ 'as'=>'Driver Book Times FullList',	'uses'=>'Chival\CompanyDriverBookTimesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Book Time New',			'uses'=>'Chival\CompanyDriverBookTimesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Book Time Info',		'uses'=>'Chival\CompanyDriverBookTimesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Book Time Update',		'uses'=>'Chival\CompanyDriverBookTimesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Book Time Delete',		'uses'=>'Chival\CompanyDriverBookTimesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/contracts'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Contracts List',		'uses'=>'Chival\CompanyDriverContractsController@list']);
		$router->get('/list',               [ 'as'=>'Driver Contracts FullList',	'uses'=>'Chival\CompanyDriverContractsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Contract New',			'uses'=>'Chival\CompanyDriverContractsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Contract Info',			'uses'=>'Chival\CompanyDriverContractsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Contract Update',		'uses'=>'Chival\CompanyDriverContractsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Contract Delete',		'uses'=>'Chival\CompanyDriverContractsController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/vehicles'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Vehicles List',			'uses'=>'Chival\CompanyDriverViehclesController@list']);
		$router->get('/current',            [ 'as'=>'Driver Current Vehicle',		'uses'=>'Chival\CompanyDriverViehclesController@current']);
		$router->get('/list',               [ 'as'=>'Driver Vehicles FullList',		'uses'=>'Chival\CompanyDriverViehclesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Vehicle New',			'uses'=>'Chival\CompanyDriverViehclesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Vehicle Info',			'uses'=>'Chival\CompanyDriverViehclesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Vehicle Update',		'uses'=>'Chival\CompanyDriverViehclesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Vehicle Delete',		'uses'=>'Chival\CompanyDriverViehclesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/insurances'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Insurances List',		'uses'=>'Chival\CompanyDriverInsuransesController@list']);
		$router->get('/list',               [ 'as'=>'Driver Insurances FullList',	'uses'=>'Chival\CompanyDriverInsuransesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Insurance New',			'uses'=>'Chival\CompanyDriverInsuransesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Insurance Info',		'uses'=>'Chival\CompanyDriverInsuransesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Insurance Update',		'uses'=>'Chival\CompanyDriverInsuransesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Insurance Delete',		'uses'=>'Chival\CompanyDriverInsuransesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/destenation'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Destenations List',		'uses'=>'Chival\CompanyDriverDestenationsController@list']);
		$router->get('/list',               [ 'as'=>'Driver Destenations FullList',	'uses'=>'Chival\CompanyDriverDestenationsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Destenations New',		'uses'=>'Chival\CompanyDriverDestenationsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Destenations Info',		'uses'=>'Chival\CompanyDriverDestenationsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Destenations Update',	'uses'=>'Chival\CompanyDriverDestenationsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Destenations Delete',	'uses'=>'Chival\CompanyDriverDestenationsController@delete']);
	});
});

$router->group(['prefix' => '/{company_id}/contracts'], function ($company_id) use ($router) {
	$router->get('/',                   [ 'as'=>'Contracts List',		'uses'=>'Chival\CompanyContractsController@list']);
	$router->get('/list',               [ 'as'=>'Contracts FullList',	'uses'=>'Chival\CompanyContractsController@listUnlimited']);
	$router->post('/new',               [ 'as'=>'Contract New',			'uses'=>'Chival\CompanyContractsController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Contract Info',		'uses'=>'Chival\CompanyContractsController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Contract Update',		'uses'=>'Chival\CompanyContractsController@update']);
	$router->delete('/{id:[0-9]+}',     [ 'as'=>'Contract Delete',		'uses'=>'Chival\CompanyContractsController@delete']);
});