<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\File;
use App\Models\Upload;
use App\Models\User\Org;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        if ($file->isValid()) {
            $upload['type'] = $file->getMimeType();  //mime类型
            $upload['old_name'] = $file->getClientOriginalName();  //原始文件名
            $upload['suffix'] = $file->getClientOriginalExtension(); //上传文件的后缀.
            $upload['name'] = date('YmdHis') . mt_rand(100, 999) . '.' . $upload['suffix'];  //新文件名
            $upload['file_path'] = $file->move(base_path() . '/public/uploads/imgs/',$upload['name']); //存储路径
            $upload['size'] = $file->getClientSize(); //文件大小
            $upload['path'] = 'uploads/imgs/' . $upload['name'];  //入口路径
            $upload['org_id'] = Auth::user()->org_id;
            $upload['id']=File::insertGetId($upload);
            return $upload;
        }
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
        $file = $request->file('file');
        if ($file->isValid()) {
            $upload['type'] = $file->getMimeType();  //mime类型
            $upload['old_name'] = $file->getClientOriginalName();  //原始文件名
            $upload['suffix'] = $file->getClientOriginalExtension(); //上传文件的后缀.
            $upload['name'] = date('YmdHis') . mt_rand(100, 999) . '.' . $upload['suffix'];  //新文件名
            $upload['file_path'] = $file->move(base_path() . '/public/uploadsimgs/',$upload['name']); //存储路径
            $upload['size'] = $file->getClientSize(); //文件大小
            $upload['path'] = 'uploads/imgs/' . $upload['name'];  //入口路径
            $upload['id']=File::insertGetId($upload);
            return $upload;
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
