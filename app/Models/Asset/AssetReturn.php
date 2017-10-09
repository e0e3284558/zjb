<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetReturn extends Model
{
    public function return_dispose_user()
    {
        return $this->belongsTo('App\Models\User\User','return_dispose_user_id');
    }
}
