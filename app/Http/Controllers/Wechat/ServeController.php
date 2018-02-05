<?php

namespace App\Http\Controllers\Wechat;

use App\Models\User\User;
use App\Http\Controllers\Controller;
use App\Models\WeChat\Test;
use Illuminate\Support\Facades\Log;

class ServeController extends Controller
{

    public function get_unionID($open_id)
    {
        //公众号获取token
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9105e296fd5119cf&secret=3e8211e98a09d18c9410823e9f2781cf';
        $html = file_get_contents($url);
        $token = (json_decode($html)->access_token);

        //获取用户的UnionID
        $get_UnionID_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $token . '&openid='.$open_id.'=zh_CN ';
        $UnionID_html = file_get_contents($get_UnionID_url);
        $test=new Test;
        $test->comment=$get_UnionID_url;
        $test->save();
        return $UnionID_html;
    }


    public function serve(){
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    $user = User::where('g_open_id')->frist()->value('id');
                    return '收到事件消息UnionID' .  $user;
                    $test=new Test;
                    $test->comment=$user->id?$user->id:'空';
                    $test->save();
                    if ($user->union_id){
                        if (! $user->g_open_id) {
                            $user_g = new User;
                            $user_g->g_open_id = $message['FromUserName'];
                        }
                    }else{
                        $user_g = new User;
                        $user_g->g_open_id = $message['FromUserName'];
                        $user_g->union_id=$this->get_unionID($message['FromUserName']);
                    }
                    $user_g->save();
                    return '收到事件消息UnionID' .  $user_g->g_open_id;
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
