<?php

namespace App\Model\CompanyPayment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class CenteralPcposTerminal extends Model
{
    use SoftDeletes;

    
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users(){
        return $this->hasMany('App\Model\CompanyPayment\CenteralPcposTerminalUser', 'terminal_id', 'id');
    }
    public function company(){
        return $this->hasMany('App\Model\Company\Company', 'company_id', 'id');
    }
}