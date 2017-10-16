<?php

namespace App\Http\Controllers\Asset;

use App\Http\Requests\CategoryRequest;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\User\Org;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Excel;
use Overtrue\Pinyin\Pinyin;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($res = is_permission('asset.category.index')){
            return $res;
        }
        $list = AssetCategory::where("org_id",get_current_login_user_org_id())->get()->toArray();
        foreach ($list as $k=>$v){
            $list[$k]['text'] = $v['name'];
            $list[$k]['nodeId'] = $v['id'];
        }
        $tree = list_to_tree($list, 'id', 'pid', 'nodes', "0");
        return view("asset.asset_category.index",compact("tree"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('asset.category.add')){
            return $res;
        }
        return response()->view("asset.asset_category.add");
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function add($id){
        if(Auth::user()->org_id == AssetCategory::where("id",$id)->value("org_id")){
            $info = AssetCategory::find($id);
            return response()->view("asset.asset_category.add_son",compact("info"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if ($res = is_permission('asset.category.add')){
            return $res;
        }
        $arr = [
            'category_code' => $request->category_code,
            'name' => $request->name,
            'org_id' => get_current_login_user_org_id(),
            'created_at' => date("Y-m-d H:i:s")
        ];
        if($request->pid){
            $arr['pid'] = $request->pid;
            $org_id = get_current_login_user_org_id();
            $arr['path'] = AssetCategory::where('org_id',$org_id)->where("id",$request->pid)->value("path");
            $arr['path'] .= $request->pid.",";
        }else{
            $arr['pid'] = 0;
            $arr['path'] = "";
        }
        $info = AssetCategory::insertGetId($arr);
        if($info){
            $arr = [
                'status'=>1,
                'message'=>'添加成功'
            ];
        }else{
            $arr = [
                'status'=>0,
                'message'=>'添加失败'
            ];
        }
        return response()->json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($res = is_permission('asset.category.index')){
            return $res;
        }
        $info = AssetCategory::find($id);
        return response()->view("asset.asset_category.edit",compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('asset.category.edit')){
            return $res;
        }
        $info = AssetCategory::find($id);
        return response()->view("asset.asset_category.edit",compact('info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if ($res = is_permission('asset.category.edit')){
            return $res;
        }
        if(get_current_login_user_org_id() == AssetCategory::where("id",$id)->value("org_id")){
            $info = AssetCategory::where("id",$id)->update($request->except("_token","_method"));
            if($info){
                $arr = [
                    'status'=>1,
                    'message'=>'修改成功'
                ];
            }else{
                $arr = [
                    'status'=>0,
                    'message'=>'修改失败'
                ];
            }
            return response()->json($arr);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($res = is_permission('asset.category.del')){
            return $res;
        }
        if(get_current_login_user_org_id() == AssetCategory::where("id",$id)->value("org_id")){
            $list = AssetCategory::where("pid",$id)->first();
            if($list!=null){
                $message = [
                    'status'=>0,
                    'message'=>'此类别下还有子类别'
                ];
            }else{
                //判断此类别下还有资产
                if($info = Asset::where("category_id",$id)->first()){
                    $message = [
                        'status'=>0,
                        'message'=>'此类别下还有资产，不能删除'
                    ];
                }else{
                    $info = AssetCategory::where("id",$id)->delete();
                    if($info){
                        $message = [
                            'status'=>1,
                            'message'=>'删除成功'
                        ];
                    }
                }
            }
            return response()->json($message);
        }else{
            return redirect("home");
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function find($id){
        $list = AssetCategory::where("pid",$id)->first();
        if($list){
            $message = [
                'status'=>1,
                'message' => '还有子类'
            ];
        }else{
            $message = [
                'status'=>0,
                'message' => '没有子类'
            ];
        }
        return response()->json($message);
    }

    /**
     * 导出资产类别  数据
     */
    public function export()
    {
        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        $cellData = [
            ['资产类别名称','父类别'],
        ];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['name'] = $value->name;
            //所在位置
            $arr['path'] =  "";
            $str = explode(",",trim($value->path,","));
            foreach ($str as $k=>$v){
                $arr['path'] .= AssetCategory::where("id",$v)->value("name")." / ";
            }
            $arr['path'] = trim($arr['path']," / ");
            array_push($cellData,$arr);
        }

        Excel::create('资产类别_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('资产类别', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet->cells('A1:B1', function($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($cellData);
            });
        })->export('xls');
        return ;
    }


    //下载模板
    public function downloadModel()
    {
        $cellData = [['资产类别名称','父类']];
        $cellData2 = [['资产类别名称','类别编号']];
        //类别
        $list = AssetCategory::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list as $k=>$v){
            $arr = [
                $list[$k]->name,$list[$k]->id
            ];
            array_push($cellData2,$arr);
        }
        Excel::create('资产类别模板', function($excel) use ($cellData,$cellData2){

            // Our first sheet
            $excel->sheet('sheet1', function($sheet1) use ($cellData){
                $sheet1->setPageMargin(array(
                    0.30,0.30
                ));
                $sheet1->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet1->cells('A1:B1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet1->rows($cellData);
            });

            // Our second sheet
            $excel->sheet('资产类别', function($sheet2) use ($cellData2){
                $sheet2->setPageMargin(array(
                    0.30,0.30
                ));
                $sheet2->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet2->cells('A1:B1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet2->rows($cellData2);
            });


        })->export('xls');
    }

    public function add_import()
    {
        return response()->view('asset.asset_category.add_import');
    }

    public function import(Request $request)
    {
        $filePath =  $request->file_path;
        Excel::selectSheets('sheet1')->load($filePath, function($reader) {
            $data = $reader->getsheet(0)->toArray();
            $org_id = get_current_login_user_org_id();
            foreach ($data as $k=>$v){
                if($k==0){
                    continue;
                }
                $arr = [
                    'name' => $v[0],
                    'pid' => $v[1],
                    'category_code' => date("dHis").rand("1000",'9999'),
                    'status' => '1',
                    'org_id' => $org_id
                ];
                if($arr['pid']=='0'){
                    $arr['path'] = '';
                }else{
                    $path = AssetCategory::where("id",$arr['pid'])->value("path");
                    $arr['path'] = $path.$arr['pid'].',';
                }
                AssetCategory::insert($arr);
            }
        });
        $message = [
            'status'=>'1',
            'message'=> '数据导入成功'
        ];
        return response()->json($message);
    }

}
