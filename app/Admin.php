<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;

use App\Model\Core\Role;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use SoftDeletes;
    use Authenticatable, Authorizable;

    protected $table = "users";

    protected static function boot(){
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'admin');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nation_code', 
        'mobile', 
        'username', 
        'fname', 
        'lname',
        'sex', 
        'birthday',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'company_id',
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'admin',
    ];

    /**
     * The appends values to model's.
     *
     * @var array
     */
    protected $appends = [
        'role',
        'level',
        'work_time',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['guard' => 'chival'];
    }

    public function getRoleAttribute(){
        $role_id = $this->attributes['role_id'];
        if($role_id == null){
            return '-';
        }
        $role = Role::find($role_id);
        return $role->name;
    }

    public function getLevelAttribute(){
        $role_id = $this->attributes['role_id'];
        if($role_id == null){
            return '-';
        }
        $role = Role::find($role_id);
        return $role->level;
    }

    public function getLevelNameAttribute(){
        $role_id = $this->attributes['role_id'];
        if($role_id == null){
            return '-';
        }
        $role = Role::find($role_id);
        return $role->level;
    }

    public function getWorkTimeAttribute(){
        $user_id = $this->attributes['id'];
        $workTime = $this->userWorkTimes($user_id);
        
        return $workTime;
    }

    
    /**
     * 
     */
    public function userIsActive(){
        switch($this->attributes['status']){
            case 0:
                return response()->json([
                    'message'   => 'دسترسی شما مسدود شده است.',
                    'code'      => (int) 401,
                ], 401);
            case 2:
                return response()->json([
                    'message'   => 'دسترسی شما معلق شده است',
                    'code'      => (int) 401,
                ], 401);
            
            default:
                break;
        }
    }

    public function userWorkTime($id){
        $workTime = self::with(['workTimes' => function ($query) {
            $week = Carbon::now()->dayOfWeek + 1;
            $query->whereWeek($week);
        }])->where('id', '=', $id)->get();
        
        if(count($workTime[0]->workTimes) > 0){
            $workTimes = $workTime[0]->workTimes[0];
            if($workTimes){
                if($workTimes->start == $workTimes->end){
                    $time = Carbon::now();
                    $expireTime = ((24-$time->hour)*60)-($time->minute);
                    return $expireTime;
                }
                if($workTimes->start < date('H:i:s') & $workTimes->end > date('H:i:s')){
                    $start  = explode(':',(string)$workTimes->start);
                    $start  = (int)$start[0] * 60 + (int)$start[1];
                    $end    = explode(':',$workTimes->end);
                    $end    = (int)$end[0] * 60 + (int)$end[1];
                    $wt     = $end - $start;
                    return $wt;
                }else{
                    return -1;
                }
            }
        }
        return -2;
    }

    public function userWorkTimes($id){
        $workTime = self::with(['workTimes' => function ($query) {
            $week = Carbon::now()->dayOfWeek + 1;
            $query->whereWeek($week);
        }])->where('id', '=', $id)->get();
        if(count($workTime[0]->workTimes) > 0){
            $workTimes = $workTime[0]->workTimes[0];
            if($workTimes){
                if($workTimes->start == $workTimes->end){
                    return ['start'=>'شیفت کامل','end'=>'است'];
                }
                $start  = explode(':',(string)$workTimes->start);
                $end    = explode(':',(string)$workTimes->end);
                return ['start'=>'از '+$start[0]+$start[1],'end'=>'تا '+$end[0]+$end[1]];
            }
        }
        return ['start'=>'شیفت','end'=>'ندارد'];
    }


    /**
     * Relations
     */
    public function history(){
        return $this->hasMany('App\Model\Core\UserHistory', 'user_id', 'id');
    }
    public function roles(){
        return $this->hasMany('App\Model\Core\RoleAccess', 'role_id', 'role_id');
    }
    public function workTimes(){
        return $this->belongsToMany('App\Model\Core\WorkTime','user_work_times','user_id','work_time_id')
        ->using('App\Model\Core\UserWorkTime');
    }
}
