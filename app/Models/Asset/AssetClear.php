<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetClear extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }
}
