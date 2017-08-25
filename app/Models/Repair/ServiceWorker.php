<?php

namespace App\Models\Repair;

use Illuminate\Database\Eloquent\Model;

class ServiceWorker extends Model
{
    //
    public function classify()
    {
        return $this->belongsToMany('App\Models\Repair\Classify');
    }
}
