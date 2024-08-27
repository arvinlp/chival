<?php

namespace App\Model\Driver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverDestenation extends Model
{
    use SoftDeletes;
    
    public function company(){
        return $this->hasOne('App\Model\Company\Company', 'id', 'company_id');
    }
    public function driver(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id');
    }
}
