<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurnList extends Model{
    use SoftDeletes;
    protected $table = "turn_list";

    protected $fillable = [
        'id',
        'company_id',
        'driver_id',
        'car_id',
        'route_id',
        'travel_id',
        'driver_book_time_id',
        'status',
        'login',
        'logout',
        'travel_type',
        'driver_card_no',
        'car_card_no',
        'orgin_city',
        'dest_city',
        'far_city',
        'chairs_number',
        'insurance_body',
        'insurance_third',
        'car_type',
        'plaque_number',
        'plaque_serial',
        'note'
    ];
    // public function carType(){
    //     return $this->hasOne('App\Model\Core\CarSystem', 'id', 'car_type_id');
    // }
    // public function travelType(){
    //     return $this->hasOne('App\Model\Core\TravelType', 'id', 'travel_type_id');
    // }
    public function destCityInfo(){
        return $this->hasOne('App\Model\Core\Destination', 'id', 'dest_city');
    }
    // public function seats(){
    //     return $this->hasMany('App\Model\Company\RoutePrice', 'route_id', 'id');
    // }
    //'driverInfo','carInfo','travel','routeInfo','recordInfo','travelPassengersInfo'
    public function driverInfo(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id')->select(['id','fname','lname','mobile','status','driver_note']);
    }
    public function carInfo(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id')->select(['id','plate_series','plate_series_1','plate_series_2','plate_series_3','status_note','status']);
    }
    public function driverInfoOld(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id')->select(['id','fname','lname','mobile']);
    }
    public function carInfoOld(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id')->select(['id','plate_series','plate_series_1','plate_series_2','plate_series_3']);
    }
    public function travelCode(){
        return $this->hasOne('App\Model\Company\Travel', 'id', 'travel_id')->select(['id','chival_code']);
    }
    public function travel(){
        return $this->hasOne('App\Model\Company\Travel', 'id', 'travel_id')->select(['id','chival_code','move_time','move_date','status']);
    }
    public function recordInfo(){
        return $this->hasOne('App\Model\Company\TravelRecord', 'travel_id', 'travel_id');
    }
    // public function recordInfoCheck($id){
    //     return $this->hasOne('App\Model\Company\TravelRecord', 'travel_id', 'travel_id')->where('record_id',$id);
    // }
    public function routeInfo(){
        return $this->hasOne('App\Model\Company\Route', 'id', 'route_id')->select(['id','name','route_code']);
    }

    public function travelPassengers(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'travel_id');//->select(['id','plate_series','plate_series_1','plate_series_2','plate_series_3']);
    }

    public function travelPassengersInfo(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'travel_id')->join('passengers', 'travel_passengers.passenger_id', '=', 'passengers.id');
    }

    //
    public function driverInfoRecord(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id')
            ->select(['drivers.id','provinces.name as province_name','fname','lname','mobile','status','driver_note','driver_card_no','nation_code','driver_license','province'])
            ->join('provinces', 'drivers.province', '=', 'provinces.id');
            // Join Provionce get Province name
    }
    public function carInfoRecord(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id')
            ->select(['cars.id','plate_series','plate_series_1','plate_series_2','plate_series_3','status_note','cars.status','car_card_no','insurance_id','car_insurances.code','car_insurances.expire_date'])
            ->join('car_insurances', 'cars.insurance_id', '=', 'car_insurances.id');
            // get Insurance Thirth code + date
    }
    public function travelPassengersInfoRecord(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'travel_id')->join('passengers', 'travel_passengers.passenger_id', '=', 'passengers.id');
    }
    public function travelRecord(){
        return $this->hasOne('App\Model\Company\Travel', 'id', 'travel_id')->with(['destanationCity','startingCity']);//->select(['id','chival_code','move_time','move_date','status','tax','price','commission','package']);
    }
    public function companyRecord(){
        return $this->hasOne('App\Model\Company\Company', 'id', 'company_id')
            ->select(['companies.id','company_code','companies.name as company_name','tell','provinces.name as province_name', 'cities.name as city_name','city','province','county'])
            ->join('cities', 'companies.city', '=', 'cities.id')
            ->join('provinces', 'companies.province', '=', 'provinces.id');
    }
}
