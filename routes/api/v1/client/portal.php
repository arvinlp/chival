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
| api/v1/client
|
*/

$router->get('/',				[ 'as'=>'Dashboard',		'uses'=>'Core\MainController@dashboard']);
$router->post('/upload',		[ 'as'=>'Upload Files',		'uses'=>'Core\UploadController@upload']);
$router->get('/companies',		[ 'as'=>'Companies List',	'uses'=>'Core\MainController@companiesList']);

$router->get('/roles',		[ 'as'=>'Roles',		'uses'=>'User\Controller@roles']);

$router->group(['prefix' => 'setting'], function () use ($router) {
	$router->get('/',						[ 'as'=>'Setting',				'uses'=>'Core\MainController@setting']);
	$router->get('/info',					[ 'as'=>'Information',			'uses'=>'Core\MainController@information']);
	$router->get('/setting/{key:[a-z]+}',	[ 'as'=>'Setting find by key',	'uses'=>'Core\MainController@setting']);
	$router->post('/',						[ 'as'=>'Update Setting',		'uses'=>'Core\MainController@settingUpdate']);
	$router->put('/',						[ 'as'=>'Update Setting',		'uses'=>'Core\MainController@settingUpdate']);
	$router->put('/info',					[ 'as'=>'Update Information',	'uses'=>'Core\MainController@informationUpdate']);
});

$router->group(['prefix' => 'worktimes'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Work Times',                   'uses'=>'User\WorkTimesController@list']);
	$router->get('/list',                 	[ 'as'=>'Work Times List For Chival',   'uses'=>'User\WorkTimesController@listUnlimited']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Show Work Times',              'uses'=>'User\WorkTimesController@get']);
	$router->post('/new',                   [ 'as'=>'New Work Times',               'uses'=>'User\WorkTimesController@add']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Update Work Times',            'uses'=>'User\WorkTimesController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'Delete Role',                  'uses'=>'User\WorkTimesController@delete']);
});

$router->group(['prefix' => 'users'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Users',		'uses'=>'User\UserController@list']);
	$router->get('/list',                   [ 'as'=>'All Users',	'uses'=>'User\UserController@listUnlimite']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Show User',	'uses'=>'User\UserController@get']);
	$router->post('/new',                   [ 'as'=>'New User',		'uses'=>'User\UserController@add']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Update User',	'uses'=>'User\UserController@update']);
	$router->get('/{id:[0-9]+}/logs',		[ 'as'=>'User History',	'uses'=>'User\UserController@logList']);
	
	$router->get('/count',					[ 'as'=>'Count Users',	'uses'=>'Core\MainController@countUsers']);
});

$router->group(['prefix' => '/routes'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Company Routes',        'uses'=>'Core\RoutesController@list']);
	$router->get('/list',					[ 'as'=>'Company Routes',        'uses'=>'Core\RoutesController@listUnlimited']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Company Show Route',    'uses'=>'Core\RoutesController@get']);
	$router->post('/new',                   [ 'as'=>'Company New Route',     'uses'=>'Core\RoutesController@new']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Company Update Route',  'uses'=>'Core\RoutesController@update']);
	$router->get('/destanations',           [ 'as'=>'Routes Destanation',	'uses'=>'Core\RoutesController@destanation']);
});

$router->group(['prefix' => '/partnears'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'Company Partners',			'uses'=>'Core\PartnersController@list']);
	$router->get('/list',					[ 'as'=>'Company Partners',			'uses'=>'Core\PartnersController@listUnlimited']);
	$router->get('/list/companies',			[ 'as'=>'Company Partners Comapnies',	'uses'=>'Core\PartnersController@listUnlimitedWithMe']);
	$router->get('/list/{id:[0-9]+}',		[ 'as'=>'Company Partners Filtered','uses'=>'Core\PartnersController@listUnlimitedByCity']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'Company Show Partner',		'uses'=>'Core\PartnersController@get']);
	$router->post('/new',                   [ 'as'=>'Company New Partner',		'uses'=>'Core\PartnersController@new']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'Company Update Partner',	'uses'=>'Core\PartnersController@update']);
	$router->delete('/{id:[0-9]+}',			[ 'as'=>'Company Cancel Partner',	'uses'=>'Core\PartnersController@delete']);
});

