<?php

namespace App\Models\Repair;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classify extends Model
{
    use SoftDeletes;

    /**
     * 需要被转换成日期的属性。
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable=['id','name','comment','icon','sorting','org_id'];

    public function serviceWorker()
    {
        return $this->belongsToMany('App\Models\Repair\ServiceWorker');
    }

}
