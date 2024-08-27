<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;

class RoutePrice extends Model {
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getSeatNumberAttribute(){
        return (int)$this->attributes['seat_number'];
    }
    public function getRouteIdAttribute(){
        return (int)$this->attributes['route_id'];
    }
    public function getPriceAttribute(){
        return (int)$this->attributes['price'];
    }
    public function getTaxAttribute(){
        return (int)$this->attributes['tax'];
    }
    public function getCommissionAttribute(){
        return (int)$this->attributes['commission'];
    }
    public function getPassengerAttribute(){
        return (int)$this->attributes['passenger'];
    }

    
    public function route(){
        return $this->belongsTo(App\Model\Company\Route::class, 'route_id', 'id');
    }
}
