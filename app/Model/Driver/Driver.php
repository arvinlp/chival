<?php

namespace App\Model\Driver;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

use App\Model\Core\Bank;
use App\Model\Core\Province;
use App\Model\Core\County;
use App\Model\Core\City;
use App\Model\Driver\DriverBook;
use App\Model\Driver\DriverDestenation as Destenation;

class Driver extends Model
{
    use SoftDeletes;

    public function getRoleAttribute(){
        
    }

    protected $hidden = [
        'bank_name',
        'province_name',
        'county_name',
        'city_name',
        'book',
        'license_expire_date_persian',
        'health_expire_date_persian',
    ];
    protected $appends = [
        'bank_name',
        'province_name',
        'county_name',
        'city_name',
        'book',
        'license_expire_date_persian',
        'health_expire_date_persian',
        'partnear_code'
    ];

    public function getPartnearCodeAttribute(){
        if(Auth::guard('company')->user()){
            if($de = Destenation::where('driver_id',$this->attributes['id'])->where('company_id', Auth::guard('company')->user()->company_id)->first()){
                return empty($de->driver_code) ? null : (float)$de->driver_code;
            }
        }
        return "-";
    }
    public function getBankNameAttribute(){
        if($data = Bank::find($this->attributes['bank_id']))
            return $data->name;
        return '-';
    }
    public function getProvinceNameAttribute(){
        if($data = Province::find($this->attributes['province']))
            return $data->name;
        return '-';
    }
    public function getCountyNameAttribute(){
        if($data = County::find($this->attributes['county']))
            return $data->name;
        return '-';
    }
    public function getCityNameAttribute(){
        if($data = City::find($this->attributes['city']))
            return $data->name;
        return '-';
    }

    public function getBookAttribute(){
        if($book = DriverBook::select('expire_date')->where('driver_id',$this->attributes['id'])->first()){
            return Jalalian::forge($book->expire_date)->format('%Y/%m/%d');
        }
        return "-";
    }

    public function getLicenseExpireDatePersianAttribute(){
        if($this->attributes['driver_license_expire']) return Jalalian::forge($this->attributes['driver_license_expire'])->format('%Y/%m/%d');
        else return "-";
    }

    public function getHealthExpireDatePersianAttribute(){
        try{
            return $this->attributes['driver_health_expire'];
            return Jalalian::forge($this->attributes['driver_health_expire'])->format('%Y/%m/%d');
        }catch(\Expection $e){
            return "-";
        }
        return "-";
    }

    public function vehicle(){
        return $this->hasOne('App\Model\Car\Car', 'id', 'car_id');
    }
    public function bookTime(){
        return $this->hasOne('App\Model\Driver\DriverBook', 'id', 'driver_book_id');
    }
    public function bookTimes(){
        return $this->hasMany('App\Model\Driver\DriverBook', 'driver_id', 'id');
    }
    public function contract(){
        return $this->hasOne('App\Model\Driver\DriverContract', 'id', 'contract_id');
    }
    public function records(){
        return $this->hasMany('App\Model\Driver\DriverRecord', 'driver_id', 'id');
    }
}
