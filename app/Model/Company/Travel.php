<?php

namespace App\Model\Company;

use App\Model\Company\CompanySetting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model{
    use SoftDeletes;

    protected $appends = [
        'static_price'
    ];

    public function getStaticPriceAttribute(){
        $companyExtraPrice = CompanySetting::where('company_id',$this->attributes['company_id'])
            ->where('key','passenger_extra_price');
        if(! $extraPrice = $companyExtraPrice->first())
            return 0;
        return $extraPrice->value;
    }

    public function travelPassengers(){
        return $this->hasMany('App\Model\Company\TravelPassenger', 'travel_id', 'id')
                ->join('passengers', 'passengers.id', '=', 'travel_passengers.passenger_id')
                ->select('travel_passengers.*','passengers.fname','passengers.lname','passengers.nation_code','passengers.mobile')
                ->orderBy('travel_passengers.seat_number');
    }
    public function travelPassengersFull(){
        return $this->belongsToMany('App\Model\Passenger', 'travel_passengers', 'travel_id', 'passenger_id')
        ->withPivot('seat_number', 'child_number', 'package_number','amount','total_amount','discont');
    }

    public function seatPrices(){
        return $this->hasMany('App\Model\Company\RoutePrice', 'route_id', 'route_id');
    }

    public function driverInfo(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id')->select('id','fname','lname','mobile');
    }

    public function carInfo(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id')->select(['id','plate_series','plate_series_1','plate_series_2','plate_series_3']);
    }

    public function carSystem(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id')->select(['id','car_type_id'])->with(['carSystem']);
    }

    public function carType(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id')->select(['id','car_system_id'])->with(['carType']);
    }

    public function turnList(){
        return $this->hasOne('App\Model\Company\TurnListTemp', 'id', 'turn_list_id')->select('id','status');
    }

    public function startingCompany(){
        return $this->hasOne('App\Model\Company\Company', 'id', 'company_id');//->select('id','name','address')->makeHidden(['location','folder','company_manager']);
    }

    public function startingCity(){
        return $this->hasOne('App\Model\Core\Destination', 'id', 'orgin_city')->select('id','name');
    }

    public function destanationCity(){
        return $this->hasOne('App\Model\Core\Destination', 'id', 'dest_city')->select('id','name');
    }

    // public function travelType(){
    //     return $this->hasOne('App\Model\Core\TravelType', 'id', 'travel_type_id');
    // }

    // public function destination(){
    //     return $this->hasOne('App\Model\Core\Destination', 'id', 'destination_id');
    // }

    // public function seats(){
    //     return $this->hasMany('App\Model\Company\RoutePrice', 'route_id', 'id');
    // }
}
