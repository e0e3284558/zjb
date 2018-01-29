<?php

namespace App\Http\Controllers\WX;

use App\Models\Repair\ServiceWorker;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Iwanli\Wxxcx\WXBizDataCrypt;
use Iwanli\Wxxcx\Wxxcx;
use Illuminate\Support\Facades\Hash;

class WxLoginController extends Controller
{
    protected $wxxcx;

    public function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request  $request)
    {
        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);
//        $judge = User::where("openid",$userInfo['openid'])->first();
//        if(!$judge){
//            return $message = [
//                'code' => 0,
//                'message' => '请联系管理员'
//            ];
//        }else{
//            $id = $judge->id;
//        }

//        $_SESSION['user_id'] = $id;
//        $_SESSION['openid'] = $userInfo['openid'];

        //获取解密后的用户信息
        return $this->wxxcx->getUserInfo($encryptedData, $iv);

    }

    public function authentication(Request $request){
        if($request->role==1){
            $info = User::where("openid",$request->openId)->first();
            if($info){
                return $message = [
                    'code' => 1,
                    'message' => '已经进行身份验证'
                ];
            }else{
                return $message = [
                    'code' => 0,
                    'message' => '暂未验证'
                ];
            }
        }
    }

    public function jobNumber(Request $request){

        if($request->role==1){
            $info = User::where("job_number",$request->job_number)->first();
            if(Hash::check($request->password,$info->password)){
                if($info){
                    $info1 = User::where("job_number",$request->job_number)->update(["openId"=>$request->openId]);
                    if($info1){
                        return $message = [
                            'code' => 1,
                            'message' => '用户信息绑定成功'
                        ];
                    }

                }else{
                    return $message = [
                        'code' => 0,
                        'message' => '用户信息有误，稍后重试'
                    ];
                }
            }else{
                return $message = [
                    'code' => 0,
                    'message' => '用户信息有误，稍后重试'
                ];
            }

        }else{
            $info = ServiceWorker::where("job_number",$request->job_number)->first();
            if($info){
                $info1 = ServiceWorker::where("job_number",$request->job_number)->update(["openId"=>$request->openId]);
                if($info1){
                    return $message = [
                        'code' => 1,
                        'message' => '用户信息绑定成功'
                    ];
                }else{
                    return $message = [
                        'code' => 0,
                        'message' => '用户信息有误，稍后重试'
                    ];
                }
            }else{
                return $message = [
                    'code' => 0,
                    'message' => '用户信息有误，稍后重试'
                ];
            }
        }
    }

    /*
     * 查询是否手机号已经授权
     */
    public function phoneAuthorize(Request $request){
        //$request->role   1 普通用户  2 维修人员
        if($request->role==1){
            $info = User::where("openid",$request->openId)->first();
        }else{
            $info = ServiceWorker::where("openid",$request->openId)->first();
        }
        if($info->phone_authorize==0){
            return $message=[
                'code' => 0,
                'message' => '需要授权'
            ];
        }else{
            return $message=[
                'code' => 1,
                'message' => '已经授权'
            ];
        }
    }


    /*
     * 获取微信用户绑定的手机号
     */
    public function findPhone(Request $request){
        //$request->role   1 普通用户  2 维修人员

        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        $sessionKey = $userInfo['session_key'];
        $appid = 'wxfb71758f0f043c02';
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );


        //授权用户手机号 修改授权状态
        $phone_info = json_decode($data);

        if($request->role==1){
            $info = User::where("tel",$phone_info->phoneNumber)->first();
        }else{
            $info = ServiceWorker::where("tel",$phone_info->phoneNumber)->first();
        }

        if($info){
            if($request->role==1){
                $info = User::where("id",$info->id)->update(['phone_authorize'=>1]);
            }else{
                $info = ServiceWorker::where("id",$info->id)->update(['phone_authorize'=>1]);
            }
            if($info){
                $message = [
                    'code' => 1,
                    'message' => '手机号绑定成功'
                ];
            }else{
                $message = [
                    'code' => 0,
                    'message' => '手机号绑定失败'
                ];
            }
        }else{
            $message = [
                'code' => 0,
                'message' => '你没有报修权限，请联系管理员'
            ];
        }
        return $message;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workerLogin(Request  $request)
    {
        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        $judge = ServiceWorker::where("openid",$userInfo['openid'])->first();

        if(!$judge){
            return $message = [
                'code' => 0,
                'message' => '对不起，你不是维修人员'
            ];
        }else{
            //获取解密后的用户信息
            return $this->wxxcx->getUserInfo($encryptedData, $iv);
        }
    }

}
