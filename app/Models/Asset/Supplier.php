<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Asset\AssetCategory','category_id');
    }
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
}
