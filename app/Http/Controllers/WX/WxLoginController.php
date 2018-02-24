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


        $appid = "wxc6cf5e40791e50d3" ;
        $secret = "f462f2ea18595a45235b5c9512a8575f";

//        $URL = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";


//        $code2session_url = "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code";

//        $code2session_url = sprintf($code2session_url,$appid,$secret,$code);
//        $userInfo = $this->httpRequest($code2session_url);

//        $userInfo = $this->httpRequest($URL);
//        if(!isset($userInfo['session_key'])){
//            return [
//                'code' => 10000,
//                'code' => '获取 session_key 失败1',
//            ];
//        }
//        $this->sessionKey = $userInfo['session_key'];
//        return $userInfo;




        $appid = 'wx4f4bc4dec97d474b';
        $sessionKey = 'tiihtNczf5v6AKRyjwEUhQ==';

        $encryptedData="CiyLU1Aw2KjvrjMdj8YKliAjtP4gsMZM
            QmRzooG2xrDcvSnxIMXFufNstNGTyaGS
                9uT5geRa0W4oTOb1WT7fJlAC+oNPdbB+
                3hVbJSRgv+4lGOETKUQz6OYStslQ142d
                NCuabNPGBzlooOmB231qMM85d2/fV6Ch
                evvXvQP8Hkue1poOFtnEtpyxVLW1zAo6
                /1Xx1COxFvrc2d7UL/lmHInNlxuacJXw
                u0fjpXfz/YqYzBIBzD6WUfTIF9GRHpOn
                /Hz7saL8xz+W//FRAUid1OksQaQx4CMs
                8LOddcQhULW4ucetDf96JcR3g0gfRK4P
                C7E/r7Z6xNrXd2UIeorGj5Ef7b1pJAYB
                6Y5anaHqZ9J6nKEBvB4DnNLIVWSgARns
                /8wR2SiRS7MNACwTyrGvt9ts8p12PKFd
                lqYTopNHR1Vf7XjfhQlVsAJdNiKdYmYV
                oKlaRv85IfVunYzO0IKXsyl7JCUjCpoG
                20f0a04COwfneQAGGwd5oa+T8yO5hzuy
                Db/XcxxmK01EpqOyuxINew==";
//
        $iv = 'r7BXXKkLb8qrSNn05n0qiA==';

        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );

        if ($errCode == 0) {
            print($data . "\n");
        } else {
            print($errCode . "\n");
        }




    }

    public function httpRequest($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if($output === FALSE ){
            return false;
        }
        curl_close($curl);
        return json_decode($output,JSON_UNESCAPED_UNICODE);
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
