<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Model\Company\Company;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class CompanyContract extends Model {
    public $timestamps = false;


    protected $appends = [
        'company',
        'partner_code',
        'partner',
        'expire_date_j',
    ];

    public function getExpireDateJAttribute(){
        $date = Carbon::parse($this->attributes['expire_date']);
        $jdata = Jalalian::forge($date->getTimestamp());
        return $jdata->getYear().'/'.$jdata->getMonth().'/'.$jdata->getDay();
    }

    public function getPartnerAttribute(){
        if(Auth::guard('company')->user()->company_id == $this->attributes['company_id']){
            $partner = Company::find($this->attributes['partner_id']);
        }else{
            $partner = Company::find($this->attributes['company_id']);
        }
        return $partner->name;
    }
    public function getPartnerIdAttribute(){
        if(Auth::guard('company')->user()->company_id == $this->attributes['company_id']){
            $partner = Company::find($this->attributes['partner_id']);
        }else{
            $partner = Company::find($this->attributes['company_id']);
        }
        return $partner->id;
    }

    public function getCompanyIdAttribute(){
        return Auth::guard('company')->user()->company_id;
    }
    public function getCompanyAttribute(){
        $company = Company::find(Auth::guard('company')->user()->company_id);
        return $company->name;
    }

    public function getPartnerCodeAttribute(){
        if(Auth::guard('company')->user()->company_id == $this->attributes['company_id']){
            $company = Company::find($this->attributes['partner_id']);
        }else{
            $company = Company::find($this->attributes['company_id']);
        }
        if(! $company) return 0;
        return (int)$company->company_code;
    }

    /**
     * Relatons
     */
    public function iPartner(){
        return $this->belongsToMany('App\Model\Company\Company', 'company_contracts', 'id', 'company_id');
    }
    public function myPartners(){
        return $this->belongsToMany('App\Model\Company\Company', 'company_contracts', 'id', 'partner_id');
    }
}
