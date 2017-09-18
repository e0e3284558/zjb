<?php

namespace App\Http\Controllers\Cas;

use App\Models\Repair\ServiceWorker;
use App\Models\User\Org;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use phpCAS;

class DefaultController extends Controller
{
    
   public function index(Request $request,$uuid,$type="user"){

   		//通过单位uuid获取单位信息
   		$org = Org::where('uuid',$uuid)->first();
//        dump($org);
        //cas认证地址
        $cas_host = 'authserver.whit.edu.cn';//$org->cas_host;
        $cas_port = 443;//$org->cas_port;
        $cas_context = 'authserver';//$org->cas_context;
//        phpCAS::setDebug(storage_path('logs/cas.log'));
        phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context,false);
        //设置no ssl，即忽略证书检查.如果需要ssl，请用 phpCAS::setCasServerCACert()设置ssl证书，
        phpCAS::setNoCasServerValidation();
        phpCAS::handleLogoutRequests();
        phpCAS::forceAuthentication();

        //本地退出应该重定向到CAS进行退出，传递service参数可以使CAS退出后返回本应用
        if($request->logout){
            $param = array('service'=>route('cas',['uuid'=>$uuid,'type'=>$type]));
            phpCAS::logout($param);
            return null;
        }

//        dump(phpCAS::getAttributes());
        $username = phpCAS::getUser();
        if($type == 'user'){
            //普通用户登录
            $user = User::where('username',$username)->first();
            if($user) {
                $result = Auth::guard('web')->loginUsingId($user->id);
//                dump($result);
                return redirect('/home');
            }else{
                //用户不存在
                echo '认证失败，无此用户信息请联系管理员';
                exit;
            }
        }elseif($type == 'admin'){
            //管理人员登录
            echo '认证失败，请联系管理员';
            exit;
        }elseif($type == 'worker'){
            //维修工登录
            $user = ServiceWorker::where('username',$username)->first();
            if($user) {
                $result = Auth::guard('service_workers')->loginUsingId($user->id);
                if($result){
                    return  redirect('/worker');
                }
            }else{
                //维修工不存在
                echo '认证失败，无此用户信息请联系管理员';
                exit;
            }
        }else{
            echo '认证失败，无此用户信息请联系管理员';
            exit;
        }
   }
}
