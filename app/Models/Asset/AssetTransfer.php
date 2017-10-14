<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    public function out_admin()
    {
        return $this->belongsTo('App\Models\User\User','out_admin_id');
    }
    public function put_admin()
    {
        return $this->belongsTo('App\Models\User\User','put_admin_id');
    }

    public function put_area()
    {
        return $this->belongsTo('App\Models\Asset\Area','put_area_id');
    }
    public function put_department()
    {
        return $this->belongsTo('App\Models\User\Department','put_department_id');
    }
}
