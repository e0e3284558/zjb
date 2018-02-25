<?php

namespace App\Http\Controllers\WX;

use App\Models\Asset\Asset;
use App\Models\Repair\ServiceWorker;
use App\Models\User\Org;
use App\Models\User\User;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Iwanli\Wxxcx\WXBizDataCrypt;
use Iwanli\Wxxcx\Wxxcx;
use Illuminate\Support\Facades\Hash;
use Overtrue\LaravelWeChat\Facade;

include_once   app_path('/Http/Controllers/WX/wxBizDataCrypt.php');

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

        //获取解密后的用户信息
        return $this->wxxcx->getUserInfo($encryptedData, $iv);

    }

    public function addUser(Request $request){
        //获取资产的org_id

        $asset_info = Asset::where("asset_uid",$request->asset_uuid)->first();
        if(User::where("union_id",$request->unionid)->first()){
            if(User::where("union_id",$request->unionid)->value("openid")){
                $message = [
                    'code' => 0,
                    'message' => '用户已存在'
                ];
            }else{
                $info = User::where("union_id",$request->unionid)->update('openid',$request->openid);
                if($info){
                    $message = [
                        'code' => 1,
                        'message' => '用户添加成功'
                    ];
                }
            }

        } else {
            $user = new User;
            $user->openid = $request->openId;
            $user->union_id = $request->unionid;
            $user->name = $request->name;
            if ($user->save()) {
                if ($user->orgs()->sync($asset_info->org_id)) {
                    $message = [
                        'code' => 1,
                        'message' => '用户添加成功'
                    ];
                } else {
                    $message = [
                        'code' => 0,
                        'message' => '网络错误'
                    ];
                }
            } else {
                $message = [
                    'code' => 0,
                    'message' => '用户添加失败'
                ];
            }
        }
        return $message;
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

    /**
     * 查询是否手机号已经授权
     * @param Request $request
     * @return array
     */
    public function phoneAuthorize(Request $request){
        //$request->role   1 普通用户  2 维修人员
//        if($request->role==1){
//            $info = User::where("openid",$request->openId)->first();
//        }else{
            $info = ServiceWorker::where("openid",$request->openId)->first();
//        }
        if($info){
            $message=[
                'code' => 1,
                'message' => '已经授权'
            ];
        }else{
            $message=[
                'code' => 0,
                'message' => '需要授权'

            ];
        }

        return $message;
    }


    /**
     * 获取微信用户绑定的手机号
     * @param Request $request
     * @return array
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
        if($request->code==2){
            $appid = 'wxc6cf5e40791e50d3';
        }else{
            $appid = 'wxfb71758f0f043c02';
        }

        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );


        //授权用户手机号 修改授权状态
        $phone_info = json_decode($data);

        if($request->role==1){
            $info = User::where("tel",$phone_info->phoneNumber)->first();
        }else{
            $info = ServiceWorker::where("tel",$phone_info->phoneNumber)->first();
            if(!$info){
                return $message = [
                    'code' => 0,
                    'message' => '你没有报修权限，请联系管理员'
                ];
            }
        }

        if($info){
            if($request->role==1){
                $info = User::where("id",$info->id)->update(['phone_authorize'=>1]);
            }else{
                $info = ServiceWorker::where("id",$info->id)->update(['phone_authorize'=>1,'union_id'=>$request->union_id,'openid'=>$request->openid]);
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
     * @param Request $request
     * @return array|mixed
     */
    public function workerLogin(Request $request)
    {
        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');


        $appid = "wxc6cf5e40791e50d3" ;

        $config = [
            'app_id' => 'wxc6cf5e40791e50d3',
            'secret' => 'f462f2ea18595a45235b5c9512a8575f',

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        $app = Factory::miniProgram($config);

        $user = $app->auth->session($code);

        $pc = new WXBizDataCrypt($appid, $user['session_key']);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );

        if ($errCode == 0) {
//            print($data . "\n");
            $userInfo = json_decode($data);
//            dump($userInfo);
            //首先判断维修人员是否已经认证
            $workerInfo = ServiceWorker::where("union_id",$userInfo->unionId)->first();

            dump($workerInfo);
//            if($workerInfo){
//                if($workerInfo->openid){
//                    //获取解密后的用户信息
//                    return $userInfo;
//                }else{
//                    return $message = [
//                        'code' => 0,
//                        'message' => '对不起，你不是维修人员'
//                    ];
//                }
//            }else{
//                //获取解密后的用户信息
//                $judge = ServiceWorker::where("openid",$userInfo->openId)->first();
//
//                if(!$judge){
//                    return $message = [
//                        'code' => 0,
//                        'message' => '对不起，你不是维修人员'
//                    ];
//                }else{
//                    //获取解密后的用户信息
//                    return $userInfo;
//                }
//            }

        } else {
            print($errCode . "\n");
        }
    }


    /*public function workerLogin(Request  $request)
    {
        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);


        //首先判断维修人员是否已经认证
        $workerInfo = ServiceWorker::where("union_id",$userInfo['unionid'])->first();
        if($workerInfo){
            if($workerInfo->openid){
                //获取解密后的用户信息
                return $this->wxxcx->getUserInfo($encryptedData, $iv);
            }else{
                return $message = [
                    'code' => 0,
                    'message' => '对不起，你不是维修人员'
                ];
            }
        }else{
            //获取解密后的用户信息
            return $this->wxxcx->getUserInfo($encryptedData, $iv);
        }

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
    }*/

    /**
     * 利用资产的org_id查找公司是否需要LDAP验证登录
     * @param Request $request
     * @return array
     */
    public function needValidation(Request $request){
        $asset_info = Asset::where("asset_uid",$request->asset_uuid)->first();
        if($asset_info){
            $org_info = Org::find($asset_info->org_id);
            if($org_info->is_ldap){
                //需要LDAP验证登录
                $message = [
                    'code' => 1,
                    'message' => '需要LDAP验证登录'
                ];
            }else{
                //不需要LDAP验证登录
                $message = [
                    'code' => 0,
                    'message' => '不需要LDAP验证登录'
                ];
            }
        }else{
            $message = [
                'code' => 403,
                'message' => '二维码url信息错误'
            ];
        }

        return $message;
    }

}
