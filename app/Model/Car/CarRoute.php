<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;

class CarRoute extends Model
{
    //
    public function route(){
        return $this->hasOne('App\Model\Company\Route', 'id', 'route_id');
    }
    public function car(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id');
    }
}
