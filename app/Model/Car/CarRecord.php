<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;

class CarRecord extends Model{

    public function car(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id');
    }
}