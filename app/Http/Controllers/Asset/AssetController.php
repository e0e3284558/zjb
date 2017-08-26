<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\AssetFile;
use App\Models\Asset\File;
use App\Models\Asset\Source;
use App\Models\User\Department;
use App\Models\User\Org;
use App\Models\User\User;
use QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

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
    public function index()
    {
        $list = Asset::where("org_id",Auth::user()->org_id)->orderBy("id","desc")->get();
        foreach ($list as $key=>$value){
            $list[$key]['category_id'] = AssetCategory::where("id",$value->category_id)->value("name");
            $list[$key]['use_org_id'] = Org::where("id",$value->use_org_id)->value("name");
            $list[$key]['admin_id'] = User::where("id",$value->admin_id)->value("name");
            //所属公司
            $list[$key]['org_id'] = Org::where("id",$value->org_id)->value("name");
            //来源
            $list[$key]['source_id'] = Source::where("id",$value->source_id)->value("name");
            //所在位置
            $list[$key]['area_id'] = Area::where("id",$value->area_id)->value("name");
            //所属部门
            $list[$key]['department_id'] = Department::where("id",$value->department_id)->value("name");
            $list[$key]['use_department_id'] = Department::where("id",$value->use_department_id)->value("name");
            //图片
            if($asset_file = AssetFile::where("asset_id",$value->id)->first()){
                $list[$key]['img_path'] = File::where("id",$asset_file->file_id)->value("path");
                $list[$key]['file_id'] = $asset_file->file_id;
            }
        }
        return view("asset.asset.index",compact("list"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //资产类别
        $list1 = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->where("org_id",Auth::user()->org_id)->orderBy("paths")->get();

        $list1 = $this->test($list1);
        //所属公司
        $list2 = Org::where("id",Auth::user()->org_id)->get();
        //管理员
        $list3 = User::where("org_id",Auth::user()->org_id)->get();
        //场地
        $list4 = Area::where("org_id",Auth::user()->org_id)->get();
        //来源
        $list5 = Source::where("org_id",Auth::user()->org_id)->get();
        //所属部门
        $list6 = Department::where("org_id",Auth::user()->org_id)->get();
        //公司
        $org_id = Auth::user()->org_id;
        return response()->view("asset.asset.add",compact("list1","list2","list3","list4","list5","list6","org_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = date("dHis").rand("10000","99999");
        $request->offsetSet("code",$code);
        $arr = $request->except("_token","img","file_id");

        $arr['asset_uid'] = Uuid::generate()->string;
        QrCode::format('png')->size("100")->margin(0)->generate($arr['asset_uid'],public_path('uploads/qrcodes/'.$arr['asset_uid'].'.png'));
        $arr['created_at'] = date("Y-m-d H:i:s");
        $arr['asset_status_id'] = "1";
        $info = Asset::insertGetId($arr);

        $file_arr = [
            'asset_id' => $info,
            'file_id' => $request->file_id,
            'org_id' => Auth::user()->org_id
        ];

        AssetFile::insert($file_arr);

        if($info){
            $message = [
                'code'=>1,
                'message'=>"添加成功"
            ];
        }else{
            $message = [
                'code' => 0,
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
        $info = Asset::find($id);
        //资产类别
        $info->category_id = AssetCategory::where("id",$info->category_id)->value("name");
        //使用部门
        $info->use_department_id = Department::where("id",$info->department_id)->value("name");
        //管理员
        $info->admin_id = User::where("id",$info->admin_id)->value("name");
        //所在场地
        $arr = Area::where("id",$info->area_id)->value("path");
        $arr = explode(",",$arr);
        $str = "";
        foreach ($arr as $v){
            $str .= Area::where("id",$v)->value("name")."/";
        }
        $str .= Area::where("id",$info->area_id)->value("name");
        $info->area_id = trim($str,"/");
        //来源
        $info->source_id = Source::where("id",$info->source_id)->value("name");
        //所属公司
        $info->org_id = Org::where("id",$info->org_id)->value("name");
        //图片
        $file_id = AssetFile::where("id",$info->id)->value("file_id");
        $info->img_path = File::where("id",$file_id)->value("path");
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
        if(Auth::user()->org_id == Asset::where("id",$id)->value("org_id")) {
            $info = Asset::where("id", $id)->first();
            //资产类别
            $list1 = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->orderBy("paths")->get();

            $list1 = $this->test($list1);
            //所属公司
            $list2 = Org::where("id", Auth::user()->org_id)->get();
            //管理员
            $list3 = User::where("org_id", Auth::user()->org_id)->get();
            //区域
            $list4 = Area::where("org_id",Auth::user()->org_id)->get();
            //来源
            $list5 = Source::where("org_id",Auth::user()->org_id)->get();
            //使用部门
            $list6 = Department::where("org_id",Auth::user()->org_id)->get();
            //公司
            $org_id = Auth::user()->org_id;
            //图片
            $file_id = AssetFile::where("id",$info->id)->value("file_id");
            $info->img_path = File::where("id",$file_id)->value("path");
            return response()->view("asset.asset.edit", compact("info","img_path", "list1", "list2", "list3", "list4", "list5","list6"));
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
        if(Auth::user()->org_id == Asset::where("id",$id)->value("org_id")) {
            $arr = $request->except("_token","_method",'file_id');
            $info = Asset::where("id",$id)->update($arr);

            if($request->file_id){

                if($info = AssetFile::where("asset_id",$id)->first()){
                    AssetFile::where("asset_id",$id)->delete();
                }
                $file_arr = [
                    'asset_id' => $id,
                    'file_id' => $request->file_id,
                    'org_id' => Auth::user()->org_id
                ];
                AssetFile::insert($file_arr);
            }

            if($info){
                $message = [
                    'code' => 1,
                    'message' => '资产信息修改成功'
                ];
            }else{
                $message = [
                    'code' => 0,
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
        $arr = explode(",",$id);
        if(Auth::user()->org_id == Asset::where("id",$arr[0])->value("org_id")) {
            foreach ($arr as $k=>$v){
                $info = Asset::where("id", $v)->delete();
                if($infos = AssetFile::where("id",$v)->first()){
                    AssetFile::where("asset_id",$v)->delete();
                }
                if($info){
                    $message = [
                        'code' => 1,
                        'message' => '删除成功'
                    ];
                }else{
                    $message = [
                        'code' => '0',
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

}
