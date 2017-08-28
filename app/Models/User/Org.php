<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    public function scopeUserUint($query){
        return $query->where('id',auth()->user()->org_id);
    }
}
