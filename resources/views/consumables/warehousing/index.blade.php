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
                    <a href="javascript:;">耗材管理</a>
                </li>

                <li class="active">
                    <strong>入库管理</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection

@section('content')
    <div class="modal" id="operationModal" role="dialog" aria-labelledby="operationModalLabel">
        <div class="modal-dialog modal-md  animated bounceInDown" aria-hidden="true" role="document">
            <div class="modal-content">
                <div class="progress m-b-none">
                    <div class="progress-bar progress-bar-info progress-bar-striped active"
                         role="progressbar" aria-valuenow="100" aria-valuemin="0"
                         aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <h3 class="box-title">
                                <!-- Single button -->
                                <a type="button" class="btn btn-primary dropdown-toggle" data-toggle="modal"
                                   href="{{url('consumables/warehousing/create')}}"
                                        data-target=".bs-example-modal-lg">
                                    新增
                                </a>

                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target=".bs-example-modal-lg">
                                    删除
                                </button>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target=".bs-example-modal-lg">
                                    冲销
                                </button>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target=".bs-example-modal-lg">
                                    打印
                                </button>
                                <button type="button" class="btn btn-default">导出Excel</button>
                            </h3>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">

                                <table class="layui-table" lay-filter="data-user"
                                       lay-data="{id:'dataUser',height: 'full-194',
                                           url:'{{ route("warehousing.index") }}',page:true,limit:20,
                                           even:true,response:{countName: 'total'}}">
                                    <thead>
                                    <tr>
                                        <th lay-data="{fixed:'left',checkbox:true}"></th>
                                        <th lay-data="{field:'display', width:120, sort: true,templet: '#disable'}">
                                            单据类型
                                        </th>
                                        <th lay-data="{field:'upload_id', width:120, sort: true,templet: '#img'}">
                                            图片
                                        </th>
                                        <th lay-data="{field:'coding', width:120, sort: true}">单据类型</th>
                                        <th lay-data="{field:'classify_id', width:120, sort: true}">所属分类</th>
                                        <th lay-data="{field:'barcode', width:120, sort: true}">物品条形码</th>
                                        <th lay-data="{field:'norm', width:120, sort: true}">规格型号</th>
                                        <th lay-data="{field:'unit', width:120, sort: true}">单元</th>
                                        <th lay-data="{field:'trademark', width:120, sort: true}">商标</th>
                                        <th lay-data="{field:'inventory_cap', width:120, sort: true}">安全库存上限</th>
                                        <th lay-data="{field:'inventory_lower', width:120, sort: true}">安全库存下限</th>
                                        <th lay-data="{fixed:'right',width:160, align:'center', toolbar: '#barDemo'}">
                                            操作
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
