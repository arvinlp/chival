<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;

class TravelPassenger extends Model{

    protected $appends = [
        'other_seats'
    ];

    public function getParentIdAttribute(){
        return (int) $this->attributes['parent_id'];
    }
    public function getOtherSeatsAttribute(){
        if($otherSeats = self::where('parent_id',$this->attributes['id'])->where('travel_id',$this->attributes['travel_id'])->get()){
            return $otherSeats->pluck('seat_number');
        }
        return [];
    }
}
