<?php

namespace App\Http\Controllers\Consumables;

use App\Models\Consumables\Archiving;
use App\Models\Consumables\Goods;
use App\Models\Consumables\Sort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Excel;

class ArchivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Sort::get()->toJson();
        $goods=Goods::get();
        return view('consumables.archiving.index',compact('data','goods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sort=Sort::get();
        return response()->view('consumables.archiving.add',compact('sort'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sort=Sort::get();
        return response()->view('consumables.archiving.add',compact('id','sort'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * 耗材导出
     */
    public function export()
    {
        $list = Goods::where("org_id",get_current_login_user_org_id())->get();
        $cellData = [['物品编码','物品名称','所属分类','物品条形码', '规格型号','单位',
            '商标','安全库存上限', '安全库存下限','是否禁用','备注','操作员']];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['coding'] = $value->coding;
            $arr['name'] = $value->name;
            $arr['classify'] = Sort::where("id",$value->classify_id)->value("name");
            $arr['barcode'] = $value->barcode;
            $arr['norm'] = $value->norm;
            $arr['unit'] = $value->unit;
            $arr['trademark'] = $value->trademark;
            $arr['inventory_cap'] = $value->inventory_cap;
            $arr['inventory_lower'] = $value->inventory_lower;
            $arr['disable'] = $value->disable?'禁用':'启用';
            $arr['comment'] = $value->comment;
            $arr['user_id'] = get_current_login_user_info();

            array_push($cellData,$arr);
        }
        Excel::create('耗材管理_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('耗材管理', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40, 'D' => 40, 'E' => 40, 'F' => 40,
                    'G' => 40, 'H' => 40, 'I' => 40, 'J' => 40, 'K' => 40, 'L' => 40
                ));
                $sheet->cells('A1:L1', function($row) {
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
        $cellData1 = [['物品编码','物品名称','所属分类','物品条形码', '规格型号','单位',
            '商标','安全库存上限', '安全库存下限','备注']];
        //耗材类别
        $cellData2 = [['耗材类别名称']];
        $list2 = Sort::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list2 as $k=>$v){
            $arr = [
                $list2[$k]->id,$list2[$k]->name
            ];
            array_push($cellData2,$arr);
        }
//        //所在场地
//        $cellData3 = [['场地名称','场地编号']];
//        $list3 = Area::where("org_id",get_current_login_user_org_id())->get();
//        foreach ($list3 as $k=>$v){
//            $arr = [
//                $list3[$k]->name,$list3[$k]->id
//            ];
//            array_push($cellData3,$arr);
//        }
//        //所属部门
//        $cellData4 = [['部门名称','部门编号']];
//        $list4 = Department::where("org_id",get_current_login_user_org_id())->get();
//        foreach ($list4 as $k=>$v){
//            $arr = [
//                $list4[$k]->name,$list4[$k]->id
//            ];
//            array_push($cellData4,$arr);
//        }
//        //供应商
//        $cellData5 = [['供应商名称','供应商编号']];
//        $list5 = Supplier::where("org_id",get_current_login_user_org_id())->get();
//        foreach ($list5 as $k=>$v){
//            $arr = [
//                $list5[$k]->name,$list5[$k]->id
//            ];
//            array_push($cellData5,$arr);
//        }
        Excel::create('耗材录入模板', function($excel) use ($cellData1,$cellData2){

            // Our first sheet
            $excel->sheet('耗材录入', function($sheet1) use ($cellData1){
                $sheet1->setPageMargin(array(
                    0.30,0.30,0.30,0.30
                ));
                $sheet1->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40, 'D' => 40, 'E' => 40,
                    'F' => 40, 'G' => 40, 'H' => 40, 'I' => 40, 'J' => 40
                ));
                $sheet1->cells('A1:J1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet1->rows($cellData1);
            });

            //耗材类别
            $excel->sheet('耗材类别', function($sheet2) use ($cellData2){
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
     * 加载导入视图
     */
    public function add_import(){
        return response()->view('consumables.archiving.add_import');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 导入耗材
     */
    public function import(Request $request){
        $filePath =  $request->file_path;
        Excel::selectSheets('耗材录入')->load($filePath, function($reader) {
            $data = $reader->getsheet(0)->toArray();
            $org_id = get_current_login_user_org_id();
            foreach ($data as $k=>$v){
                if($k==0){
                    continue;
                }
                $arr = [
                    'coding' => $v[0],
                    'name' => $v[1],
                    'classify_id' => $v[2],
                    'barcode' => $v[3],
                    'norm' => $v[4],
                    'unit' => $v[5],
                    'trademark' => $v[6],
                    'inventory_cap' => $v[7],
                    'inventory_lower' => $v[8],
                    'disable' => 0,
                    'comment' => $v[9],
                    'org_id' => $org_id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                Goods::insert($arr);
            }
        });
        $message = [
            'status'=>'1',
            'message'=> '耗材数据导入成功'
        ];
        return response()->json($message);
    }


}
