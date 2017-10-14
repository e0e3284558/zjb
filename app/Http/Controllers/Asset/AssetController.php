<?php

namespace App\Http\Controllers\Asset;

use App\Http\Requests\AssetRequest;
use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\AssetFile;
use App\Models\Asset\Bill;
use App\Models\Asset\Contract;
use App\Models\Asset\Supplier;
use App\Models\File\File;
use App\Models\Asset\Source;
use App\Models\User\Department;
use App\Models\User\Org;
use App\Models\User\User;
use Intervention\Image\ImageManager;
use QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Excel;
class AssetController extends Controller
{
    /**
     * @param $list
     * @return mixed
     */
    public function test($list){
        foreach ($list as $key=>$value){
            // var_dump($value);
            $s=$value->path;
            //转换为数组
            $arr=explode(',',$s);
            //获取数组的长度
            $len=count($arr);
            //获取逗号个数
            $dlen=$len-1;
            //拼接分割符 str_repeat()重复字符串
            $list[$key]->name=str_repeat('|__',$dlen).$value->name;
        }
        return $list;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('asset.index')){
            return $res;
        }
        if ($request->ajax()) {
            $org_id = get_current_login_user_org_id();
            $map = [
                ['org_id', '=', $org_id],
                ['status', '!=', '0']
            ];
            if ($request->search) {
                $map[] = ['name', 'like', '%' . $request->search . '%'];
            }
            $data = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier', 'contract')->where($map)->orderBy("id", "desc")->paginate(request('limit'));

            foreach ($data as $k=>$v){
                switch ($v->status){
                    case "0":
                        $data[$k]['status'] = '<span class="btn-sm label-warning" >已报废</span>';
                        break;
                    case "1":
                        $data[$k]['status'] = '<span class="btn-sm label-info" >闲置</span>';
                        break;
                    case "2":
                        $data[$k]['status'] = '<span class="btn-sm label-danger" >借出</span>';
                        break;
                    case "3":
                        $data[$k]['status'] = '<span class="btn-sm label-primary" >领用</span>';
                        break;
                    case "4":
                        $data[$k]['status'] = '<span class="btn-sm label-success" >在用</span>';
                        break;
                    case "5":
                        $data[$k]['status'] = '<span class="btn-sm label-success" >调拨中</span>';
                        break;
                }
            }
            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.asset.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('asset.add')){
            return $res;
        }
        $org_id = get_current_login_user_org_id();
        //资产类别
        $list1 = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->where("org_id",Auth::user()->org_id)->orderBy("paths")->get();
        $list1 = $this->test($list1);
        //所属公司
        $list2 = Org::where("id",$org_id)->get();
        //管理员
        $list3 = User::where("org_id",$org_id)->get();
        //场地
        $list4 = Area::where("org_id",$org_id)->get();
        $list4 = $this->test($list4);
        //所属部门
        $list6 = Department::where("org_id",$org_id)->get();
        //供应商
        $list7 = Supplier::where("org_id",$org_id)->get();
        return response()->view("asset.asset.add",compact("list1","list2","list3","list4","list6","org_id","list7"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetRequest $request)
    {
        if ($res = is_permission('asset.add')){
            return $res;
        }
        if(!$request->code){
            //公司code+资产类别code+序列号值
            $org_code = Org::where("id",get_current_login_user_org_id())->value("code");
            $category_code = AssetCategory::where("id",$request->category_id)->value("category_code");

            //查找当前org_id、当前资产类别下的最大serial_number值
            $max_serial = Asset::where(['org_id'=>get_current_login_user_org_id(),'category_id'=>$request->category_id])->orderBy("serial_number","desc")->first();
            if($max_serial){
                $code = $org_code.$category_code.str_pad($max_serial->serial_number+1,5,"0",STR_PAD_LEFT);
            }else{
                $code = $org_code.$category_code.'00001';
            }
            $request->offsetSet("code",$code);
        }
        $arr = $request->except("_token","img","file_id");

        $arr['serial_number'] = $max_serial->serial_number+1;
        $arr['asset_uid'] = Uuid::generate()->string;
        QrCode::format('png')->size("100")->margin(0)->generate($arr['asset_uid'],public_path('uploads/asset/'.$arr['asset_uid'].'.png'));

        $arr['qrcode_path'] = 'uploads/asset/'.$arr['asset_uid'].'.png';


        $arr['created_at'] = date("Y-m-d H:i:s");
        if($request->use_department_id){
            $arr['status'] = '4';
        }else{
            $arr['status'] = "1";
        }
        $arr['org_id'] = get_current_login_user_org_id();

        $info = Asset::insertGetId($arr);

        if($request->file_id){
            $file_arr = [
                'asset_id' => $info,
                'file_id' => $request->file_id,
                'org_id' => get_current_login_user_org_id()
            ];
            AssetFile::insert($file_arr);
        }

        if($info){
            $message = [
                'status'=>1,
                'message'=>"添加成功"
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '添加失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($res = is_permission('asset.index')){
            return $res;
        }
        $info = Asset::with('category','org','user','admin','department','useDepartment','area','contract')->find($id);
        //图片
        $file = Asset::find($info->id)->file()->first();
        $info->img_path = $file["path"];
        return response()->view("asset.asset.show",compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('asset.edit')){
            return $res;
        }
        if(get_current_login_user_org_id() == Asset::where("id",$id)->value("org_id")) {
            $info = Asset::where("id", $id)->first();
            //公司
            $org_id = get_current_login_user_org_id();
            //资产类别
            $list1 = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->where("org_id",$org_id)->orderBy("paths")->get();
            $list1 = $this->test($list1);
            //所属公司
            $list2 = Org::where("id", $org_id)->get();
            //管理员
            $list3 = User::where("org_id", $org_id)->get();
            //场地
            $list4 = Area::where("org_id",$org_id)->get();
            $list4 = $this->test($list4);
            //来源
//            $list5 = Source::where("org_id",$org_id)->get();
            //使用部门
            $list6 = Department::where("org_id",$org_id)->get();
            //图片
            $file = Asset::find($id)->file()->first();
            //供应商
            $list7 = Supplier::where("org_id",$org_id)->get();
            if($file){
                $info->img_path = $file->path;
                $file_id = $file->id;
            }
            return response()->view("asset.asset.edit", compact("info","img_path", "list1", "list2", "list3", "list4","list6","list7"));
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
    public function update(AssetRequest $request, $id)
    {
        if ($res = is_permission('asset.edit')){
            return $res;
        }
        if(get_current_login_user_org_id() == Asset::where("id",$id)->value("org_id")) {
            $arr = $request->except("_token","_method",'file_id');
            $info = Asset::where("id",$id)->update($arr);

            if($request->file_id){

                if($info = AssetFile::where("asset_id",$id)->first()){
                    AssetFile::where("asset_id",$id)->delete();
                }
                $file_arr = [
                    'asset_id' => $id,
                    'file_id' => $request->file_id,
                    'org_id' => get_current_login_user_org_id()
                ];
                AssetFile::insert($file_arr);
            }

            if($info){
                $message = [
                    'status' => 1,
                    'message' => '资产信息修改成功'
                ];
            }else{
                $message = [
                    'status' => 0,
                    'message' => '资产信息修改失败'
                ];
            }
            return response()->json($message);
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
        if ($res = is_permission('asset.del')){
            return $res;
        }
        $arr = explode(",",$id);
        if(get_current_login_user_org_id() == Asset::where("id",$arr[0])->value("org_id")) {
            foreach ($arr as $k=>$v){
                $info = Asset::where("id", $v)->delete();
                if($infos = AssetFile::where("id",$v)->first()){
                    AssetFile::where("asset_id",$v)->delete();
                }
                if($info){
                    $message = [
                        'status' => 1,
                        'message' => '删除成功'
                    ];
                }else{
                    $message = [
                        'status' => '0',
                        'message' => '删除失败'
                    ];
                }
            }
            return response()->json($message);
        }else{
            return redirect("home");
        }
    }


    public function show_img($file_id){
        $info = File::find($file_id);
        return response()->view("asset.asset.showImg",compact('info'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contract_create()
    {
        $map = [
            'org_id' => get_current_login_user_org_id(),
            'status' => "1"
        ];
        $list = Bill::with("category","supplier")->where($map)->get();
        foreach ($list as $k=>$v){
            $list[$k]['contract'] = Contract::where("id",$v->contract_id)->value("name");
        }
        return view("asset.asset.contract_add",compact("list"));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 合同资产录入
     */
    public function contract_store(Request $request)
    {
        foreach ($request->id as $k=>$v){
            $info = Bill::where("id",$v)->first();

            $org_code = Org::where("id",get_current_login_user_org_id())->value("code");
            $category_code = AssetCategory::where("id",$info->category_id)->value("category_code");

            for ($i=0;$i<$info->num;$i++){
                $arr = [
                    'name' => $info->asset_name,
                    'asset_uid' => Uuid::generate()->string,
                    'category_id' => $info->category_id,
                    'spec' => $info->spec,
                    'calculate' => $info->calculate,
                    'money' => $info->money,
                    'buy_time' => date("Y-m-d H:i:s"),
                    'area_id' => $request->area_id,
                    'remarks' => $request->remarks,
                    'org_id' => $info->org_id,
                    'department_id' => $request->department_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'supplier_id' => $info->supplier_id,
                    'status' => "1",
                    'contract_id' => $info->contract_id
                ];
                //查找当前org_id、当前资产类别下的最大serial_number值
                $max_serial = Asset::where(['org_id'=>get_current_login_user_org_id(),'category_id'=>$info->category_id])->orderBy("serial_number","desc")->first();
                if($max_serial){
                    $arr['code'] = $org_code.$category_code.str_pad($max_serial->serial_number+1,5,"0",STR_PAD_LEFT);
                }else{
                    $arr['code'] = $org_code.$category_code.'00001';
                }
                $arr['serial_number'] = $max_serial->serial_number+1;
                QrCode::format('png')->size("100")->margin(0)->generate($arr['asset_uid'],public_path('uploads/asset/'.$arr['asset_uid'].'.png'));
                $arr['qrcode_path'] = 'uploads/asset/'.$arr['asset_uid'].'.png';
                $infos = Asset::insertGetId($arr);
                if($infos){
                    Bill::where("id",$v)->update(['status' => '2']);
                }
                if($request->file_id){
                    $file_arr = [
                        'asset_id' => $infos,
                        'file_id' => $request->file_id,
                        'org_id' => get_current_login_user_org_id()
                    ];
                    AssetFile::insert($file_arr);
                }
            }
        }
        return response()->json(['status' => '1','message' => '合同资产录入成功']);
    }

    public function slt_supplier($id){

        $list = AssetCategory::find($id)->supplier()->get();
        return response()->json($list);
    }


    /**
     * 供应商管理  数据导出
     */
    public function export(){

        $list = Asset::where("org_id",get_current_login_user_org_id())->get();
        $cellData = [['资产编号','资产名称','资产类别','规格型号', '计量单位','金额(元)',
            '购入时间','所在场地(area_id)', '所属部门','供应商','资产备注']];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['code'] = $value->code;
            $arr['name'] = $value->name;
            $arr['category'] = AssetCategory::where("id",$value->category_id)->value("name");
            $arr['spec'] = $value->spec;
            $arr['calculate'] = $value->calculate;
            $arr['money'] = $value->money;
            $arr['buy_time'] = $value->buy_time;

            $arr['area_id'] = "";
            $str = (Area::where("id",$value->area_id)->value('path')).$value->area_id;
            $str = explode(",",$str);
            foreach ($str as $k=>$v){
                $arr['area_id'] .= Area::where("id",$v)->value("name")." / ";
            }
            $arr['area_id'] = trim($arr['area_id']," / ");
            $arr['department_id'] = Department::where("id",$value->department_id)->where("org_id",Auth::user()->org_id)->value("name");
            $arr['supplier_id'] = Supplier::where("id",$value->supplier_id)->where("org_id",Auth::user()->org_id)->value("name");
            $arr['remarks'] = $value->remarks;
            array_push($cellData,$arr);
        }
        Excel::create('资产管理_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('资产管理', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40, 'D' => 40, 'E' => 40,
                    'F' => 40, 'G' => 40, 'H' => 40, 'I' => 40, 'J' => 40, 'K' => 40
                ));
                $sheet->cells('A1:K1', function($row) {
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
        $cellData1 = [['资产编号(code)','资产名称(name)','资产类别(category_id)','规格型号(spec)',
            '计量单位(calculate)','金额(money)元','购入时间(buy_time)','所在场地(area_id)',
            '所属部门(department_id)','供应商(supplier_id)','资产备注(remarks)']];
        //资产类别
        $cellData2 = [['资产类别名称','类别编号']];
        $list2 = AssetCategory::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list2 as $k=>$v){
            $arr = [
                $list2[$k]->name,$list2[$k]->id
            ];
            array_push($cellData2,$arr);
        }
        //所在场地
        $cellData3 = [['场地名称','场地编号']];
        $list3 = Area::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list3 as $k=>$v){
            $arr = [
                $list3[$k]->name,$list3[$k]->id
            ];
            array_push($cellData3,$arr);
        }
        //所属部门
        $cellData4 = [['部门名称','部门编号']];
        $list4 = Department::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list4 as $k=>$v){
            $arr = [
                $list4[$k]->name,$list4[$k]->id
            ];
            array_push($cellData4,$arr);
        }
        //供应商
        $cellData5 = [['供应商名称','供应商编号']];
        $list5 = Supplier::where("org_id",get_current_login_user_org_id())->get();
        foreach ($list5 as $k=>$v){
            $arr = [
                $list5[$k]->name,$list5[$k]->id
            ];
            array_push($cellData5,$arr);
        }
        Excel::create('资产录入模板', function($excel) use ($cellData1,$cellData2,$cellData3,$cellData4,$cellData5){

            // Our first sheet
            $excel->sheet('资产录入', function($sheet1) use ($cellData1){
                $sheet1->setPageMargin(array(
                    0.30,0.30,0.30,0.30
                ));
                $sheet1->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40, 'D' => 40, 'E' => 40,
                    'F' => 40, 'G' => 40, 'H' => 40, 'I' => 40, 'J' => 40, 'K' => 40
                ));
                $sheet1->cells('A1:K1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet1->rows($cellData1);
            });

            //资产类别
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
            //所在场地
            $excel->sheet('所在场地', function($sheet3) use ($cellData3){
                $sheet3->setPageMargin(array(
                    0.30,0.30
                ));
                $sheet3->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet3->cells('A1:B1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet3->rows($cellData3);
            });
            //所属部门
            $excel->sheet('所属部门', function($sheet4) use ($cellData4){
                $sheet4->setPageMargin(array(
                    0.30,0.30
                ));
                $sheet4->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet4->cells('A1:B1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet4->rows($cellData4);
            });
            //服务商
            $excel->sheet('供应商', function($sheet5) use ($cellData5){
                $sheet5->setPageMargin(array(
                    0.30,0.30
                ));
                $sheet5->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet5->cells('A1:B1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet5->rows($cellData5);
            });

        })->export('xls');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function add_import(){
        return response()->view('asset.asset.add_import');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request){
        $filePath =  $request->file_path;
        Excel::selectSheets('资产录入')->load($filePath, function($reader) {
            $data = $reader->getsheet(0)->toArray();
            dd($data);
            $org_id = get_current_login_user_org_id();
            foreach ($data as $k=>$v){
                if($k==0){
                    continue;
                }
                $arr = [
                    'code' => $v[0],
                    'name' => $v[1],
                    'category_id' => $v[2],
                    'spec' => $v[3],
                    'calculate' => $v[4],
                    'money' => $v[5],
                    'buy_time' => $v[6],
                    'area_id' => $v[7],
                    'department_id' => $v[8],
                    'supplier_id' => $v[9],
                    'remarks' => $v[10],
                    'asset_uid' => Uuid::generate()->string,
                    'org_id' => $org_id
                ];
                if(!$arr['code']){
                    $arr['code'] = date('dHis').rand("1000",'9999');
                }
                Asset::insert($arr);
            }
        });
        $message = [
            'status'=>'1',
            'message'=> '资产数据导入成功'
        ];
        return response()->json($message);
    }


}
