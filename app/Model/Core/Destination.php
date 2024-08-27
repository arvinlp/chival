<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    //
    public function getCodeAttribute(){
        return (int)$this->attributes['code'];
    }
    public function getProvinceAttribute(){
        return (int)$this->attributes['province'];
    }
    public function getCountyAttribute(){
        return (int)$this->attributes['county'];
    }
    public function getCityAttribute(){
        return (int)$this->attributes['city'];
    }
    public function getStatusAttribute(){
        return (int)$this->attributes['status'];
    }

    
    public function province(){
        return $this->hasOne(App\Model\Core\Province::class, 'province', 'id');
    }
    public function county(){
        return $this->hasOne(App\Model\Core\County::class, 'county', 'id');
    }
    public function city(){
        return $this->hasOne(App\Model\Core\City::class, 'city', 'id');
    }
}
