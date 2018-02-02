<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'web'; // or whatever guard you want to use
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','tel','avatar','org_id','department_id','is_org_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取与用户关联的部门
     */
    public function department()
    {
        return $this->belongsTo('App\Models\User\Department');
    }

    /**
     * 获取当前登录用户所属单位信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function org(){
        return $this->belongsTo('App\Models\User\Org');
    }

    public function orgs()
    {
        return $this->belongsToMany('App\Models\User\Org');
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