$router->group(['prefix' => 'records'], function () use ($router){
	$router->get('/',                   [ 'as'=>'Records List',		'uses'=>'Core\RecordController@list']);
	$router->get('/list',               [ 'as'=>'Records FullList',	'uses'=>'Core\RecordController@listUnlimited']);
	$router->post('/new',               [ 'as'=>'Record New',		'uses'=>'Core\RecordController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Record Info',		'uses'=>'Core\RecordController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Record Update',	'uses'=>'Core\RecordController@update']);
	$router->delete('/{id:[0-9]+}',     [ 'as'=>'Record Delete',	'uses'=>'Core\RecordController@delete']);
	$router->get('/check/{id:[0-9]+}',	[ 'as'=>'Check Record',		'uses'=>'Core\RecordController@check']);
});

$router->group(['prefix' => '/vehicles'], function () use ($router) {
	$router->get('/',                   [ 'as'=>'Vehicles List',			'uses'=>'Vehicles\VehiclesController@list']);
	$router->get('/list',               [ 'as'=>'Vehicles FullList',		'uses'=>'Vehicles\VehiclesController@listUnlimited']);
	$router->get('/{id:[0-9]+}/owner',	[ 'as'=>'Vehicle Current Owener',	'uses'=>'Vehicles\VehicleOwnersController@getCurrent']);
	$router->get('/{id:[0-9]+}/driver',	[ 'as'=>'Vehicle Current Driver',	'uses'=>'Vehicles\VehiclesController@driver']);
	$router->post('/new',               [ 'as'=>'Vehicle New',          	'uses'=>'Vehicles\VehiclesController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Info',         	'uses'=>'Vehicles\VehiclesController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Update',       	'uses'=>'Vehicles\VehiclesController@update']);

	$router->get('/{id:[0-9]+}/drivers',[ 'as'=>'Vehicle Drivers List',		'uses'=>'Vehicles\VehiclesController@driverList']);
	
	
	$router->group(['prefix' => '/{vehicle_id}/technical-diagnoses'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Technical Diagnoses List',		'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Technical Diagnoses FullList',	'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Technical Diagnose New',		'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Technical Diagnose Info',		'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Technical Diagnose Update',	'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@update']);
	});
	$router->group(['prefix' => '/{vehicle_id}/routes'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Routes List',		'uses'=>'Vehicles\VehicleRoutesController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Routes FullList',	'uses'=>'Vehicles\VehicleRoutesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Route New',		'uses'=>'Vehicles\VehicleRoutesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Info',		'uses'=>'Vehicles\VehicleRoutesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Update',		'uses'=>'Vehicles\VehicleRoutesController@update']);
	});
	$router->group(['prefix' => '/{vehicle_id}/destenations'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Destenations List',		'uses'=>'Vehicles\VehicleDestenationsController@list']);
		$router->get('/host',               [ 'as'=>'Vehicles Destenation Hosted List',	'uses'=>'Vehicles\VehicleDestenationsController@listVehiclesHosted']);
		$router->get('/list',               [ 'as'=>'Vehicle Destenations FullList',	'uses'=>'Vehicles\VehicleDestenationsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Destenation New',			'uses'=>'Vehicles\VehicleDestenationsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Destenation Info',			'uses'=>'Vehicles\VehicleDestenationsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Destenation Update',		'uses'=>'Vehicles\VehicleDestenationsController@update']);
		$router->put('/code/{id:[0-9]+}',   [ 'as'=>'Vehicle Destenation Update',		'uses'=>'Vehicles\VehicleDestenationsController@updateCode']);
	});
	$router->group(['prefix' => '/{vehicle_id}/insurances'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Insurances List',		'uses'=>'Vehicles\VehicleInsurancesController@listThird']);
		$router->get('/list',               [ 'as'=>'Vehicle Insurances FullList',	'uses'=>'Vehicles\VehicleInsurancesController@listUnlimitedThird']);
		$router->post('/new',               [ 'as'=>'Vehicle Insurance New',		'uses'=>'Vehicles\VehicleInsurancesController@newThird']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Info',		'uses'=>'Vehicles\VehicleInsurancesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Update',		'uses'=>'Vehicles\VehicleInsurancesController@updateThird']);
	});
	$router->group(['prefix' => '/{vehicle_id}/body-insurances'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Insurances List',		'uses'=>'Vehicles\VehicleInsurancesController@listBody']);
		$router->get('/list',               [ 'as'=>'Vehicle Insurances FullList',	'uses'=>'Vehicles\VehicleInsurancesController@listUnlimitedBody']);
		$router->post('/new',               [ 'as'=>'Vehicle Insurance New',		'uses'=>'Vehicles\VehicleInsurancesController@newBody']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Info',		'uses'=>'Vehicles\VehicleInsurancesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Update',		'uses'=>'Vehicles\VehicleInsurancesController@updateBody']);
	});
	$router->group(['prefix' => '/{vehicle_id}/travels'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Travels List',		'uses'=>'Vehicles\VehicleTravelController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Travels FullList',	'uses'=>'Vehicles\VehicleTravelController@listUnlimited']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Travel Info',		'uses'=>'Vehicles\VehicleTravelController@get']);
	});
	/**
	 * Owners have problems
	 */
	$router->group(['prefix' => '/{vehicle_id}/owners'], function ($vehicle_id) use ($router) {
		$router->get('/current',				[ 'as'=>'Vehicle Current Owener',	'uses'=>'Vehicles\VehicleOwnersController@getCurrent']);
		$router->get('/',                       [ 'as'=>'Vehicle Oweners List',		'uses'=>'Vehicles\VehicleOwnersController@list']);
		$router->get('/list',                   [ 'as'=>'Vehicle Oweners FullList',	'uses'=>'Vehicles\VehicleOwnersController@listUnlimited']);
		$router->get('/{id:[0-9]+}',            [ 'as'=>'Vehicle Show Owener',		'uses'=>'Vehicles\VehicleOwnersController@get']);
		$router->post('/new',                   [ 'as'=>'Vehicle New Owener',		'uses'=>'Vehicles\VehicleOwnersController@new']);
		$router->put('/{id:[0-9]+}',            [ 'as'=>'Vehicle Update Owener',	'uses'=>'Vehicles\VehicleOwnersController@update']);
	});

	$router->group(['prefix' => '/{vehicle_id}/records'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Record List',		'uses'=>'Vehicles\VehiclesController@recordList']);
		$router->get('/list',               [ 'as'=>'Vehicle Record FullList',	'uses'=>'Vehicles\VehiclesController@recordListUnlimited']);
		$router->post('/new',				[ 'as'=>'Vehicle Add Record',		'uses'=>'Vehicles\VehiclesController@recordAdd']);
	});

	$router->group(['prefix' => '/{driver_id}/license'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Status',			'uses'=>'Vehicles\VehiclesController@getVehicleStatus']);
		$router->post('/',					[ 'as'=>'Vehicle Status Change',	'uses'=>'Vehicles\VehiclesController@updateVehicleStatus']);
	});
});

