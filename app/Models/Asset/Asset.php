<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Asset\AssetCategory');
    }
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User\User','admin_id');
    }
    public function source()
    {
        return $this->belongsTo('App\Models\Asset\Source');
    }
    public function department()
    {
        return $this->belongsTo('App\Models\User\Department');
    }

    public function file(){
        return $this->belongsToMany('App\Models\Asset\File');
    }
}
