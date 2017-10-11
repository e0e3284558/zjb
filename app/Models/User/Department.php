<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    // use softDeletes;
    public function scopeOrg($query){
        return $query->where('org_id',auth()->user()->org_id);
    }
    public static function getSpaceTreeData(){
        $data = self::org()->where('status',1)->get()->toArray();
        return formatTreeData($data);
    }

    public function classify()
    {
        return $this->belongsToMany('App\Models\Repair\Classify');
    }

    public function assetCategory()
    {
        return $this->belongsToMany('App\Models\Asset\AssetCategory');
    }
}
