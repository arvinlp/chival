<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class UserHistory extends Model{

    use SoftDeletes;
    //
    public function getCreatedAtAttribute(){
        $date = Carbon::parse($this->attributes['created_at']);
        $jdata = Jalalian::forge($date->getTimestamp());
        return $jdata->getHour().':'.$jdata->getMinute().':'.$jdata->getSecond().' - '.$jdata->getYear().'/'.$jdata->getMonth().'/'.$jdata->getDay();
    }

    public function chivalUserHistory(){
        return $this->belongsTo('App\Admin', 'user_id', 'id');
    }

    public function companyUserHistory(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
