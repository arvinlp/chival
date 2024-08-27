<?php

namespace App\Model\CompanyPayment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class CenteralPcposTerminalUser extends Model{
    
    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function terminal(){
        return $this->hasOne('App\Model\CompanyPayment\CenteralPcposTerminal', 'id', 'terminal_id');
    }
}
