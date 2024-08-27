<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class CarInsurance extends Model{
    
    public function getExpireDateAttribute(){
        // $date = Carbon::parse($this->attributes['expire_date']);
        // $jdata = Jalalian::forge($date->getTimestamp());
        // return $jdata->getYear().'/'.$jdata->getMonth().'/'.$jdata->getDay();
        return $this->attributes['expire_date'];
    }
    //
    public function company(){
        return $this->hasOne('App\Model\Core\InsuranceCompany', 'id', 'insurance_company_id');
    }
}