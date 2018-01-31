<?php

namespace App\Http\Controllers\WX;

use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxAreaController extends Controller
{

    public function __construct(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 403,
                'message' => '请先授权该程序用户信息'
            ];
        }
    }

    public function findArea(Request $request){
        //
        $user_info = User::where("openid",$request->openId)->first();

        if($user_info){
            $arr = [
                'org_id' => $user_info->org_id,
                'pid' => $request->pid
            ];
            $area_list = Area::where($arr)->get();
            $area_arr = [];
            foreach ($area_list as $v){
                $area_arr[] = [
                    'area_id' => $v->id,
                    'name' => $v->name,
                    'org_id' => $v->org_id,
                    'pid' => $v->pid,
                    'area_uuid' => $v->uuid
                ];
            }
            return response()->json($area_arr);
        }else{
            return $message = [
                'code' => 0,
                'message' => '未授权用户，请联系管理员'
            ];
        }
    }

    public function findNextArea(Request $request){
        $user_info = User::where("openid",$request->openId)->first();
        if($user_info){
            $arr = [
                'org_id' => $user_info->org_id,
                'pid' => $request->pid
            ];
            $area_list = Area::where($arr)->get();
            $area_arr = [];
            foreach ($area_list as $v){
                $area_arr[] = [
                    'area_id' => $v->id,
                    'name' => $v->name,
                    'org_id' => $v->org_id,
                    'pid' => $v->pid,
                    'area_uuid' => $v->uuid
                ];
            }
            return response()->json($area_arr);
        }else{
            return $message = [
                'code' => 0,
                'message' => '未授权用户，请联系管理员'
            ];
        }
    }


    //查看此场地下所有资产
    public function findAsset(Request $request){
        $user_info = User::where("openid",$request->openId)->first();
        $term = [
            'area_id' => $request->area_id,
            'org_id' => $user_info->org_id
        ];
        $asset_list = Asset::where($term)->with("category")->get();
        $arr = [];
        foreach ($asset_list as $v){
            $arr[] = [
                'asset_id' => $v->id,
                'asset_name' => $v->name,
                'asset_uuid' => $v->asset_uid,
                'category' => $v->category->name
            ];
        }
        return response()->json($arr);
    }


}
