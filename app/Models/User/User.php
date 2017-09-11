<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
}
