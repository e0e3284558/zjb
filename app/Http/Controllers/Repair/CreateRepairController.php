<?php

namespace App\Http\Controllers\Repair;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
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
     * @param $list
     * @return mixed
     */
    public function test($list)
    {
        foreach ($list as $key => $value) {
            // var_dump($value);
            $s = $value->path;
            //转换为数组
            $arr = explode(',', $s);
            //获取数组的长度
            $len = count($arr);
            //获取逗号个数
            $dlen = $len - 1;
            //拼接分割符 str_repeat()重复字符串
            $list[$key]->name = str_repeat('|--', $dlen) . $value->name;
        }
        return $list;
    }

    /**
     *
     * 待报修列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Process::where('org_id', Auth::user()->org_id)
            ->where('status', 1)
            ->with('user', 'img', 'asset', 'category', 'serviceWorker')->get();
        return view('repair.create_repair.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $classifies = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->where("org_id", Auth::user()->org_id)->orderBy("paths")->get();
        $classifies = $this->test($classifies);
        return view('repair.create_repair.add', compact('classifies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectAsset($id)
    {
        $arr = [];
        $data = Asset::where('category_id', $id)->get();
        foreach ($data as $v) {
            $arr[] = '<option value=' . $v->id . '>' . $v->name . '</option>';
        }
        if ($arr == []) $arr = '<option value="">当前类别下无资产，请重新选择</option>';
        return $arr;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $res = ['asset_classify_id' => $request->asset_classify_id,
            'asset_id' => $request->asset_id,
            'remarks' => $request->remarks,
            'status' => 1,
            'org_id' => Auth::user()->org_id,
            'user_id' => Auth::user()->id
        ];
        $process_id = Process::insertGetId($res);
        if ($process_id) {
            foreach ($request->images as $v) {
                if (!DB::table('file_process')->insert(['file_id' => $v, 'process_id' => $process_id])) {
                    return response()->json([
                        'status' => 0, 'message' => '图片上传失败',
                        'data' => null, 'url' => ''
                    ]);
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
     */
    public function selectWorker(Request $request)
    {
        $data = [];
        $arr = [];
        //获取当前选中的维修商
        $provider = ServiceProvider::find($request->provider_id);
        //获取当前服务商下面的所有维修工
        $service_worker = $provider->service_worker()->get()->toArray();

        foreach ($service_worker as $v) {
            $a = DB::table('classify_service_worker')->where('service_worker_id', $v['id'])->get();
            foreach ($a as $j){
                if ($j->classify_id==$request->classify_id){
                    $data[]=$v;
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
     */
    public function confirmWorker(Request $request)
    {
        $repair=Process::find($request['id']);
        $repair->service_worker_id = $request['service_worker_id'];
        $repair->asset_classify_id = $request['asset_classify_id'];
        $repair->service_provider_id = $request['service_provider_id'];
        $repair->status =20;
        if ($repair->save()){
            return response()->json([
                'status' => 1, 'message' => '分派成功'
            ]);
        }else{
            return response()->json([
                'status' => 0, 'message' => '分派失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
