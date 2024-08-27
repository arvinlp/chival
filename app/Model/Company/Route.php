<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model{
    use SoftDeletes;

    public function getCompanyIdAttribute(){
        return (int)$this->attributes['company_id'];
    }
    public function getRouteCodeAttribute(){
        return (int)$this->attributes['route_code'];
    }
    public function getDistanceAttribute(){
        return (int)$this->attributes['distance'];
    }
    public function getRejectNumberAttribute(){
        return (int)$this->attributes['reject_number'];
    }
    public function getTravelTypeIdAttribute(){
        return (int)$this->attributes['travel_type_id'];
    }
    public function getDestinationIdAttribute(){
        return (int)$this->attributes['destination_id'];
    }
    public function getCarTypeIdAttribute(){
        return (int)$this->attributes['car_type_id'];
    }
    public function getInsurancePassengerAttribute(){
        return (int)$this->attributes['insurance_passenger'];
    }
    public function getInsuranceBodyAttribute(){
        return (int)$this->attributes['insurance_body'];
    }
    public function getStatusAttribute(){
        return (int)$this->attributes['status'];
    }

    public function carType(){
        return $this->hasOne('App\Model\Core\CarSystem', 'id', 'car_type_id');
    }
    public function travelType(){
        return $this->hasOne('App\Model\Core\TravelType', 'id', 'travel_type_id');
    }
    public function destination(){
        return $this->hasOne('App\Model\Core\Destination', 'id', 'destination_id');
    }
    public function seats(){
        return $this->hasMany('App\Model\Company\RoutePrice', 'route_id', 'id');
    }

}
