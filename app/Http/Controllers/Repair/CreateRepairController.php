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
     * 待报修列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取等待维修的报修
        $data1 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '1')->orWhere('status', '4')->orWhere('status','7')->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        //获取正在维修中的报修
        $data2 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '2')
            ->orWhere('status', '20')
            ->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        //获取已完成的报修
        $data3 = Process::where('org_id', Auth::user()->org_id)
            ->where('status', '6')
            ->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();
        //当前公司下的全部的报修
        $data4 = Process::where('org_id', Auth::user()->org_id)->latest()
            ->with('user', 'img', 'asset', 'category', 'otherAsset', 'serviceWorker')->get();

        return view('repair.create_repair.index', compact('data1', 'data2', 'data3','data4'));
    }

    /**
     * Show the form for creating a new resource.
     * 我要报修，创建报修
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $area = Area::where('org_id', Auth::user()->org_id)->where('pid', 0)->get();
        $classify = Classify::where('org_id', Auth::user()->org_id)->get();
        $other = OtherAsset::where('org_id', Auth::user()->org_id)->get();
        return view('repair.create_repair.add', compact('area', 'classify', 'other'));
    }

    /**
     * Show the form for creating a new resource.
     * 根据条件选择资产 AJAX
     * @return \Illuminate\Http\Response
     */
    public function selectAsset($id)
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
    public function store(CreateRepairRequest $request)
    {
        //判断场地信息是否符合规范，并处理场地信息
        if ($request->area_id !== null) {
            $area_id = $request->area_id;
            $area_id = end($area_id);
            if ($area_id == 0) {
                $area_id = $request->area_id[count($request->area_id) - 2];
            }
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

    /**
     * 分配维修工
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function assignWorker($id)
    {
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
        $classify = Classify::where('org_id', Auth::user()->org_id)->OrderBy('sorting', 'desc')->get();
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
    public function selectWorker(CreateRepairRequest $request)
    {
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
     * 选中维修工并更改维修状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmWorker(CreateRepairRequest $request)
    {
        $repair = Process::find($request['id']);
        $repair->service_worker_id = $request['service_worker_id'];
        $repair->service_provider_id = $request['service_provider_id'];
        $repair->status = 20;
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
    public function changeStatus($id)
    {
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
        $classify = Classify::where('org_id', Auth::user()->org_id)->OrderBy('sorting', 'desc')->get();
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
    public function success($id)
    {
        $data=Process::find($id);
        return response()->view('repair.create_repair.success',compact('data'));
    }

    /**
     * 完成报修进行记录
     * @param $id
     */
    public function successStore(Request $request)
    {
        $process=Process::find($request->id);
        $process->status=$request->status;
        $process->result=$request->result;
        if ($process->save()){
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
     * 将该条记录的状态值改为0，不可再修，报废处理
     * @param $id
     */
    public function del($id)
    {
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

    public function reason($id){
        $info = Process::find($id);
        return response()->view("repair.create_repair.reason",compact('info'));
    }
}
