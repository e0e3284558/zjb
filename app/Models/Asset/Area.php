<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
}
