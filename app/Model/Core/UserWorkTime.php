<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserWorkTime extends Pivot {
    protected $table = "user_work_times";
    public $timestamps = false;


    // public function admins(){
    //     return $this->belongsToMany('App\Model\Core\WorkTime')
    //         ->withPivot('week', 'start', 'end')
    //         ->withTimestamps();
    // }

    // public function workTimes(){
    //     return $this->belongsToMany('App\Admin')
    //         ->withPivot('week', 'start', 'end')
    //         ->withTimestamps();
    // }
}
