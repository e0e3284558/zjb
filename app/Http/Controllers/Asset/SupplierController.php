<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Supplier::with('category','org')->where("org_id",Auth::user()->org_id)->get();
        $category_list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        return view("asset.supplier.index",compact("list","category_list"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $arr = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'remarks' => $request->remarks,
            'org_id' => Auth::user()->org_id,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $supplier_id = Supplier::insertGetId($arr);

        $message = [
            'code' => 1,
            'message' => '添加成功'
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
        if(Auth::user()->org_id == Supplier::where("id",$id)->value("org_id")) {
            $info = Supplier::find($id);
            $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
            return response()->view("asset.supplier.edit", compact("info","list"));
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
        $arr = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'remarks' => $request->remarks,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $info = Supplier::where("id",$id)->update($arr);

        if($info){
            $message = [
                'code' => 1,
                'message' =>'信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' =>'信息修改失败'
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
        $user_org_id = Auth::user()->org_id;
        if($user_org_id == Supplier::where("id",$arr[0])->value("org_id")) {
            foreach ($arr as $k=>$v){
                $info = Asset::where("org_id",$user_org_id)->where("supplier_id",$v)->first();
                if($info){
                    $message = [
                        'code' => 0,
                        'message' => '删除失败'
                    ];
                    return response()->json($message);
                }
            }

            foreach ($arr as $k=>$v){
                $info = Supplier::where("id",$v)->where("org_id",Auth::user()->org_id)->delete();
            }
            $message = [
                'code' => 1,
                'message' => '删除成功'
            ];
            return response()->json($message);
        }else{
            return redirect("home");
        }
    }
}
