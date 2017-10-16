<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
    public function supplier()
    {
        return $this->belongsToMany('App\Models\Asset\Supplier');
    }
}
