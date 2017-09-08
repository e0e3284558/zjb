@extends('layouts.app')

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <!-- <h2></h2> -->
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>

                <li>
                    <a href="javascript:;">报修管理</a>
                </li>

                <li class="active">
                    <strong>待维修列表</strong>
                </li>
            </ol>
        </div>
    </div>

@endsection

@section('content')
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>待维修列表</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>报修人</th>
                                <th>报修物品</th>
                                <th>报修物品所属分类</th>
                                <th>报修物品照片</th>
                                <th>报修备注</th>
                                <th>维修建议</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection