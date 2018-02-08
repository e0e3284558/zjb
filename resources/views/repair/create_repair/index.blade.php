@extends('layouts.app')

@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
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
                        <h5>维修列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="@if (request()->active=='wait' || !request()->active) active  @endif">
                                    <a href="{{url('repair/create_repair?app_groups=repair&active=wait')}}">待派工</a>
                                </li>
                                <li class="@if (request()->active=='doing') active  @endif">
                                    <a href="{{url('repair/create_repair?app_groups=repair&active=doing')}}">维修中</a>
                                </li>
                                <li class="@if (request()->active=='assess') active  @endif">
                                    <a href="{{url('repair/create_repair?app_groups=repair&active=assess')}}">待评价</a>
                                </li>
                                <li class="@if (request()->active=='success') active  @endif">
                                    <a href="{{url('repair/create_repair?app_groups=repair&active=success')}}">维修完成</a>
                                </li>
                                <li class="@if (request()->active=='all') active  @endif">
                                    <a href="{{url('repair/create_repair?app_groups=repair&active=all')}}">全部维修</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane @if (request()->active=='wait' || !request()->active) active  @endif"
                                     id="tab-1">
                                    @if(isset($data1))
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll"
                                                               id="all1">
                                                    </th>
                                                    <th>状态</th>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修项目</th>
                                                    <th>维修单详情</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data1 as $v)
                                                    <tr>
                                                        <td role="gridcell">
                                                            <input type="checkbox" class="i-checks" name="id"
                                                                   value="{{$v->id}}">
                                                        </td>
                                                        <td>
                                                            @if($v->status=='1' || $v->status=='4' || $v->status=='7')
                                                                <span class="label label-info">待分派</span>
                                                            @endif
                                                        </td>
                                                        @if($v->user)
                                                            <td>{{$v->user_id?$v->user->name:""}}</td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>{{@get_area($v->area_id)}}</td>
                                                        @if($v->classify && (!$v->asset_id))
                                                            <td>{{$v->classify->name}}</td>
                                                        @else
                                                            <td>{{$v->asset->name}}</td>
                                                        @endif

                                                        <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm left"
                                                                    onclick="assign('{{$v->id}}')"
                                                                    data-toggle="modal"
                                                                    data-target=".bs-example-modal-lg">
                                                                分派维修
                                                            </button>
                                                            @if($v->status=='4' || $v->status=='7')
                                                                <button class="btn btn-warning btn-sm left"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-lg"
                                                                        onclick="reason('{{$v->id}}')">查看原因
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <button type="button" onclick="edit(this)" class="btn btn-sm btn-primary"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg">
                                                批量分派
                                            </button>
                                        </div>
                                        <div class="page-header">{{ $data1->appends(['active'=>'wait'])->links() }}</div>
                                    @endif
                                </div>
                                <div class="tab-pane @if (request()->active=='doing') active  @endif" id="tab-2">
                                    @if(isset($data2))
                                        <div class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="i-checks" name="checkAll"
                                                                   id="all2"></th>
                                                        <th>报修人</th>
                                                        <th>报修场地</th>
                                                        <th>报修项目</th>
                                                        <th>维修单详情</th>
                                                        <th>维修人员</th>
                                                        <th width="18%">操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data2 as $v)
                                                        <tr>
                                                            <td role="gridcell">
                                                                <input type="checkbox" class="i-checks" name="id"
                                                                       value="{{$v->id}}">
                                                            </td>
                                                            @if($v->user)
                                                                <td>{{$v->user_id?$v->user->name:""}}</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            <td>{{@get_area($v->area_id)}}</td>
                                                            @if($v->classify && (!$v->asset_id))
                                                                <td>{{$v->classify->name}}</td>
                                                            @else
                                                                <td>{{$v->asset->name}}</td>
                                                            @endif
                                                            <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                            </td>
                                                            <td>{{$v->serviceWorker->name}}</td>
                                                            <td>
                                                                <button class="btn btn-warning btn-sm left"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-lg"
                                                                        onclick="change_status({{$v->id}})">重新分派
                                                                </button>

                                                                <button class="btn btn-info btn-sm left"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-lg"
                                                                        onclick="success({{$v->id}})">
                                                                    完成维修
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-warning btn-sm left"
                                                        data-toggle="modal"
                                                        data-target=".bs-example-modal-lg"
                                                        onclick="edit(this)">重新分派
                                                </button>
                                                <button type="button" onclick="batchSuccess(this)"
                                                        class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target=".bs-example-modal-lg">
                                                    批量完成
                                                </button>
                                            </div>
                                        </div>
                                        <div class="page-header">{{ $data2->appends(['active'=>'doing'])->links() }}</div>
                                    @endif

                                </div>
                                <div class="tab-pane @if (request()->active=='assess') active  @endif" id="tab-3">
                                    @if(isset($data4))
                                        <div class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="i-checks" name="checkAll"
                                                                   id="all4"></th>
                                                        <th>报修人</th>
                                                        <th>报修场地</th>
                                                        <th>报修项目</th>
                                                        <th>维修单详情</th>
                                                        <th>维修人员</th>
                                                        <th>服务商</th>
                                                        <th>状态</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data4 as $v)
                                                        <tr>
                                                            <td role="gridcell">
                                                                <input type="checkbox" class="i-checks" name="id"
                                                                       value="{{$v->id}}">
                                                            </td>
                                                            @if($v->user)
                                                                <td>{{$v->user_id?$v->user->name:""}}</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            <td>{{@get_area($v->area_id)}}</td>
                                                            @if($v->classify && (!$v->asset_id))
                                                                <td>{{$v->classify->name}}</td>
                                                            @else
                                                                <td>{{$v->asset->name}}</td>
                                                            @endif
                                                            <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                            </td>
                                                            <td>{{$v->serviceWorker?$v->serviceWorker->name:""}}</td>
                                                            <td>{{$v->serviceProvider?$v->serviceProvider->name:""}}</td>
                                                            <td>
                                                                @if($v->status=='5')
                                                                    <span class="label label-primary">待评价</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="page-header">{{ $data4->appends(['active'=>'assess'])->links() }}</div>
                                    @endif
                                </div>
                                <div class="tab-pane @if (request()->active=='success') active  @endif" id="tab-4">
                                    @if(isset($data3))
                                        <div class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="i-checks" name="checkAll"
                                                                   id="all3"></th>
                                                        <th>报修人</th>
                                                        <th>报修场地</th>
                                                        <th>报修项目</th>
                                                        <th>维修人员</th>
                                                        <th>服务商</th>
                                                        <th>维修单详情</th>
                                                        <th>评分</th>
                                                        <th>评价</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data3 as $v)
                                                        <tr>
                                                            <td role="gridcell">
                                                                <input type="checkbox" class="i-checks" name="id"
                                                                       value="{{$v->id}}">
                                                            </td>

                                                            <td>
                                                                @if($v->user)
                                                                    {{$v->user_id?$v->user->name:"未获取到用户信息"}}
                                                                @endif
                                                            </td>

                                                            <td>{{@get_area($v->area_id)}}</td>

                                                            <td>
                                                                @if($v->classify && (!$v->asset_id))
                                                                    {{$v->classify->name}}
                                                                @else
                                                                    {{$v->asset->name}}
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if($v->serviceWorker)
                                                                    {{$v->serviceWorker->name}}
                                                                @else
                                                                    维修工已被移除
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($v->serviceProvider)
                                                                    {{$v->serviceProvider->name}}
                                                                @else
                                                                    服务商已被移除
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                            </td>
                                                            <td>
                                                                @for($i=0;$i<$v->score;$i++)
                                                                    <i class="fa fa-star" style="color:#e8bd0d;"></i>
                                                                @endfor
                                                            </td>
                                                            <td title="{{$v->appraisal}}">
                                                                {{mb_substr($v->appraisal,0,10)}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="page-header">{{ $data3->appends(['active'=>'success'])->links() }}</div>
                                    @endif
                                </div>
                                <div class="tab-pane @if (request()->active=='all') active  @endif " id="tab-5">
                                    @if(isset($data5))
                                        <div class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="i-checks" name="checkAll"
                                                                   id="all5"></th>
                                                        <th>状态</th>
                                                        <th>报修人</th>
                                                        <th>报修场地</th>
                                                        <th>报修项目</th>
                                                        <th>维修人员</th>
                                                        <th>维修单详情</th>
                                                        <th>操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data5 as $v)
                                                        <tr>
                                                            <td role="gridcell">
                                                                @if($v->status=='1' || $v->status=='4' || $v->status=='7')
                                                                    <input type="checkbox" class="i-checks" name="id"
                                                                           value="{{$v->id}}">
                                                                @elseif($v->status=='2')
                                                                    <input type="checkbox" class="i-checks" name="id"
                                                                           value="{{$v->id}}">
                                                                @elseif($v->status=='3')
                                                                    <input type="checkbox" class="i-checks" disabled>
                                                                @elseif($v->status=='5')
                                                                    <input type="checkbox" class="i-checks" disabled>
                                                                @elseif($v->status=='6')
                                                                    <input type="checkbox" class="i-checks" disabled>
                                                                @elseif($v->status=='0')
                                                                    <input type="checkbox" class="i-checks" disabled>
                                                                @endif
                                                                {{--<input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">--}}
                                                            </td>
                                                            <td>
                                                                @if($v->status=='1' || $v->status=='4' || $v->status=='7')
                                                                    <span class="label label-info">待分派</span>
                                                                @elseif($v->status=='2')
                                                                    <span class="label label-primary">待服务</span>
                                                                @elseif($v->status=='3')
                                                                    <span class="label label-warning">维修中</span>
                                                                @elseif($v->status=='5')
                                                                    <span class="label label-default">待评价</span>
                                                                @elseif($v->status=='6')
                                                                    <span class="label label-success">已完成</span>
                                                                @elseif($v->status=='0')
                                                                    <span class="label label-danger">工单已取消</span>
                                                                @endif
                                                            </td>
                                                            @if($v->user)
                                                                <td>{{$v->user_id?$v->user->name:""}}</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            <td>{{@get_area($v->area_id)}}</td>
                                                            @if($v->classify && (!$v->asset_id))
                                                                <td>{{$v->classify->name}}</td>
                                                            @else
                                                                @if($v->asset)
                                                                    <td>{{$v->asset->name}}</td>
                                                                @endif
                                                            @endif
                                                            @if($v->serviceWorker)
                                                                <td>{{$v->serviceWorker->name}}</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                            </td>
                                                            <td>
                                                                @if($v->status=='1')
                                                                    <button class="btn btn-success btn-sm pull-left"
                                                                            onclick="assign('{{$v->id}}')"
                                                                            data-toggle="modal"
                                                                            data-target=".bs-example-modal-lg">
                                                                        分派维修
                                                                    </button>
                                                                @elseif($v->status=='4' || $v->status=='7')
                                                                    <button class="btn btn-danger btn-sm pull-left"
                                                                            data-toggle="modal"
                                                                            data-target=".bs-example-modal-lg"
                                                                            onclick="reason('{{$v->id}}')">查看原因
                                                                    </button>
                                                                    <button class="btn btn-success btn-sm pull-left"
                                                                            onclick="assign('{{$v->id}}')"
                                                                            data-toggle="modal"
                                                                            data-target=".bs-example-modal-lg">
                                                                        分派维修
                                                                    </button>
                                                                @elseif($v->status=='2')
                                                                    <button class="btn btn-success btn-sm pull-left"
                                                                            onclick="assign('{{$v->id}}')"
                                                                            data-toggle="modal"
                                                                            data-target=".bs-example-modal-lg">
                                                                        重新分派
                                                                    </button>
                                                                @elseif($v->status=='3')
                                                                    <span class="label label-primary">维修中</span>
                                                                @elseif($v->status=='5')
                                                                    <span class="label label-primary">待评价</span>
                                                                @elseif($v->status=='6')
                                                                    <span class="label label-success">已完成</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="page-header">{{ $data5->appends(['active'=>'success'])->links() }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $("document").ready(function () {
            $('.i-checks,#all1,#all2,#all3,#all4,#all5').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });

            function all(id) {
                $(id).on('ifChecked ifUnchecked', function (event) {
                    if (event.type == 'ifChecked') {
                        $(this).parents('thead').next('tbody').find('.i-checks').iCheck('check');
                    } else {
                        $(this).parents('thead').next('tbody').find('.i-checks').iCheck('uncheck');
                    }
                });
            }

            all("#all1");
            all("#all2");
            all("#all3");
            all("#all4");
            all("#all5");
        });

        function str(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" +
                message +
                "</div><div class='modal-footer'> <button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> </div>"
            return messages;
        }

        //批量分派
        function edit(obj) {
            if ($(obj).prev('table').find("tbody input[type='checkbox']:checked").length >= 1) {
                var arr = [];
                $(obj).prev('table').find("tbody input[type='checkbox']:checked").each(function () {

                    //判断
                    var id = $(this).val();
                    if (id != 'on') {
                        arr.push(id);
                    }
                });
                $.ajax({
                    type: "get",
                    url: '{{url('repair/create_repair/edit')}}/' + arr,

                    success: function (data) {
                        $(".modal-content").html(data);
                    }
                });

            } else {
                $(".modal-content").html(str("请选择数据"));
            }
        }

        function assign(id) {
            var url = '{{url("repair/create_repair/assign_worker/")}}/' + id;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function show(url) {
            $.ajax({
                "url": url,
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function change_status(sid) {
            var url = '{{url("repair/create_repair/change_status/")}}/' + sid;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function reason(id) {
            var url = '{{url("repair/create_repair/reason/")}}/' + id;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function success(cid) {
            var url = '{{url('repair/create_repair/success')}}/' + cid;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function batchSuccess(obj) {
            if ($(obj).prev('button').prev('table').find("tbody input[type='checkbox']:checked").length >= 1) {
                var arr = [];
                $(obj).prev('button').prev('table').find("tbody input[type='checkbox']:checked").each(function () {
                    //判断
                    var id = $(this).val();
                    arr.push(id);
                });
                var url = '{{url('repair/create_repair/batch_success')}}/' + arr;
                $.ajax({
                    "url": url,
                    "type": 'get',
                    success: function (data) {
                        $(".bs-example-modal-lg .modal-content").html(data);
                    }
                })
            } else {
                $(".modal-content").html(str("请选择数据"));
            }
        }

    </script>
@endsection