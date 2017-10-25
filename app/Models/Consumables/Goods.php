<?php

namespace App\Models\Consumables;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable=[
        'coding','name','classify_id','barcode','norm',
        'unit','trademark','inventory_cap','inventory_lower',
        'disable','comment','upload_id','org_id','user_id'
    ];
    public function file() {
        return $this->belongsTo(\App\Models\File\File::class);
    }
    public function depot()
    {
        return $this->belongsToMany('App\Models\Consumables\Depot')
                    ->withPivot('goods_number', 'goods_price');
    }
}
