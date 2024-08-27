<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\Core\Province;
use App\Model\Core\County;
use App\Model\Core\City;

class Owner extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'full_address',
    ];
    protected $appends = [
        'full_address',
    ];
    public function car(){
        return $this->hasOne('App\Model\Car\Car','owner_id','id');
    }
    public function cars(){
        return $this->hasMany('App\Model\Car\Car','','car_id','owner_id')
        ->using('App\Model\Car\OwnerHistoryPivot')
        ->withPivot([
        ]);
    }
    public function getFullAddressAttribute(){
        $full = "";
        if($data = Province::find($this->attributes['province'])) $full .= $data->name." - ";
        if($data = County::find($this->attributes['county'])) $full .= $data->name." - ";
        if($data = City::find($this->attributes['city'])) $full .= $data->name." - ";
        if($this->attributes['address']) $full .= $this->attributes['address']." .";
        return $full;
    }
}
