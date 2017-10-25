<?php

namespace App\Models\Consumables;

use Illuminate\Database\Eloquent\Model;

class Shipments extends Model
{
    //
    public function depot()
    {
        return $this->belongsTo('App\Models\Consumables\Depot');
    }

    //
    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }

    public function details()
    {
        return $this->hasMany('App\Models\Consumables\WarehousingInventory','warehousing_id');
    }
}
