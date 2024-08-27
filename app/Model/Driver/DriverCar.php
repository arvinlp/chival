<?php

namespace App\Model\Driver;

use Illuminate\Database\Eloquent\Model;

class DriverCar extends Model{
    public $timestamps = false;

    /**
     * Get the user associated with the DriverCar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function car(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id');
    }
}