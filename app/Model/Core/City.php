<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;

class City extends Model {
    protected $fillable = [
        'id', 
        'provience_id',
        'county_id',
        'name',
    ];
}
