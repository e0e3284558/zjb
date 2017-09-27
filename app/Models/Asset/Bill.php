<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function contract()
    {
        return $this->belongsTo('App\Models\Asset\Contract');
    }
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
}
