<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public function org()
    {
        return $this->belongsTo('App\Models\User\Org');
    }
    public function file(){
        return $this->belongsTo('App\Models\File\File');
    }
}