$router->group(['prefix' => '/partnear-vehicles'], function () use ($router) {
	$router->get('/',                   [ 'as'=>'Vehicles List',			'uses'=>'Vehicles\PartnerVehiclesController@list']);
	$router->get('/list',               [ 'as'=>'Vehicles FullList',		'uses'=>'Vehicles\PartnerVehiclesController@listUnlimited']);
	$router->get('/{id:[0-9]+}/owner',	[ 'as'=>'Vehicle Current Owener',	'uses'=>'Vehicles\VehicleOwnersController@getCurrent']);
	$router->get('/{id:[0-9]+}/driver',	[ 'as'=>'Vehicle Current Driver',	'uses'=>'Vehicles\VehiclesController@driver']);
	$router->post('/new',               [ 'as'=>'Vehicle New',          	'uses'=>'Vehicles\VehiclesController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Info',         	'uses'=>'Vehicles\VehiclesController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Update',       	'uses'=>'Vehicles\VehiclesController@update']);

	$router->get('/{id:[0-9]+}/drivers',[ 'as'=>'Vehicle Drivers List',		'uses'=>'Vehicles\VehiclesController@driverList']);
	
	
	$router->group(['prefix' => '/{vehicle_id}/technical-diagnoses'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Technical Diagnoses List',		'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Technical Diagnoses FullList',	'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Technical Diagnose New',		'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Technical Diagnose Info',		'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Technical Diagnose Update',	'uses'=>'Vehicles\VehicleTechnicalDiagnoseController@update']);
	});
	$router->group(['prefix' => '/{vehicle_id}/routes'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Routes List',		'uses'=>'Vehicles\VehicleRoutesController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Routes FullList',	'uses'=>'Vehicles\VehicleRoutesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Route New',		'uses'=>'Vehicles\VehicleRoutesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Info',		'uses'=>'Vehicles\VehicleRoutesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Route Update',		'uses'=>'Vehicles\VehicleRoutesController@update']);
	});
	$router->group(['prefix' => '/{vehicle_id}/destenations'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Destenations List',		'uses'=>'Vehicles\VehicleDestenationsController@list']);
		$router->get('/host',               [ 'as'=>'Vehicles Destenation Hosted List',	'uses'=>'Vehicles\VehicleDestenationsController@listVehiclesHosted']);
		$router->get('/list',               [ 'as'=>'Vehicle Destenations FullList',	'uses'=>'Vehicles\VehicleDestenationsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Vehicle Destenation New',			'uses'=>'Vehicles\VehicleDestenationsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Destenation Info',			'uses'=>'Vehicles\VehicleDestenationsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Destenation Update',		'uses'=>'Vehicles\VehicleDestenationsController@update']);
		$router->put('/code/{id:[0-9]+}',   [ 'as'=>'Vehicle Destenation Update',		'uses'=>'Vehicles\VehicleDestenationsController@updateCode']);
	});
	$router->group(['prefix' => '/{vehicle_id}/insurances'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Insurances List',		'uses'=>'Vehicles\VehicleInsurancesController@listThird']);
		$router->get('/list',               [ 'as'=>'Vehicle Insurances FullList',	'uses'=>'Vehicles\VehicleInsurancesController@listUnlimitedThird']);
		$router->post('/new',               [ 'as'=>'Vehicle Insurance New',		'uses'=>'Vehicles\VehicleInsurancesController@newThird']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Info',		'uses'=>'Vehicles\VehicleInsurancesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Update',		'uses'=>'Vehicles\VehicleInsurancesController@updateThird']);
	});
	$router->group(['prefix' => '/{vehicle_id}/body-insurances'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Insurances List',		'uses'=>'Vehicles\VehicleInsurancesController@listBody']);
		$router->get('/list',               [ 'as'=>'Vehicle Insurances FullList',	'uses'=>'Vehicles\VehicleInsurancesController@listUnlimitedBody']);
		$router->post('/new',               [ 'as'=>'Vehicle Insurance New',		'uses'=>'Vehicles\VehicleInsurancesController@newBody']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Info',		'uses'=>'Vehicles\VehicleInsurancesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Vehicle Insurance Update',		'uses'=>'Vehicles\VehicleInsurancesController@updateBody']);
	});
	$router->group(['prefix' => '/{vehicle_id}/travels'], function ($vehicle_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Travels List',		'uses'=>'Vehicles\VehicleTravelController@list']);
		$router->get('/list',               [ 'as'=>'Vehicle Travels FullList',	'uses'=>'Vehicles\VehicleTravelController@listUnlimited']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Vehicle Travel Info',		'uses'=>'Vehicles\VehicleTravelController@get']);
	});
	/**
	 * Owners have problems
	 */
	$router->group(['prefix' => '/{vehicle_id}/owners'], function ($vehicle_id) use ($router) {
		$router->get('/current',				[ 'as'=>'Vehicle Current Owener',	'uses'=>'Vehicles\VehicleOwnersController@getCurrent']);
		$router->get('/',                       [ 'as'=>'Vehicle Oweners List',		'uses'=>'Vehicles\VehicleOwnersController@list']);
		$router->get('/list',                   [ 'as'=>'Vehicle Oweners FullList',	'uses'=>'Vehicles\VehicleOwnersController@listUnlimited']);
		$router->get('/{id:[0-9]+}',            [ 'as'=>'Vehicle Show Owener',		'uses'=>'Vehicles\VehicleOwnersController@get']);
		$router->post('/new',                   [ 'as'=>'Vehicle New Owener',		'uses'=>'Vehicles\VehicleOwnersController@new']);
		$router->put('/{id:[0-9]+}',            [ 'as'=>'Vehicle Update Owener',	'uses'=>'Vehicles\VehicleOwnersController@update']);
	});

	$router->group(['prefix' => '/{vehicle_id}/records'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Record List',		'uses'=>'Vehicles\VehiclesController@recordList']);
		$router->get('/list',               [ 'as'=>'Vehicle Record FullList',	'uses'=>'Vehicles\VehiclesController@recordListUnlimited']);
		$router->post('/new',				[ 'as'=>'Vehicle Add Record',		'uses'=>'Vehicles\VehiclesController@recordAdd']);
	});

	$router->group(['prefix' => '/{driver_id}/license'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Vehicle Status',			'uses'=>'Vehicles\VehiclesController@getVehicleStatus']);
		$router->post('/',					[ 'as'=>'Vehicle Status Change',	'uses'=>'Vehicles\VehiclesController@updateVehicleStatus']);
	});
});

$router->group(['prefix' => '/drivers'], function () use ($router) {
	$router->get('/',                   [ 'as'=>'Drivers List',		'uses'=>'Drivers\DriversController@list']);
	$router->get('/list',               [ 'as'=>'Drivers FullList',	'uses'=>'Drivers\DriversController@listUnlimited']);
	$router->post('/new',               [ 'as'=>'Driver New',		'uses'=>'Drivers\DriversController@new']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Info',		'uses'=>'Drivers\DriversController@get']);
	$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Update',	'uses'=>'Drivers\DriversController@update']);
	$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Delete',	'uses'=>'Drivers\DriversController@delete']);

	$router->group(['prefix' => '/{driver_id}/book-times'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Book Times List',		'uses'=>'Drivers\DriverBookTimesController@list']);
		$router->get('/list',               [ 'as'=>'Driver Book Times FullList',	'uses'=>'Drivers\DriverBookTimesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Book Time New',			'uses'=>'Drivers\DriverBookTimesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Book Time Info',		'uses'=>'Drivers\DriverBookTimesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Book Time Update',		'uses'=>'Drivers\DriverBookTimesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Book Time Delete',		'uses'=>'Drivers\DriverBookTimesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/contracts'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Contracts List',		'uses'=>'Drivers\DriverContractsController@list']);
		$router->get('/list',               [ 'as'=>'Driver Contracts FullList',	'uses'=>'Drivers\DriverContractsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Contract New',			'uses'=>'Drivers\DriverContractsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Contract Info',			'uses'=>'Drivers\DriverContractsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Contract Update',		'uses'=>'Drivers\DriverContractsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Contract Delete',		'uses'=>'Drivers\DriverContractsController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/vehicles'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Vehicles List',			'uses'=>'Drivers\DriverVehiclesController@list']);
		$router->get('/current',            [ 'as'=>'Driver Current Vehicle',		'uses'=>'Drivers\DriverVehiclesController@current']);
		$router->get('/list',               [ 'as'=>'Driver Vehicles FullList',		'uses'=>'Drivers\DriverVehiclesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Vehicle New',			'uses'=>'Drivers\DriverVehiclesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Vehicle Info',			'uses'=>'Drivers\DriverVehiclesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Vehicle Update',		'uses'=>'Drivers\DriverVehiclesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Vehicle Delete',		'uses'=>'Drivers\DriverVehiclesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/insurances'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Insurances List',		'uses'=>'Drivers\DriverInsuransesController@list']);
		$router->get('/list',               [ 'as'=>'Driver Insurances FullList',	'uses'=>'Drivers\DriverInsuransesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Insurance New',			'uses'=>'Drivers\DriverInsuransesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Insurance Info',		'uses'=>'Drivers\DriverInsuransesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Insurance Update',		'uses'=>'Drivers\DriverInsuransesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Insurance Delete',		'uses'=>'Drivers\DriverInsuransesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/destenations'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Destenations List',		'uses'=>'Drivers\DriverDestenationsController@list']);
		$router->get('/list',               [ 'as'=>'Driver Destenations FullList',	'uses'=>'Drivers\DriverDestenationsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Destenations New',		'uses'=>'Drivers\DriverDestenationsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Destenations Info',		'uses'=>'Drivers\DriverDestenationsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Destenations Update',	'uses'=>'Drivers\DriverDestenationsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Destenations Delete',	'uses'=>'Drivers\DriverDestenationsController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/records'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Record List',		'uses'=>'Drivers\DriversController@recordList']);
		$router->get('/list',               [ 'as'=>'Driver Record FullList',	'uses'=>'Drivers\DriversController@recordListUnlimited']);
		$router->post('/new',				[ 'as'=>'Driver Add Record',		'uses'=>'Drivers\DriversController@recordAdd']);
	});
	$router->group(['prefix' => '/{driver_id}/license'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Status',		'uses'=>'Drivers\DriversController@getDriverStatus']);
		$router->post('/',					[ 'as'=>'Driver Status Change',	'uses'=>'Drivers\DriversController@updateDriverStatus']);
	});
});

$router->group(['prefix' => '/partnear-drivers'], function () use ($router) {
	$router->get('/',                   [ 'as'=>'Partnear Drivers List',		'uses'=>'Drivers\PartnearDriversController@list']);
	$router->get('/list',               [ 'as'=>'Partnear Drivers FullList',	'uses'=>'Drivers\PartnearDriversController@listUnlimited']);
	$router->get('/{id:[0-9]+}',        [ 'as'=>'Partnear Driver Info',			'uses'=>'Drivers\PartnearDriversController@get']);
	$router->delete('/{id:[0-9]+}',     [ 'as'=>'Partnear Driver Delete',		'uses'=>'Drivers\PartnearDriversController@delete']);

	$router->group(['prefix' => '/{driver_id}/book-times'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Book Times List',		'uses'=>'Drivers\DriverBookTimesController@list']);
		$router->get('/list',               [ 'as'=>'Driver Book Times FullList',	'uses'=>'Drivers\DriverBookTimesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Book Time New',			'uses'=>'Drivers\DriverBookTimesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Book Time Info',		'uses'=>'Drivers\DriverBookTimesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Book Time Update',		'uses'=>'Drivers\DriverBookTimesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Book Time Delete',		'uses'=>'Drivers\DriverBookTimesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/contracts'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Contracts List',		'uses'=>'Drivers\DriverContractsController@list']);
		$router->get('/list',               [ 'as'=>'Driver Contracts FullList',	'uses'=>'Drivers\DriverContractsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Contract New',			'uses'=>'Drivers\DriverContractsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Contract Info',			'uses'=>'Drivers\DriverContractsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Contract Update',		'uses'=>'Drivers\DriverContractsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Contract Delete',		'uses'=>'Drivers\DriverContractsController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/vehicles'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Vehicles List',			'uses'=>'Drivers\DriverVehiclesController@list']);
		$router->get('/current',            [ 'as'=>'Driver Current Vehicle',		'uses'=>'Drivers\DriverVehiclesController@current']);
		$router->get('/list',               [ 'as'=>'Driver Vehicles FullList',		'uses'=>'Drivers\DriverVehiclesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Vehicle New',			'uses'=>'Drivers\DriverVehiclesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Vehicle Info',			'uses'=>'Drivers\DriverVehiclesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Vehicle Update',		'uses'=>'Drivers\DriverVehiclesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Vehicle Delete',		'uses'=>'Drivers\DriverVehiclesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/insurances'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Insurances List',		'uses'=>'Drivers\DriverInsuransesController@list']);
		$router->get('/list',               [ 'as'=>'Driver Insurances FullList',	'uses'=>'Drivers\DriverInsuransesController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Insurance New',			'uses'=>'Drivers\DriverInsuransesController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Insurance Info',		'uses'=>'Drivers\DriverInsuransesController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Insurance Update',		'uses'=>'Drivers\DriverInsuransesController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Insurance Delete',		'uses'=>'Drivers\DriverInsuransesController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/destenations'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Destenations List',		'uses'=>'Drivers\DriverDestenationsController@list']);
		$router->get('/list',               [ 'as'=>'Driver Destenations FullList',	'uses'=>'Drivers\DriverDestenationsController@listUnlimited']);
		$router->post('/new',               [ 'as'=>'Driver Destenations New',		'uses'=>'Drivers\DriverDestenationsController@new']);
		$router->get('/{id:[0-9]+}',        [ 'as'=>'Driver Destenations Info',		'uses'=>'Drivers\DriverDestenationsController@get']);
		$router->put('/{id:[0-9]+}',        [ 'as'=>'Driver Destenations Update',	'uses'=>'Drivers\DriverDestenationsController@update']);
		$router->delete('/{id:[0-9]+}',     [ 'as'=>'Driver Destenations Delete',	'uses'=>'Drivers\DriverDestenationsController@delete']);
	});
	$router->group(['prefix' => '/{driver_id}/records'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Record List',		'uses'=>'Drivers\DriversController@recordList']);
		$router->get('/list',               [ 'as'=>'Driver Record FullList',	'uses'=>'Drivers\DriversController@recordListUnlimited']);
		$router->post('/new',				[ 'as'=>'Driver Add Record',		'uses'=>'Drivers\DriversController@recordAdd']);
	});
	$router->group(['prefix' => '/{driver_id}/license'], function ($driver_id) use ($router){
		$router->get('/',                   [ 'as'=>'Driver Status',		'uses'=>'Drivers\DriversController@getDriverStatus']);
		$router->post('/',					[ 'as'=>'Driver Status Change',	'uses'=>'Drivers\DriversController@updateDriverStatus']);
	});
});
$router->group(['prefix' => 'check'], function () use ($router){
	$router->get('/driver/print/{id:[0-9]+}',	[ 'as'=>'print-driver-info',	'uses'=>'Core\CheckController@driverPrint']);
	$router->get('/driver/{code:[0-9]+}',	[ 'as'=>'check-driver-code',	'uses'=>'Core\CheckController@driver']);
	$router->get('/car/{code:[0-9]+}',		[ 'as'=>'check-car-code',		'uses'=>'Core\CheckController@car']);
	$router->get('/route/{code:[0-9]+}',	[ 'as'=>'check-route-code',		'uses'=>'Core\CheckController@route']);
	$router->get('/route/name/{name}',		[ 'as'=>'check-route-name',		'uses'=>'Core\CheckController@routeName']);
});


$router->group(['prefix' => 'centeral-pcpos-terminals'], function () use ($router) {
	$router->get('/',                       [ 'as'=>'centeral-pcpos-terminals',			'uses'=>'Payment\CentralPCPOSTerminalController@list']);
	$router->get('/list',                 	[ 'as'=>'centeral-pcpos-terminals-list',	'uses'=>'Payment\CentralPCPOSTerminalController@listUnlimited']);
	$router->get('/{id:[0-9]+}',            [ 'as'=>'centeral-pcpos-terminals-show',	'uses'=>'Payment\CentralPCPOSTerminalController@get']);
	$router->post('/new',                   [ 'as'=>'centeral-pcpos-terminals-new',		'uses'=>'Payment\CentralPCPOSTerminalController@add']);
	$router->put('/{id:[0-9]+}',            [ 'as'=>'centeral-pcpos-terminals-update',	'uses'=>'Payment\CentralPCPOSTerminalController@update']);
	$router->delete('/{id:[0-9]+}',         [ 'as'=>'centeral-pcpos-terminals-delete',	'uses'=>'Payment\CentralPCPOSTerminalController@delete']);
});

$router->group(['prefix' => 'payments'], function () use ($router) {
	$router->post('/start-payment',	[ 'as'=>'payment-centeral-pcpos',	'uses'=>'Payment\CentralPCPOSController@startPayment']);
});

$router->group(['prefix' => 'centeral-pcpos'], function () use ($router) {
	$router->post('/start-payment',	[ 'as'=>'centeral-pcpos-start-payment',	'uses'=>'Payment\CentralPCPOSController@startPayment']);
});


$router->post('/testing',		[ 'as'=>'testing',		'uses'=>'Payment\CentralPCPOSController@startPaymentIBAN']);