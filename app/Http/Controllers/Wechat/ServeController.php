<?php

namespace App\Http\Controllers\Wechat;

use App\Models\WeChat\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ServeController extends Controller
{
    public function serve()
    {
        $app = app('wechat.official_account');
        $app->server->push(function($message){
            $test=new Test;
            $test->comment=$message;
            $test->save();
            return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }
}
