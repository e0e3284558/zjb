<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\CreateRepairRequest;
use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\OtherAsset;
use App\Models\Repair\Classify;
use App\Models\Repair\Process;
use App\Models\Repair\ServiceProvider;
use App\Models\Repair\ServiceWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateRepairController extends Controller
{

    /**
     *
     * 待维修列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($res = is_permission('create.repair.index')) {
            return $res;
        }
        $classify = get_department_classify();
        $asset_category = get_department_asset_category();
        $list1 = [];
        $list2 = [];
        $list3 = [];
        $list4 = [];
        $list5 = [];
        //获取等待维修的报修
        $data1 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '1')->orWhere('status', '4')->orWhere('status', '7')->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker', 'classify')->get();
        if (!get_current_login_user_info(true)->is_org_admin) {
            foreach ($data1 as $v1) {
                if ($v1->classify) {
                    if (in_array($v1->classify->id, $classify)) {
                        $list1[] = $v1;
                    }
                } else {
                    if (in_array($v1->category->id, $asset_category)) {
                        $list1[] = $v1;
                    }
                }
            }
            $data1 = $list1;
        }
        //获取正在维修中的报修
        $data2 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '3')
            ->orWhere('status', '2')
            ->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        if (!get_current_login_user_info(true)->is_org_admin) {
            foreach ($data2 as $v2) {
                if ($v2->classify) {
                    if (in_array($v2->classify->id, $classify)) {
                        $list2[] = $v2;
                    }
                } else {
                    if (in_array($v2->category->id, $asset_category)) {
                        $list2[] = $v2;
                    }
                }
            }
            $data2 = $list2;
        }

        //获取已完成的报修
        $data3 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '6')
            ->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        if (!get_current_login_user_info(true)->is_org_admin) {
            foreach ($data3 as $v3) {
                if ($v3->classify) {
                    if (in_array($v3->classify->id, $classify)) {
                        $list3[] = $v3;
                    }
                } else {
                    if (in_array($v3->category->id, $asset_category)) {
                        $list3[] = $v3;
                    }
                }
            }
            $data3 = $list3;
        }

        //待评价
        $data4 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '5')
            ->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        if (!get_current_login_user_info(true)->is_org_admin) {
            foreach ($data4 as $v4) {
                if ($v4->classify) {
                    if (in_array($v4->classify->id, $classify)) {
                        $list4[] = $v4;
                    }
                } else {
                    if (in_array($v4->category->id, $asset_category)) {
                        $list4[] = $v4;
                    }
                }
            }
            $data4 = $list4;
        }


        //当前公司下的全部的报修
        $data5 = Process::where('org_id', Auth::user()->org_id)->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        if (!get_current_login_user_info(true)->is_org_admin) {
            foreach ($data5 as $v5) {
                if ($v5->classify) {
                    if (in_array($v5->classify->id, $classify)) {
                        $list5[] = $v5;
                    }
                } else {
                    if (in_array($v5->category->id, $asset_category)) {
                        $list5[] = $v5;
                    }
                }
            }
            $data5 = $list5;
        }
        return view('repair.create_repair.index', compact('data1', 'data2', 'data3', 'data4', 'data5'));
    }

    /**
     * Show the form for creating a new resource.
     * 我要报修，创建报修
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        if ($res = is_permission('create.repair.add')) {
            return $res;
        }
        $area = Area::where('org_id', Auth::user()->org_id)->where('pid', 0)->get();
        $classify = Classify::where('org_id', Auth::user()->org_id)
            ->where('enabled', 1)->get();
        $other = OtherAsset::where('org_id', Auth::user()->org_id)->get();
        return view('repair.create_repair.add', compact('area', 'classify', 'other'));
    }

    /**
     * Show the form for creating a new resource.
     * 根据条件选择资产 AJAX
     * @return \Illuminate\Http\Response
     */
    public
    function selectAsset($id)
    {
        $arr = [];
        $data['area'] = '';
        if ($id != 0) {
            $area = Area::find($id);
            $asset = Asset::where('area_id', $area->id)->get();
            foreach ($asset as $v) {
                $arr[] = '<option value=' . $v->id . '>' . $v->name . '</option>';
            }
            $data['area'] = Area::where("pid", $id)->get();
        }
        if ($arr == []) $arr = '<option value="">当前下无资产，请重新选择</option>';
        $data['asset'] = $arr;
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(CreateRepairRequest $request)
    {
        if ($res = is_permission('create.repair.add')) {
            return $res;
        }
        //判断场地信息是否符合规范，并处理场地信息
        if ($request->area_id !== null) {
            $area_id = $request->area_id;
            $area_id = end($area_id);
            if ($area_id == 0) {
                $area_id = $request->area_id[count($request->area_id) - 2];
            }
        } else {
            return response()->json([
                'status' => 0, 'message' => '请选择场地位置',
                'data' => null, 'url' => ''
            ]);
        }
        $category_id = null;
        if ($request->other == 0) {
            $category_id = Asset::find($request->asset_id)->category_id;
        }
        $res = [
            'asset_classify_id' => $category_id,
            'classify_id' => $request->classify_id ? $request->classify_id : null,
            'asset_id' => $request->asset_id ? $request->asset_id : null,
            'area_id' => $area_id,
            'remarks' => $request->remarks ? $request->remarks : null,
            'other' => $request->other,
            'status' => 1,
            'org_id' => Auth::user()->org_id,
            'user_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $process_id = Process::insertGetId($res);
        if ($process_id) {
            if ($request->images) {
                foreach ($request->images as $v) {
                    if (!DB::table('file_process')->insert(['file_id' => $v, 'process_id' => $process_id])) {
                        return response()->json([
                            'status' => 0, 'message' => '图片上传失败',
                            'data' => null, 'url' => ''
                        ]);
                    }
                }
            }
            return response()->json([
                'status' => 1, 'message' => '报修成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '报修失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    public
    function edit($str)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        //获取当前登录公司下的所有服务商
        $serviceProvider = ServiceProvider::with('org')->get()->toArray();
        foreach ($serviceProvider as $a) {
            if (($a['org'])) {
                if ($a['org'][0]['id'] == Auth::user()->org_id) {
                    $data[] = $a;
                }
            }
        }
        $serviceProvider = $data;
        //获取当前登录公司下的所有分类
        $classify = Classify::where('org_id', Auth::user()->org_id)
            ->where('enabled', 1)
            ->OrderBy('sorting', 'desc')
            ->get();
        //循环输出已获取分类的所有维修工
        foreach ($classify as $v) {
            $serviceWorker[] = $v->serviceWorker()->get();
        }
        return response()->view("repair.create_repair.batch_assign", compact('classify', 'serviceWorker', 'serviceProvider', 'str'));
    }

    public
    function update(Request $request)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $arr = explode(',', $request->str);
        foreach ($arr as $v) {
            $list = [
                'service_worker_id' => $request->service_worker_id,
                'service_provider_id' => $request->service_provider_id,
                'status' => 2
            ];
            $info = Process::where("id", $v)->update($list);
        }
        return response()->json([
            'status' => 1, 'message' => '分派成功'
        ]);
    }

    /**
     * 分配维修工
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public
    function assignWorker($id)
    {
        if ($res = is_permission('create.repair.add')) {
            return $res;
        }
        $process = Process::where('id', $id)
            ->with('user', 'img', 'asset', 'category', 'serviceWorker')->first();
        //获取当前登录公司下的所有服务商
        $serviceProvider = ServiceProvider::with('org')->get()->toArray();
        foreach ($serviceProvider as $a) {
            if (($a['org'])) {
                if ($a['org'][0]['id'] == Auth::user()->org_id) {
                    $data[] = $a;
                }
            }
        }
        $serviceProvider = $data;
        //获取当前登录公司下的所有分类
        $classify = Classify::where('org_id', Auth::user()->org_id)
            ->where('enabled', 1)
            ->OrderBy('sorting', 'desc')
            ->get();
        //循环输出已获取分类的所有维修工
        foreach ($classify as $v) {
            $serviceWorker[] = $v->serviceWorker()->get();
        }
        return response()->view(
            'repair.create_repair.assign',
            compact('process', 'classify', 'serviceWorker', 'serviceProvider')
        );
    }


    /**
     * 根据条件选择维修工
     * @param Request $request
     * @return array|string
     */
    public
    function selectWorker(CreateRepairRequest $request)
    {
        if ($res = is_permission('create.repair.add')) {
            return $res;
        }
        $data = [];
        $arr = [];
        //获取当前选中的维修商
        $provider = ServiceProvider::find($request->provider_id);
        //获取当前服务商下面的所有维修工
        $service_worker = $provider->service_worker()->get()->toArray();

        foreach ($service_worker as $v) {
            $a = DB::table('classify_service_worker')->where('service_worker_id', $v['id'])->get();
            foreach ($a as $j) {
                if ($j->classify_id == $request->classify_id) {
                    $data[] = $v;
                }
            }
        }
        foreach ($data as $v) {
            $arr[] = '<option value=' . $v['id'] . '>' . $v['name'] . '</option>';
        }
        if ($arr == []) $arr = '<option value="">当前服务商或类别下无维修工，请重新选择</option>';
        return $arr;

    }

    /**
     * 保存  选中维修工并更改维修状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function confirmWorker(CreateRepairRequest $request)
    {
        if ($res = is_permission('create.repair.add')) {
            return $res;
        }
        $repair = Process::find($request->id);
        $repair->classify_id = $request->classify_id;
        $repair->service_worker_id = $request->service_worker_id;
        $repair->service_provider_id = $request->service_provider_id;
        $repair->status = 2;
        if ($repair->save()) {
            return response()->json([
                'status' => 1, 'message' => '分派成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '分派失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * 管理员更改状态
     * @param $id
     */
    public
    function changeStatus($id)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $process = Process::where('id', $id)
            ->with('user', 'img', 'asset', 'category', 'serviceWorker')->first();
        //获取当前登录公司下的所有服务商
        $serviceProvider = ServiceProvider::with('org')->get()->toArray();
        foreach ($serviceProvider as $a) {
            if (($a['org'])) {
                if ($a['org'][0]['id'] == Auth::user()->org_id) {
                    $data[] = $a;
                }
            }
        }
        $serviceProvider = $data;
        //获取当前登录公司下的所有分类
        $classify = Classify::where('org_id', Auth::user()->org_id)
            ->where('enabled', 1)
            ->OrderBy('sorting', 'desc')
            ->get();
        //循环输出已获取分类的所有维修工
        foreach ($classify as $v) {
            $serviceWorker[] = $v->serviceWorker()->get();
        }
        return response()->view(
            'repair.create_repair.assign',
            compact('process', 'classify', 'serviceWorker', 'serviceProvider')
        );
    }

    /**
     * 更改维修完成的状态
     * @param $id
     */
    public
    function success($id)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $data = Process::find($id);
        return response()->view('repair.create_repair.success', compact('data'));
    }

    /**
     * 完成报修进行记录
     * @param $id
     */
    public
    function successStore(Request $request)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $process = Process::find($request->id);
        $process->status = $request->status;
        $process->result = $request->result;
        if ($process->save()) {
            return response()->json([
                'status' => 1, 'message' => '维修完成，等待评价'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '保存失败，请稍后重试',
                'data' => null, 'url' => ''
            ]);
        }
    }


    /**
     * @param $str
     * @return \Illuminate\Http\Response
     * 批量完成维修
     */
    public
    function batchSuccess($str)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        return response()->view('repair.create_repair.batch_success', compact('str'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 完成报修
     */
    public
    function batchSuccessStore(Request $request)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $arr = explode(',', $request->str);
        foreach ($arr as $v) {
            $list = [
                'status' => $request->status,
                'result' => $request->result
            ];
            Process::where("id", $v)->update($list);
        }
        return response()->json([
            'status' => 1, 'message' => '维修完成，等待评价'
        ]);
    }


    /**
     * 将该条记录的状态值改为0，不可再修，报废处理
     * @param $id
     */
    public
    function del($id)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $process = Process::find($id);
        $process->status = 0;
        if ($process->save()) {
            return response()->json([
                'code' => 1, 'message' => '操作完成'
            ]);
        } else {
            return response()->json([
                'code' => 0, 'message' => '操作失败'
            ]);
        }
    }

    /**
     * 填写原因
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public
    function reason($id)
    {
        if ($res = is_permission('create.repair.edit')) {
            return $res;
        }
        $info = Process::find($id);
        return response()->view("repair.create_repair.reason", compact('info'));
    }
}
