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
        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get()->toArray();
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
//        $pinyin = new Pinyin();
        //获取公司名称
//        $org_name = Org::find(Auth::user()->org_id)->name;
//        $str = mb_substr($pinyin->abbr($org_name),0,3).mb_substr($pinyin->abbr($request->name),0,3);
//        $ss = AssetCategory::where("org_id",Auth::user()->org_id)->orderBy();
//        dd($ss);
        $arr = [
//            'category_code' => $str,
            'category_code' => date("dHis").rand("1000","9999"),
            'name' => $request->name,
            'org_id' => Auth::user()->org_id,
            'created_at' => date("Y-m-d H:i:s")
        ];
        if($request->pid){
            $arr['pid'] = $request->pid;
            $org_id = Auth::user()->org_id;
            $arr['path'] = AssetCategory::where('org_id',$org_id)->where("id",$request->pid)->value("path");
            $arr['path'] .= $request->pid.",";
        }else{
            $arr['pid'] = 0;
            $arr['path'] = "";
        }
        $info = AssetCategory::insertGetId($arr);
        if($info){
            $arr = [
                'code'=>1,
                'message'=>'添加成功'
            ];
        }else{
            $arr = [
                'code'=>0,
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
        if(Auth::user()->org_id == AssetCategory::where("id",$id)->value("org_id")){
            $info = AssetCategory::where("id",$id)->update($request->except("_token","_method"));
            if($info){
                $arr = [
                    'code'=>1,
                    'message'=>'修改成功'
                ];
            }else{
                $arr = [
                    'code'=>0,
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
        if(Auth::user()->org_id == AssetCategory::where("id",$id)->value("org_id")){
            $list = AssetCategory::where("pid",$id)->first();
            if($list!=null){
                $message = [
                    'code'=>0,
                    'message'=>'此类别下还有子类别'
                ];
            }else{
                //判断此类别下还有资产
                if($info = Asset::where("category_id",$id)->first()){
                    $message = [
                        'code'=>0,
                        'message'=>'此类别下还有资产，不能删除'
                    ];
                }else{
                    $info = AssetCategory::where("id",$id)->delete();
                    if($info){
                        $message = [
                            'code'=>1,
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
                'code'=>1,
                'message' => '还有子类'
            ];
        }else{
            $message = [
                'code'=>0,
                'message' => '没有子类'
            ];
        }
        return response()->json($message);
    }

    /**
     * 导出资产类别  数据
     */
//    public function export(){
//
//        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
//        $cellData = [
//            ['资产类别名称','父类别','所属公司'],
//        ];
//        $arr = [];
//        foreach ($list as $key=>$value){
//            $arr['name'] = $value->name;
//            $arr['path'] = $value->path;
//            $arr['org_id'] = $value->org->name;
//            array_push($cellData,$arr);
//        }
//
//        Excel::create('资产分类_'.date("YmdHis"),function($excel) use ($cellData){
//            $excel->sheet('score', function($sheet) use ($cellData){
//                $sheet->setPageMargin(array(
//                    0.25, 0.30, 0.25, 0.30
//                ));
//                $sheet->setWidth(array(
//                    'A' => 40, 'B' => 40, 'C' => 40
//                ));
//                $sheet->cells('A1:C1', function($row) {
//                    $row->setBackground('#cfcfcf');
//                });
//                $sheet->rows($cellData);
//            });
//        })->export('xls');
//        return ;
//    }


    //下载模板
    public function downloadModel(){
        $cellData = [['资产类别名称(name)','父类(pid)']];
        $cellData2 = [['资产类别名称','类别编号']];
        //类别
        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
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

    public function add_import(){
        return response()->view('asset.asset_category.add_import');
    }

    public function import(Request $request){
        $filePath =  $request->file_path;
        Excel::selectSheets('sheet1')->load($filePath, function($reader) {
            $data = $reader->all();
            $org_id = Auth::user()->org_id;
            foreach ($data as $k=>$v){
                $arr = $v->toArray();
                $arr['category_code'] = date("dHis").rand("1000",'9999');
                if($arr['pid']=='0'){
                    $arr['path'] = '';
                }else{
                    $path = AssetCategory::where("id",$arr['pid'])->value("path");
                    $arr['path'] = $path.$arr['pid'].',';
                }
                $arr['status'] = "1";
                $arr['org_id'] = $org_id;
                AssetCategory::insert($arr);
            }
        });
        $message = [
            'code'=>'1',
            'message'=> '数据导入成功'
        ];
        return response()->json($message);
    }

}
