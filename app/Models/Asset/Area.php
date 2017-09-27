<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }

    public function scopeOrgs($query)
    {
        return $query->where('org_id', get_current_login_user_org_id());
    }

    public static function getSpaceTreeData()
    {
        $data = self::orgs()->where('status', 1)->get()->toArray();
        return formatTreeData($data,'id','pid');
    }
}
