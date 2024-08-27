<?php

namespace App\Model\Company;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Model\Core\Province;
use App\Model\Core\County;
use App\Model\Core\City;
use App\Model\Company\CompanySetting;
use App\User;

class Company extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 
        'tell', 
        'address',
        'postal_code', 
        'province',
        'county',
        'city', 
        'note',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The appends values to model's.
     *
     * @var array
     */
    protected $appends = [
        'location',
        'company_manager',
        'folder'
    ];

    public function getFolderAttribute(){
        $companyFolder = CompanySetting::where('company_id',$this->attributes['id'])
            ->where('key','company_folder');
        if(! $folder = $companyFolder->first())
            return null;
        return $folder->value;
    }

    public function getLocationAttribute(){
        $province = Province::find($this->attributes['province']);
        $county = County::find($this->attributes['county']);
        $city = City::find($this->attributes['city']);
        return $province->name.' - '.$county->name.' - '.$city->name;
    }

    public function getCompanyManagerAttribute(){
        $companyManagerID = CompanySetting::select('value')->where('company_id',$this->attributes['id'])->where('key','manager_id')->first();
        if($companyManagerID)
            return User::select(['id','fname','lname','mobile','email','role_id','company_id'])->findOrFail($companyManagerID)->first();
        return null;
    }

    /**
     * Relations
     */
    public function settings(){
        return $this->hasMany('App\Model\Company\CompanySetting', 'company_id', 'id');
    }
}
