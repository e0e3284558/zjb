<?php

namespace App\Http\Controllers\WX;

use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\File\File;
use App\Models\Repair\Process;
use App\Models\Repair\ServiceWorker;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WxRepairController extends Controller
{
    //添加一个维修单
    public function add(Request $request)
    {
        // 判断是openId是否获取到
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        // 用户id赋值
        $user_id = User::where("openId", $request->openId)->value("id");
        // 获取资产id
        $assetInfo = Asset::find($request->asset_id);
        $arr = [
            'org_id' => $assetInfo->org_id,
            'user_id' => $user_id,
            'asset_id' => $request->asset_id,
            'asset_classify_id' => $assetInfo->category_id,
            'remarks' => $request->remarks,
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ];
        // 新增一条报修并且获取报修单id
        $process_id = Process::insertGetId($arr);
        // 判断是否插入成功
        if ($process_id) {
            //获取上传图片id
            if ($request->img_id) {
                // 根据逗号拆分图片id
                foreach (explode(",", trim($request->img_id, ",")) as $v) {
                    // 判断图片是否上传成功
                    if (!DB::table('file_process')->insert(['file_id' => $v, 'process_id' => $process_id])) {
                        return response()->json([
                            'status' => 0, 'message' => '图片上传失败',
                            'data' => null, 'url' => ''
                        ]);
                    }
                }
            }
            return $message = [
                'code' => 1,
                'message' => '报修成功'
            ];
        } else {
            return $message = [
                'code' => 0,
                'message' => '报修失败'
            ];
        }
    }

    public function repairList(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        $user_id = User::where("openId", $request->openId)->value("id");
        $status = $request->status;
        switch ($status) {
            //返回待服务的维修单
            case 1:
                $list = Process::where('user_id', $user_id)->whereIn('status', [1, 2, 3, 4])->OrderBy('id', 'desc')->paginate(10);
                break;
            //返回待评价的维修单
            case 10:
                $list = Process::where('user_id', $user_id)->where('status', 10)->OrderBy('id', 'desc')->paginate(10);
                break;
            //返回已完成的维修单
            case 20:
                $list = Process::where('user_id', $user_id)->where('status', 10)->whereNull('appraisal')->OrderBy('id', 'desc')->paginate(10);
                break;
            //返回所有的维修单
            case 30:
                $list = Process::where('user_id', $user_id)->OrderBy('id', 'desc')->paginate(10);
                break;
        }
        $arr = [];
        if (!$list->isEmpty()) {
            foreach ($list as $v) {
                $array = [];
                //资产名称
                $asset = Asset::find($v->asset_id);
                //资产名称
                $array['name'] = $asset->name;
                //所在场地
                $str = '';
                $path = Area::where("id", $asset->area_id)->value("path") . $asset->area_id;
                $path = explode(",", ltrim($path, "0,"));
                foreach ($path as $value) {
                    $str .= Area::where("id", $value)->value("name") . "/";
                }
                $str = trim($str, "/");
                $array['repair_id'] = $v->id;
                $array['path'] = $str;
                $array['field'] = $asset->name;
                //图片
                $img_list = DB::table("file_process")->where("process_id", $v->id)->get();
                if ($img_list) {
                    foreach ($img_list as $value) {
                        $array['img_url'][] = File::where("id", $value->file_id)->value("url");
                    }
                }
                $array['complain'] = $v->complain;
                $arr[] = $array;

            }
        } else {
            $arr['code'] = 0;
        }
        return response()->json($arr);
    }

    //提交评价信息
    public function evaluate(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        $arr = [
            'score' => $request->score,
            'appraisal' => $request->appraisal,
            'status' => $request->status
        ];
        $info = Process::where("id", $request->repair_id)->update($arr);
        return $info;
    }


//    待服务
    public function service(Request $request)
    {
        $user_id = User::where("openId", $request->openId)->value("id");
        $arr = [
            'user_id' => $user_id,
            'status' => 1
        ];
        $list = Process::where($arr)->OrderBy('id', 'desc')->paginate(10);
        $arr = [];
        foreach ($list as $v) {
            $array = [];
            //资产名称
            $asset = Asset::find($v->asset_id);
            //资产名称
            $array['name'] = $asset->name;
            //所在场地
            $str = '';
            $path = Area::where("id", $asset->area_id)->value("path") . $asset->area_id;
            $path = explode(",", ltrim($path, "0,"));
            foreach ($path as $value) {
                $str .= Area::where("id", $value)->value("name") . "/";
            }
            $str = trim($str, "/");

            $array['repair_id'] = $v->id;
            $array['path'] = $str;
            $array['field'] = $asset->name;
            $array['img_url'] = File::where("id", $v->img_id)->value("url");
            $array['complain'] = $v->complain;
            $arr[] = $array;
        }
        return $arr;
    }

    //服务列表
    public function ServiceList(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        //维修人员用户信息
        $service_worker_id = ServiceWorker::where("openId", $request->openId)->value("id");
        //获取订单状态值及维修工id
        $status = $request->status;
        switch ($status) {
            // 获取已被分配待服务的工单信息
            case 2:
                $repair_list = Process::where('service_worker_id', $service_worker_id)
                    ->where('status', 2)->orWhere('status', 3)
                    ->OrderBy('id', 'desc')->get();
                break;
            // 获取已接单的工单信息
            case 4:
                $repair_list = Process::where('service_worker_id', $service_worker_id)
                    ->where('status', 4)
                    ->OrderBy('id', 'desc')->get();
                break;
            // 获取
            case 10:
                $repair_list=Process::where('service_worker_id', $service_worker_id)
                    ->where('status', 10)->OrderBy('id', 'desc')->get();
                break;
            case 100:
                $repair_list = Process::where('service_worker_id', $service_worker_id)
                    ->where('status', 10)->OrderBy('id', 'desc')->get();
                break;
        }

        $arr = [];
        if ($repair_list->isEmpty()){
            $arr['code']=0;
            return response()->json($arr);
        }
        foreach ($repair_list as $v) {
            $array = [];
            //资产名称
            $asset = Asset::find($v->asset_id);
            //资产名称
            $array['name'] = $asset->name;
            //所在场地
            $str = '';
            $path = Area::where("id", $asset->area_id)->value("path") . $asset->area_id;
            $path = explode(",", ltrim($path, "0,"));
            foreach ($path as $value) {
                $str .= Area::where("id", $value)->value("name") . "/";
            }

            $img_url = [];
            foreach (explode(",", trim($v->img_id, ",")) as $value) {
                $img_url[] = File::where("id", $value)->value("url");
            }

            $str = trim($str, "/");

            $array['repair_id'] = $v->id;
            $array['path'] = $str;
            $array['field'] = $asset->name;
            //图片
            $img_list = DB::table("file_process")->where("process_id", $v->id)->get();
            if ($img_list) {
                foreach ($img_list as $value) {
                    $array['img_url'][] = File::where("id", $value->file_id)->value("url");
                }
            }
            $array['asset_id'] = $v->asset_id;
            $arr[] = $array;
        }
        return response()->json($arr);
    }


    //维修人员确认接单
    public function confirmRepair(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 2,
                'message' => '请先授权该程序用户信息'
            ];
        }
        //获取维修人员的id
        $service_worker_id = ServiceWorker::where("openId", $request->openId)->value("id");
        $repair_info = Process::where("id", $request->repair_id)->first();

        $arr = [
            'status' =>4
        ];
        if (Process::where('id',$request->repair_id)->update($arr)){
            $data=[
                'code'=>1,
                'message'=>'接单成功，请尽快上门服务'
            ];
        }else{
            $data=[
                'code'=>0,
                'message'=>'接单失败，请稍后重试'
            ];
        }
        return response()->json($data);


    }



    /**
     * 维修人员拒单
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function refuseRepair(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }

        //获取维修人员的id
        $service_worker_id = ServiceWorker::where("openId", $request->openId)->value("id");
        $repair_info = Process::where("id", $request->repair_id)->first();
        $order_reason = $request->order_reason;

        $arr = [
            'status' => 1,
            'refuse_repair' => $order_reason,
            'service_worker_id'=>null
        ];
        if (Process::where('id',$request->repair_id)->update($arr)){
            $data=[
                'code'=>1,
                'message'=>'拒单成功，已通知管理员重新分配工单'
            ];
        }else{
            $data=[
                'code'=>0,
                'message'=>'拒单失败，请稍后重试'
            ];
        }
        return response()->json($data);
    }

    //维修人员填写维修结果
    public function writeResult(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        $arr = [
            'repair_result' => $request->repair_result,
            'suggest' => $request->suggest,
            'status' => $request->status,
            'service_img' => $request->imgId
        ];

        $info = Process::where("id", $request->repair_id)->update($arr);

        if ($info) {
            return $message = [
                'status_code' => '1',
                'message' => '维修结果录入成功'
            ];
        }
    }

    //用户查看已完成工单全部详情
    public function repairAllInfo(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        $repair_info = Process::where("id", $request->repair_id)->first();
        //资产名称
        $asset_info = Asset::find($repair_info->asset_id);
        //所在场地
        $str = '';
        $path = Area::where("id", $asset_info->area_id)->value("path") . $asset_info->area_id;
        $path = explode(",", ltrim($path, "0,"));
        foreach ($path as $value) {
            $str .= Area::where("id", $value)->value("name") . "/";
        }
        $str = trim($str, "/");
        //用户拍摄图片
        $img_url = [];
        $list = Process::where("id", $repair_info->id)->with("img")->first()->img;
        if ($list) {
            foreach ($list as $v) {
                $img_url[] = File::where("id", $v->id)->value("url");
            }
        } else {
            $img_url = null;
        }
        //维修人员上传的图片
        $service_img_url = [];
        $list1 = Process::where("id", $repair_info->id)->with("worker_img")->first()->worker_img;
        if ($list1) {
            foreach ($list1 as $v) {
                $service_img_url[] = File::where("id", $v->id)->value("url");
            }
        } else {
            $service_img_url = null;
        }
        $arr = [
            'asset_uuid' => $asset_info->asset_uuid,
            'category' => AssetCategory::where("id", $asset_info->category_id)->value("name"),
            'asset_name' => $asset_info->name,
            'field_path' => $str,
            'remarks' => $repair_info->remarks,
            'img_url' => $img_url,
            'stars_key' => $repair_info->score,
            'appraisal' => $repair_info->appraisal,
            'complain' => $repair_info->complain,
            'service_status' => $repair_info->order_status,
            'service_worker' => ServiceWorker::where("id", $repair_info->service_worker_id)->value("name"),
            'suggest' => $repair_info->suggest,
            'service_img_url' => $service_img_url
        ];
        //工单状态
        switch ($repair_info->status) {
            case 0:
                $repair_status = '报废';
                break;
            case 1:
                $repair_status = '已报修工单';
                break;
            case 2 || 3:
                $repair_status = '已分派维修人员工单';
                break;
            case 4:
                $repair_status = '维修人员已接单工单';
                break;
            case 10:
                if ($repair_info->appraisal->isEmpty()) {
                    $repair_status = '待评价工单';
                } else {
                    $repair_status = '已完成工单';
                }
                break;
        }
        $arr['repair_status'] = $repair_status;
        return response()->json($arr);

    }


    //用户投诉
    public function complain(Request $request)
    {
        if (!$request->openId) {
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        $user_id = User::where("openId", $request->openId)->value("id");
        $repair_info = Process::where("id", $request->repair_id)->first();
        if ($user_id == $repair_info->user_id) {
            $info = Process::where("id", $request->repair_id)->update(['complain' => $request->complain]);
            if ($info) {
                return $message = [
                    'code' => '1',
                    'message' => '投诉成功'
                ];
            }
        }
    }
}
