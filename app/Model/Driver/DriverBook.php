<?php
/*
 * @Author: arvinlp 
 * @Date: 2020-06-18 00:02:36 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-06-18 00:05:26
 */

namespace App\Model\Driver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class DriverBook extends Model{
    use SoftDeletes;
    //
    
    /**
     * The appends values to model's.
     *
     * @var array
     */
    protected $appends = [
        'expire_date_jalali'
    ];

    public function getExpireDateJalaliAttribute(){
        $date = Carbon::parse($this->attributes['expire_date']);
        $jdata = Jalalian::forge($date->getTimestamp());
        return $jdata->getYear().'/'.$jdata->getMonth().'/'.$jdata->getDay();
    }

    public function driver(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id');
    }
}
