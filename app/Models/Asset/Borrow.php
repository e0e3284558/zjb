<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    public function borrow_handle_user()
    {
        return $this->belongsTo('App\Models\User\User','borrow_handle_user_id');
    }
    public function return_handle_user()
    {
        return $this->belongsTo('App\Models\User\User','return_handle_user_id');
    }
}
