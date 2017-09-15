<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Asset\AssetCategory','category_id');
    }
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User\User','user_id');
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\User\User','admin_id');
    }
    public function source()
    {
        return $this->belongsTo('App\Models\Asset\Source');
    }
    public function area()
    {
        return $this->belongsTo('App\Models\Asset\Area');
    }
    public function department()
    {
        return $this->belongsTo('App\Models\User\Department');
    }

    public function useDepartment()
    {
        return $this->belongsTo('App\Models\User\Department','use_department_id');
    }

    public function file(){
        return $this->belongsToMany('App\Models\File\File');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Asset\Supplier');
    }
}
