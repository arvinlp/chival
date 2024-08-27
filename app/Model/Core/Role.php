<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model{
    
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
    public function roles(){
        return $this->hasMany('App\Model\Core\RoleAccess', 'role_id', 'id');
    }
    public function companyRole(){
        return $this->belongsTo('App\Model\Company\Company','company_id','id');
    }
}
