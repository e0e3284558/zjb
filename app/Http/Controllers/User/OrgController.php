<?php

namespace App\Http\Controllers\User;

use App\Models\User\Org;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrgController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 单位组织机构管理
    |--------------------------------------------------------------------------
    |
    | 管理单位组织机构信息、单位管理员查看管理单位基本信息
    |
    */
   
    /**
     * 单位基本信息
     *
     * @return \Illuminate\Http\Response
     */
    public function unit(){
        echo 'unit';
        exit;
    }

    /**
     * 单位组织机构信息
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
     * @param  \App\Models\User\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function show(Org $org)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function edit(Org $org)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Org $org)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function destroy(Org $org)
    {
        //
    }
}
