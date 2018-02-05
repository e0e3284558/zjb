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
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息,open_id:' . $message['FromUserName'];
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                default:
                    return $message['FromUserName'];
            }
        });

        return $app->server->serve();
    }
}
