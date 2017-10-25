<?php

namespace App\Models\Consumables;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    //
    protected $fillable=['name','coding','org_id'];

    public function goods()
    {
        return $this->belongsToMany('App\Models\Consumables\Goods')
                    ->withPivot('goods_number', 'goods_price');
    }
}
