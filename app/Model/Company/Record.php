<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model{
    use SoftDeletes;

    //
    public function travels(){
        return $this->hasMany('App\Model\Company\\TravelRecord', 'record_id', 'id');
    }
    public function lastTravel(){
        return $this->hasOne('App\Model\Company\\TravelRecord', 'record_id', 'id')->latest();
    }
    public function travelType(){
        return $this->hasOne('App\Model\Core\TravelType', 'id', 'travel_type_id');
    }
    public function lastRecordUsed(){
        return $this->hasOne('App\Model\Company\TravelRecord', 'record_id', 'id');
    }
}
