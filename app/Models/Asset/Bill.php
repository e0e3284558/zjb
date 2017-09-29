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

    public function category()
    {
        return $this->belongsTo('App\Models\Asset\AssetCategory',"category_id");
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Asset\Supplier');
    }

}
