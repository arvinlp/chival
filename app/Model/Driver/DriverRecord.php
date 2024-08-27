<?php

namespace App\Model\Driver;

use Illuminate\Database\Eloquent\Model;

class DriverRecord extends Model
{

    public function getRoleAttribute(){
        
    }

    public function driver(){
        return $this->hasOne('App\Model\Driver\Driver', 'id', 'driver_id');
    }
}
