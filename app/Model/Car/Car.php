<?php

namespace App\Model\Car;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

use App\Model\Car\CarTechnicalDiagnose as TD;
use App\Model\Car\CarInsurance as Insurance;
use App\Model\Car\CarDestenation as Destenation;

class Car extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'td_expire',
        'insurance_third',
    ];
    protected $appends = [
        'td_expire',
        'insurance_third',
        'partnear_code'
    ];
    /**
     * 
     */

    public function getTdExpireAttribute(){
        if($back = TD::select('expire_date')->where('id',$this->attributes['technical_diagnose_id'])->first()){
            return Jalalian::forge($back->expire_date)->format('%Y/%m/%d');
        }
        return "-";
    }
    public function getInsuranceThirdAttribute(){
        if($back = Insurance::select('expire_date')->where('id',$this->attributes['insurance_id'])->first()){
            return Jalalian::forge($back->expire_date)->format('%Y/%m/%d');
        }
        return "-";
    }
    public function getCarCodeAttribute(){
        return empty($this->attributes['car_code']) ? null : (float) $this->attributes['car_code'];
    }
    public function getPartnearCodeAttribute(){
        if(Auth::guard('company')->user()){
            if($de = Destenation::where('car_id',$this->attributes['id'])->where('company_id', Auth::guard('company')->user()->company_id)->first()){
                return empty($de->car_code) ? null : (float)$de->car_code;
            }
        }
        return "-";
    }
    /**
     * Relations
     */
    public function carSystem(){
        return $this->hasOne('App\Model\Core\CarSystem', 'id', 'car_type_id');
    }
    public function carType(){
        return $this->hasOne('App\Model\Core\CarType', 'id', 'car_system_id');
    }
    public function primary(){
        return $this->hasOne('App\Model\Driver\Driver', 'car_id', 'id')->where('car_id',$this->id);
    }
    public function owners(){
        return $this->belongsToMany('App\Model\Car\Owner','owner_histories','car_id','owner_id')
        ->using('App\Model\Car\OwnerHistoryPivot')
        ->withPivot([
            'old_car_card_no', 'old_vin', 'old_year', 'old_fuel', 'old_capacity', 
            'old_status_note', 'old_plate_series',
            'old_plate_series_1', 'old_plate_series_2', 'old_plate_series_3',
            'old_insurance_body'
        ]);
    }

    public function owner(){
        return $this->hasOne('App\Model\Car\Owner','id','owner_id');
    }


}
