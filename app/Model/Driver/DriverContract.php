<?php

namespace App\Model\Driver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class DriverContract extends Model
{
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
