<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnerHistoryPivot extends Pivot{
    
    use SoftDeletes;

    protected $table = "owner_histories";
}
