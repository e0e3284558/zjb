<?php

namespace App\Models\Repair;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    public function org(){
        return $this->belongsTo('App\Models\User\Org');
    }
    public function user(){
        return $this->belongsTo('App\Models\User\User');
    }
    public function admin(){
        return $this->belongsTo('App\Models\User\User','admin_id');
    }
    public function asset(){
        return $this->belongsTo('App\Models\Asset\Asset');
    }
    public function category(){
        return $this->belongsTo('App\Models\Asset\AssetCategory','asset_classify_id');
    }
    public function serviceWorker(){
        return $this->belongsTo('App\Models\Repair\ServiceWorker');
    }
    public function serviceProvider(){
        return $this->belongsTo('App\Models\Repair\ServiceProvider');
    }
}
