<?php
/*
 * @Author: arvinlp 
 * @Date: 2020-02-29 23:25:21 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by:   Arvin.Loripour 
 * @Last Modified time: 2020-02-29 23:25:21 
 */

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class CarTechnicalDiagnose extends Model{
	
    public function getExpireDateAttribute(){
        // $date = Carbon::parse($this->attributes['expire_date']);
        // $jdata = Jalalian::forge($date->getTimestamp());
        // return $jdata->getYear().'/'.$jdata->getMonth().'/'.$jdata->getDay();
        return $this->attributes['expire_date'];
    }
}
