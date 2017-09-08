<?php

namespace App\Http\Controllers\Repair;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Repair\Process;
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
        $data=Process::where('org_id',Auth::user()->org_id)->get();
        return view('repair.create_repair.index');
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

        $res=['asset_classify_id' => $request->asset_classify_id,
            'asset_id' => $request->asset_id,
            'remarks' => $request->remarks,
            'status' => 1,
            'org_id' => Auth::user()->org_id,
            'user_id' => Auth::user()->id
        ];
        $process_id=Process::insertGetId($res);
        if ($process_id) {
            foreach ($request->images as $v){
               if (!DB::table('file_process')->insert(['file_id'=>$v,'process_id'=>$process_id])){
                   return response()->json([
                       'status' => 0, 'message' => '图片上传失败',
                       'data' => null, 'url' => ''
                   ]);
               }
            }
            return response()->json([
                'status' => 1, 'message' => '报修成功'
            ]);
        }else{
            return response()->json([
                'status' => 0, 'message' => '报修失败',
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
