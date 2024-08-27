<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\Car\Owner;

class OwnerHistory extends Model{

    use SoftDeletes;

    protected $table = "owner_histories";

    public function getPersonalNameAttribute(){
        $id = $this->attributes['owner_id'];
        $owner = Owner::find($id);
        return $owner->first_name.' '.$owner->last_name;
    }
    public function getNationCodeAttribute(){
        $id = $this->attributes['owner_id'];
        $owner = Owner::find($id);
        return 'test';
    }
    public function getTelAttribute(){
        $id = $this->attributes['owner_id'];
        $owner = Owner::find($id);
        return $owner->tel;
    }
    public function getMobileAttribute(){
        $id = $this->attributes['owner_id'];
        $owner = Owner::find($id);
        return $owner->mobile;
    }
    public function getAddressAttribute(){
        $id = $this->attributes['owner_id'];
        $owner = Owner::find($id);
        return $owner->address;
    }

    public function owners(){
        return $this->hasOne('App\Model\Car\Owner', 'id', 'owner_id');
    }
    
}