<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;

class County extends Model {
    protected $fillable = [
        'id', 
        'provience_id',
        'name',
    ];
}
