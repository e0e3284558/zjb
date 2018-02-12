<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Repair\ServiceWorker;
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
        $get_UnionID_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $token . '&openid=' . $open_id . '&lang=zh_CN ';
        $UnionID_html = file_get_contents($get_UnionID_url);
        $user_info = json_decode($UnionID_html);
        return $user_info;
    }


    /**
     * 判断是否为在小程序注册的用户，如果小程序已经注册，则根据union_id绑定公众号，否则不执行操作
     * @param $open_id
     */
    public function is_applet_user($open_id)
    {
        $user_info = $this->get_unionID($open_id);
        $union_id = $user_info->unionid;
        $service_worker = ServiceWorker::where('union_id', $union_id)->frist();
        $user = User::where('union_id', $union_id)->frist();
        if ($service_worker) {
            if (ServiceWorker::where('union_id', $union_id)->update(['g_open_id' => $open_id])) {
                return '维修人员身份认证绑定成功';
            } else {
                return '维修人员身份认证绑定失败';
            }
        }
        if ($user) {
            if (User::where('union_id', $union_id)->update(['g_open_id' => $open_id])) {
                return '恭喜您公众号绑定成功';
            } else {
                return '抱歉，公众号绑定失败';
            }
        }
        $user = new User;
        $user->name = $user_info->nickname;
        $user->avatar = $user_info->headimgurl;
        $user->g_open_id = $user_info->open_id;
        $user->union_id = $user_info->union_id;
        if ($user->save()) {
            return '恭喜您，关注成功';
        } else {
            return '关注失败，请联系管理员';
        }
    }


    public function serve()
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return $this->is_applet_user($message['FromUserName']);
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
