<?php

namespace App\Models\Repair;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProvider extends Model
{
    use SoftDeletes;
    //
    protected $fillable=['name','user','tel','logo_id','upload_id','comment'];

    //对应维修工多对多关联
    public function service_worker()
    {
        return $this->belongsToMany('App\Models\Repair\ServiceWorker');
    }

    //对应公司多对多关联
    public function org()
    {
        return $this->belongsToMany('App\Models\User\Org')->withPivot('status');
    }
}
