<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;

class CarDestenation extends Model
{
    //
    public function company(){
        return $this->hasOne('App\Model\Company\Company', 'id', 'company_id');
    }
    public function car(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id');
    }
}