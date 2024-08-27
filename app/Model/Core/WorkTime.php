<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkTime extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 
        'updated_at',
        'deleted_at',
    ];

    public function scopeOfType($query, $type = null){
        if($type == null)
            return $query;
        return $query->where('type', $type);
    }

    /**
     * Relations
     */
    public function admins(){
        return $this->belongsToMany('App\Admin','user_work_times','work_time_id','user_id')->using('App\Model\Core\UserWorkTime');
    }
    public function users(){
        return $this->belongsToMany('App\User','user_work_times','work_time_id','user_id')->using('App\Model\Core\UserWorkTime');
    }
}
