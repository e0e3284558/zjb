<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetUse extends Model
{
    protected $table = "asset_uses";

    public function use_dispose_user()
    {
        return $this->belongsTo('App\Models\User\User','use_dispose_user_id');
    }
    public function return_dispose_user()
    {
        return $this->belongsTo('App\Models\User\User','return_dispose_user_id');
    }

}
