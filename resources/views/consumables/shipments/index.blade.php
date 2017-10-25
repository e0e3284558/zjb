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
                                   href="{{url('consumables/shipments/create')}}"
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
                                           url:'{{ route("shipments.index") }}',page:true,limit:20,
                                           even:true,response:{countName: 'total'}}">
                                    <thead>
                                    <tr>
                                        <th lay-data="{fixed:'left',checkbox:true}"></th>
                                        <th lay-data="{field:'type', width:120, sort: true,templet: '#type'}">
                                            单据类型
                                        </th>
                                        <th lay-data="{field:'delivery_number', width:120, sort: true}">出库单号</th>
                                        <th lay-data="{field:'depot',templet: '#depot', width:120, sort: true}">出库仓库
                                        </th>
                                        <th lay-data="{field:'receipt_date', width:120, sort: true}">出库日期</th>
                                        <th lay-data="{field:'user', templet: '#user', width:120, sort: true}">经办人</th>
                                        <th lay-data="{field:'handle_date', width:120, sort: true}">经办日期</th>
                                        <th lay-data="{field:'comment', width:120, sort: true}">出库备注</th>
                                        <th lay-data="{fixed:'right',width:160, align:'center', toolbar: '#barDemo'}">
                                            操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <script type="text/html" id="barDemo">
                                        <a class="btn blue-madison btn-sm" lay-event="show">查看出库单详情</a>
                                    </script>

                                    <script type="text/html" id="type">
                                        @{{#  if(d.type == 1){ }}
                                        <label class="btn btn-sm btn-primary">入库单</label>
                                        @{{#  } else { }}
                                        <label class="btn btn-sm btn-danger">出库单</label>
                                        @{{#  } }}
                                    </script>

                                    <script type="text/html" id="depot">
                                        @{{# if(d.depot){  }}
                                        @{{d.depot.name}}
                                        @{{# } }}
                                    </script>
                                    <script type="text/html" id="user">
                                        @{{# if(d.user){  }}
                                        @{{d.user.username}}
                                        @{{# } }}
                                    </script>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            layui.use(['laytpl', 'table'], function () {
                table = layui.table;
                table.on('checkbox(data-user)', function (obj) {
                    console.log(obj);
                });
            });
            table.on('tool(data-user)', function (obj) {
                curObj = obj;
                curData = obj.data; //获得当前行数据
                var event = obj.event; //获得 lay-event 对应的值
                curTrObj = obj.tr; //获得当前行 tr 的DOM对象
                if (event == 'show') {
                    $("#operationModal").modal('show');
                    zjb.ajaxGetHtml($('#operationModal .modal-content'),
                        '{{url("consumables/shipments/")}}/'+curData.id, {'id': curData.id}, true);
                }
            });

        })
    </script>
@endsection
