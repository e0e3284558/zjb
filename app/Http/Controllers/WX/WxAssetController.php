<?php

namespace App\Http\Controllers\WX;

use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\File\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxAssetController extends Controller
{

    public function find(Request $request){
        if(!$request->openId){
            return $message = [
                'code' => 1,
                'message' => '请先授权该程序用户信息'
            ];
        }
        $info = Asset::where("asset_uuid",$request->asset_uuid)->first();
        if(!$info){
            return $message = [
                'code' => '1',
                'message' => '请输入正确的编号'
            ];
        }
        //资产类别
        $category_info = AssetCategory::find($info->category_id);

        $arr['category'] = $category_info->name;

        //资产所在场地
        $file = Area::where("id",$info->area_id)->value("path");
        $file_arr = explode(',',$file.$info->area_id);
        $str = "";
        foreach ($file_arr as $v){
            $str .= Area::where("id",$v)->value("name")." / ";
        }
        $arr['field'] = trim($str," / ");
        $info->category = $category_info->name;

        $info->field = trim($str," / ");

        return $info;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
}
