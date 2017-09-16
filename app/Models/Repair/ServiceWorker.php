<?php

namespace App\Models\Repair;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ServiceWorker extends Authenticatable
{
    //分类多对多关联
    public function classify()
    {
        return $this->belongsToMany('App\Models\Repair\Classify');
    }

    //对应服务商多对多关联
    public function service_provider()
    {
        return $this->belongsToMany('App\Models\Repair\ServiceProvider');
    }
}
