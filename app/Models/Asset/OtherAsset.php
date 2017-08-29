<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class OtherAsset extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Asset\AssetCategory');
    }
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
}
