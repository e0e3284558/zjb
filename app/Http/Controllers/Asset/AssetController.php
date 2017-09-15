<?php

namespace App\Http\Controllers\Asset;

use App\Http\Requests\AssetRequest;
use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\AssetFile;
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
        $org_id = Auth::user()->org_id;
        $map = [
            ['org_id','=',$org_id]
        ];
        if($request->category_id){
            $map[] = ['category_id','=',$request->category_id];
        }
        if($request->name){
            $map[] = ['name','like','%'.$request->name.'%'];
        }
        $list = Asset::with('category','org','user','admin','source','department','useDepartment','area','supplier')->where($map)->orderBy("id","desc")->paginate(5);

        foreach ($list as $key=>$value){
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }
        //资产类别
        $category_list = AssetCategory::where("org_id",$org_id)->get();
        $list = $list->appends(array('category_id'=>$request->category_id,'name'=>$request->name,'app_groups'=>'asset'));
        return view("asset.asset.index",compact("list","category_list"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //来源
//        $list5 = Source::where("org_id",$org_id)->get();
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
        $code = $request->code?$request->code:date("dHis").rand("10000","99999");
        $request->offsetSet("code",$code);
        $arr = $request->except("_token","img","file_id");

        $arr['asset_uid'] = Uuid::generate()->string;
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
        $info = Asset::with('category','org','user','admin','department','useDepartment','area')->find($id);
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
        if(Auth::user()->org_id == Asset::where("id",$id)->value("org_id")) {
            $info = Asset::where("id", $id)->first();
            //公司
            $org_id = Auth::user()->org_id;
            //资产类别
            $list1 = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->where("org_id",$org_id)->orderBy("paths")->get();
            $list1 = $this->test($list1);
            //所属公司
            $list2 = Org::where("id", $org_id)->get();
            //管理员
            $list3 = User::where("org_id", $org_id)->get();
            //区域
            $list4 = Area::where("org_id",$org_id)->get();
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


    public function add_copy($id){
        return response()->view("asset.asset.copy",compact('id'));
    }

    public function copy(Request $request){
        $info = Asset::find($request->id)->toArray();
        array_shift($info);
        //图片
        $file = Asset::find($request->id)->file()->first();

        if($request->num>99){
            $message = [
                'code' => 0,
                'message' => '最多复制99个'
            ];
        }else{
            for ($i=0;$i<$request->num;$i++){
                $info['code'] = date("dHis").rand("10000","99999");
                $info['asset_uid'] = Uuid::generate()->string;
                $info['created_at'] = date("Y-m-d H:i:s");
                $asset_id = Asset::insertGetId($info);
                QrCode::format('png')->size("100")->margin(0)->generate($info['asset_uid'],public_path('uploads/asset/'.$info['asset_uid'].'.png'));
                if($file){
                    $file_arr = [
                        'asset_id' => $asset_id,
                        'file_id' => $file->id,
                        'org_id' => Auth::user()->org_id
                    ];
                    AssetFile::insert($file_arr);
                }
            }
            $message = [
                'code' => 1,
                'message' => '复制成功'
            ];
        }

        return response()->json($message);
    }

}
