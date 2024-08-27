<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class TurnListTemp extends Model{
    public $timestamps = false;
    protected $table = "turn_list_temp";


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $appends = [
        'selling_jalali'
    ];
    
    public function getSellingJalaliAttribute(){
        try{
            $date = Carbon::parse($this->attributes['selling']);
            
            return $date->toTimeString();
        }
		catch (\Exception $e) {
            return 'خطا: زمان ورود به فروش بیلط ثبت نشده است';
		}
    }
    /**
     * Relations
     */
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
    public function routeInfo(){
        return $this->hasOne('App\Model\Company\Route', 'id', 'route_id')->select(['id','name','route_code']);
    }

    public function travelPassengers(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'travel_id');//->select(['id','plate_series','plate_series_1','plate_series_2','plate_series_3']);
    }
    public function travelPassengersCount(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'travel_id')->count();//->select(['id','plate_series','plate_series_1','plate_series_2','plate_series_3']);
    }

    public function travelPassengersInfo(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'travel_id')->join('passengers', 'travel_passengers.passenger_id', '=', 'passengers.id');
    }

}