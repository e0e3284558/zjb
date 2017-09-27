<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\AssetFile;
use App\Models\Asset\Bill;
use App\Models\Asset\Supplier;
use App\Models\User\Department;
use App\Models\User\Org;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use QrCode;

class BillController extends Controller
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
     *清单管理
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $org_id = Auth::user()->org_id;
            $map = [
                ['org_id', '=', $org_id]
            ];
//            if ($request->category_id) {
//                $map[] = ['category_id', '=', $request->category_id];
//            }
//            if ($request->search) {
//                $map[] = ['name', 'like', '%' . $request->search . '%'];
//            }
            $data = Bill::with("contract","org")->where($map)->orderBy("id", "desc")->paginate(request('limit'));


            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.bill.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bill_id)
    {
//        dd($bill_id);
        $org_id = Auth::user()->org_id;
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
        return view("asset.bill.add_asset",compact("list1",'list2','list3','list4','list6','list7',"bill_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->sum){
            $request->sum = 1;
        }
        for ($i=0;$i<$request->sum;$i++){
            //公司code+资产类别code+日期随机值
            $org_code = Org::where("id",Auth::user()->org_id)->value("code");
            $category_code = AssetCategory::where("id",$request->category_id)->value("category_code");
            $code = $org_code.$category_code.rand('00001','99999');
            $request->offsetSet("code",$code);
            $arr = $request->except("_token","img","file_id","sum");

            $arr['asset_uid'] = Uuid::generate()->string;
            $arr['status'] = "1";
            $arr['contract_id'] = Bill::where("id",$request->bill_id)->value("contract_id");
            QrCode::format('png')->size("100")->margin(0)->generate($arr['asset_uid'],public_path('uploads/asset/'.$arr['asset_uid'].'.png'));
            $arr['qrcode_path'] = 'uploads/asset/'.$arr['asset_uid'].'.png';
            $arr['created_at'] = date("Y-m-d H:i:s");
            $arr['org_id'] = Auth::user()->org_id;

            $info = Asset::insertGetId($arr);

            if($request->file_id){
                $file_arr = [
                    'asset_id' => $info,
                    'file_id' => $request->file_id,
                    'org_id' => Auth::user()->org_id
                ];
                AssetFile::insert($file_arr);
            }
        }
        $message = [
            'status'=>1,
            'message'=>"添加成功"
        ];
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
        $list = Asset::with("category","user","admin","source","area","department","useDepartment","file","supplier")->where("bill_id",$id)->get();
        foreach ($list as $key => $value) {
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }
        return view("asset.bill.show",compact("list"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Bill::find($id);
        return view("asset.bill.edit",compact("info"));
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
        $info = Bill::where("id",$id)->update($request->except("_token","_method"));
        if($info){
            $message = [
                'status' => "1",
                'message' => '信息修改成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '信息修改失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arr = explode(",",$id);
        foreach ($arr as $v){
            $info = Asset::where("bill_id",$v)->first();
            if($info){
                $message = [
                    'status' => 0,
                    'message' => '清单下还有资产不能删除'
                ];
                return response()->json($message);
            }
        }

        foreach ($arr as $v){
            $info = Bill::destroy($v);
        }
        $message = [
            'status' => '1',
            'message' => '清单删除成功'
        ];
        return response()->json($message);
    }
}
