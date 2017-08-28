<?php

namespace App\Models\Repair;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProvider extends Model
{
    use SoftDeletes;
    //
    protected $fillable=['name','user','tel','logo_id','upload_id','comment'];
}
