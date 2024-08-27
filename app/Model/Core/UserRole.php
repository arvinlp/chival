<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot {

    protected $table = "user_roles";
    public $timestamps = false;

}
