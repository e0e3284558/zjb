@extends("layouts.app")
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
                    <strong>维修单列表</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
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
                                    <a href="{{url('repair/process?app_groups=repair&active=wait')}}" >待服务</a></li>
                                <li class="@if (request()->active=='result') active  @endif">
                                    <a href="{{url('repair/process?app_groups=repair&active=result')}}">维修中</a></li>
                                <li class="@if (request()->active=='end') active  @endif">
                                    <a href="{{url('repair/process?app_groups=repair&active=end')}}">已完成</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane @if (request()->active=='wait' || !request()->active) active  @endif" id="tab-1">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                <th>报修人</th>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                <th>维修单详情</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list1 as $v)
                                                <tr>
                                                    <td role="gridcell">
                                                        <input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">
                                                    </td>
                                                    <td>{{$v->user_id?$v->user->name:""}}</td>
                                                    <td>{{@get_area($v->area_id)}}</td>
                                                    @if($v->classify && (!$v->asset_id))
                                                        <td>{{$v->classify->name}}(场地报修)</td>
                                                    @else
                                                        <td>{{$v->asset->name}}</td>
                                                    @endif
                                                    <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/process')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                    </td>

                                                    <td>
                                                        @if($v->status=="2")
                                                            <button class="btn btn-sm btn-primary" onclick="edit('{{$v->id}}')">
                                                                接单
                                                            </button>&nbsp;<button class="btn btn-sm btn-danger"
                                                                                   onclick="refuse('{{$v->id}}')"
                                                                                   data-toggle="modal" data-target=".bs-example-modal-lg">拒绝
                                                            </button>
                                                        @elseif($v->status=="3")
                                                            <button class="btn btn-primary" onclick="add('{{$v->id}}')"
                                                                    data-toggle="modal" data-target=".bs-example-modal-lg">
                                                                填写报修结果
                                                            </button>
                                                        @elseif($v->status=='5')
                                                            <span>待评价</span>
                                                        @elseif($v->status=='6')
                                                            <span>已完成</span>
                                                        @elseif($v->status=='7')
                                                            <span>已完成</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <button type="button" onclick="batch_edit(this)" class="btn btn-sm btn-primary">
                                            批量接单
                                        </button>
                                        <button type="button" onclick="batch_refuse(this)" class="btn btn-sm btn-danger"
                                                data-toggle="modal" data-target=".bs-example-modal-lg" >
                                            批量拒单
                                        </button>
                                    </div>
                                    <div class="page-header">{{ $list1->appends(['active' => 'wait'])->links() }}</div>
                                </div>
                                <div class="tab-pane @if (request()->active=='result') active  @endif" id="tab-2">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                <th>报修人</th>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                <th>维修单详情</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list2 as $v)
                                                <tr>
                                                    <td role="gridcell"><input type="checkbox" class="i-checks" name="id" value="{{$v->id}}"></td>
                                                    <td>{{$v->user_id?$v->user->name:""}}</td>
                                                    <td>{{@get_area($v->area_id)}}</td>
                                                    @if($v->classify && (!$v->asset_id))
                                                        <td>{{$v->classify->name}}(场地报修)</td>
                                                    @else
                                                        <td>{{$v->asset->name}}</td>
                                                    @endif

                                                    <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/process')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-lg"
                                                              title="详情">点击查看详情</span>
                                                    </td>

                                                    <td>
                                                        @if($v->status=="2")
                                                            <button class="btn btn-primary" onclick="edit('{{$v->id}}')">
                                                                接单
                                                            </button>&nbsp;<button class="btn btn-danger"
                                                                                   onclick="refuse('{{$v->id}}')">拒绝
                                                            </button>
                                                        @elseif($v->status=="3")
                                                            <button class="btn btn-primary" onclick="add('{{$v->id}}')"
                                                                    data-toggle="modal" data-target=".bs-example-modal-lg">
                                                                填写报修结果
                                                            </button>
                                                        @elseif($v->status=='5')
                                                            <span>待评价</span>
                                                        @elseif($v->status=='6')
                                                            <span>已完成</span>
                                                        @elseif($v->status=='7')
                                                            <span>已完成</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="page-header">{{ $list2->appends(['active' => 'result'])->links() }}</div>
                                </div>
                                <div class="tab-pane @if (request()->active=='end') active  @endif" id="tab-3">
                                    <div class="tab-pane" id="tab-3">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修项目</th>
                                                    <th width="18%">维修单详情</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list3 as $v)
                                                    <tr>
                                                        <td>{{$v->user_id?$v->user->name:""}}</td>
                                                        <td>{{@get_area($v->area_id)}}</td>

                                                        @if($v->classify_id && (!$v->asset_id))
                                                            <td>{{$v->classify->name}}</td>
                                                        @else
                                                            <td>{{$v->asset->name}}</td>
                                                        @endif
                                                        <td>
                                                            <span class="cursor_pointer"
                                                                  onclick="show('{{url('repair/process')}}/{{$v->id}}')"
                                                                  data-toggle="modal" data-target=".bs-example-modal-lg"
                                                                  title="详情">点击查看详情</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="page-header">{{ $list3->appends(['active' => 'end'])->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">

        $("document").ready(function () {
            $('.i-checks,#all1,#all2,#all3').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });

            function all(id) {
                $(id).on('ifChecked ifUnchecked', function(event){
                    if(event.type == 'ifChecked'){
                        $(this).parents('thead').next('tbody').find('.i-checks').iCheck('check');
                    }else{
                        $(this).parents('thead').next('tbody').find('.i-checks').iCheck('uncheck');
                    }
                });
            }
            all("#all1");
            all("#all2");
            all("#all3");
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

        function confirms(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" + message + "</div><div class='modal-footer'> " +
                "<button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> " +
                "<button type='submit' class='btn btn-primary'>保存</button></div>"
            return messages;
        }

        function edit(id) {
            swal({
                    title: "确认要接收此维修单吗？",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "取消",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                },
                function () {
                    $.ajax({
                        type: "get",
                        url: '{{url('repair/process')}}/' + id + '/edit',
                        dataType: "json",
                        success: function (data) {
                            if (data.code == 1) {
                                swal({
                                    title: "",
                                    text: data.message,
                                    type: "success",
                                    timer: 1000,
                                }, function () {
                                    window.location.reload();
                                });
                            } else {
                                swal("", data.message, "error");
                            }
                        }
                    });
                }
            );
        }

        function batch_edit(obj) {
            if($(obj).prev('table').find("tbody input[type='checkbox']:checked").length >= 1) {
                var arr = [];
                $(obj).prev('table').find("tbody input[type='checkbox']:checked").each(function () {

                    //判断
                    var id = $(this).val();
                    if (id != 'on') {
                        arr.push(id);
                    }
                });
                swal({
                        title: "确认要接收维修单吗？",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: "取消",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },
                    function () {
                        $.ajax({
                            type: "get",
                            url: '{{url('repair/process/batchEdit')}}/' + arr,
                            dataType: "json",
                            success: function (data) {
                                if (data.code == 1) {
                                    swal({
                                        title: "",
                                        text: data.message,
                                        type: "success",
                                        timer: 1000,
                                    }, function () {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("", data.message, "error");
                                }
                            }
                        });
                    }
                );
            }else{
                alert("请选择数据");
            }
        }


        function refuse(id) {
            $.ajax({
                type: "get",
                url: '{{url('repair/process/refuse')}}/' + id,
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            });
        }

        function batch_refuse(obj) {
            if($(obj).prev('button').prev('table').find("tbody input[type='checkbox']:checked").length >= 1) {
                var arr = [];
                $(obj).prev('button').prev('table').find("tbody input[type='checkbox']:checked").each(function () {

                    //判断
                    var id = $(this).val();
                    if (id != 'on') {
                        arr.push(id);
                    }
                });
                $.ajax({
                    type: "get",
                    url: '{{url('repair/process/refuse')}}/' + arr,
                    success: function (data) {
                        $(".bs-example-modal-lg .modal-content").html(data);
                    }
                });
            }else{
                alert("请选择数据");
            }
        }

        function add(id) {
            $.ajax({
                url: '{{url('repair/process/create')}}/' + id,
                type: "post",
                data: {},
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

    </script>

@endsection