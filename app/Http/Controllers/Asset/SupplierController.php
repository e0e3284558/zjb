<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('supplier.index')){
            return $res;
        }
        if ($request->ajax()) {
            $org_id = Auth::user()->org_id;
            $map = [
                ['org_id', '=', $org_id]
            ];
            if ($request->search) {
                $map[] = ['name', 'like', '%' . $request->search . '%'];
            }

            $data = Supplier::with('category', 'org')->where($map)->orderBy("id", "desc")->paginate(request('limit'));
            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.supplier.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('supplier.add')){
            return $res;
        }
        $category_list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        return response()->view("asset.supplier.add",compact("category_list"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($res = is_permission('supplier.add')){
            return $res;
        }
        $supplier = new Supplier;
        $supplier->name=$request->name;
        $supplier->remarks = $request->remarks;
        $supplier->org_id = get_current_login_user_org_info()->id;
        $supplier->created_at = date("Y-m-d H:i:s");

        if($supplier->save()){
            if($supplier->category()->sync($request->category_id)){
                return response()->json([
                    'status' => '1',
                    'message' => '添加成功'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($res = is_permission('supplier.index')){
            return $res;
        }
        $info = Supplier::with("category","org")->find($id);
        return view("asset.supplier.show",compact("info"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('supplier.edit')){
            return $res;
        }
        if(get_current_login_user_org_id() == Supplier::where("id",$id)->value("org_id")) {
            $info = Supplier::find($id);
            $categorys = DB::table('asset_category_supplier')->where("supplier_id",$id)->get();
            $category_arr = [];
            foreach ($categorys as $k=>$v){
                $category_arr[] = $v->asset_category_id;
            }
            $list = AssetCategory::where("org_id",get_current_login_user_org_id())->get();
            return response()->view("asset.supplier.edit", compact("info","list","category_arr"));
        }else{
            return redirect("home");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($res = is_permission('supplier.edit')){
            return $res;
        }


        $supplier = Supplier::find($id);
        $supplier->name=$request->name;
        $supplier->remarks = $request->remarks;
        $supplier->org_id = get_current_login_user_org_id();
        $supplier->created_at = date("Y-m-d H:i:s");

        if($supplier->save()){
            if($supplier->category()->sync($request->category_id)){
                return response()->json([
                    'status' => '1',
                    'message' => '添加成功'
                ]);
            }
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
        if ($res = is_permission('supplier.del')){
            return $res;
        }
        $arr = explode(",",$id);
        $user_org_id = get_current_login_user_org_id();
        if($user_org_id == Supplier::where("id",$arr[0])->value("org_id")) {
            foreach ($arr as $k=>$v){
                $info = Asset::where("org_id",$user_org_id)->where("supplier_id",$v)->first();
                if($info){
                    $message = [
                        'status' => 0,
                        'message' => '删除失败'
                    ];
                    return response()->json($message);
                }
            }

            foreach ($arr as $k=>$v){
                $info = Supplier::where("id",$v)->where("org_id",get_current_login_user_org_id())->delete();
            }
            $message = [
                'status' => 1,
                'message' => '删除成功'
            ];
            return response()->json($message);
        }else{
            return redirect("home");
        }
    }

    /**
     * 供应商管理  数据导出
     */
    public function export(){

        $list = Supplier::where("org_id",get_current_login_user_org_id())->get();
        $cellData = [
            ['供应商名称','供应商类别','备注'],
        ];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['name'] = $value->name;
            $arr['category'] = AssetCategory::where("id",$value->category_id)->value("name");
            $arr['remarks'] = $value->remarks;
            array_push($cellData,$arr);
        }
        Excel::create('供应商列表_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('供应商', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40
                ));
                $sheet->cells('A1:C1', function($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($cellData);
            });
        })->export('xlsx');
        return ;
    }

    /**
     * 下载模板
     */
    public function downloadModel(){
        $cellData = [['供应商名称','供应商类别','备注']];
        $cellData2 = [['类别名称','类别编号']];
        //类别
        $list = AssetCategory::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list as $k=>$v){
            $arr = [
                $list[$k]->name,$list[$k]->id
            ];
            array_push($cellData2,$arr);
        }
        Excel::create('供应商模板', function($excel) use ($cellData,$cellData2){

            // Our first sheet
            $excel->sheet('sheet1', function($sheet1) use ($cellData){
                $sheet1->setPageMargin(array(
                    0.30,0.30,0.30
                ));
                $sheet1->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40
                ));
                $sheet1->cells('A1:C1', function($row) {
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

    /**
     * @return \Illuminate\Http\Response
     */
    public function add_import(){
        return response()->view('asset.supplier.add_import');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request){
        $filePath =  $request->file_path;
        Excel::selectSheets('sheet1')->load($filePath, function($reader) {
            $data = $reader->getsheet(0)->toArray();
            $org_id = get_current_login_user_org_id();
            foreach ($data as $k=>$v){
                $arr = [
                    'name' => $v[0],
                    'category_id' => $v[1],
                    'remarks' => $v[2],
                    'org_id' => $org_id
                ];
                Supplier::insert($arr);
            }
        });
        $message = [
            'status'=>'1',
            'message'=> '数据导入成功'
        ];
        return response()->json($message);
    }

}
