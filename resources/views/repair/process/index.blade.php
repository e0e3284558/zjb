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
                                <li class="active"><a href="#tab-1" data-toggle="tab">待服务</a></li>
                                <li class=""><a href="#tab-2" data-toggle="tab">待填写维修结果</a></li>
                                <li class=""><a href="#tab-3" data-toggle="tab">已结束工单</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                <th>报修人</th>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                <th>报修分类</th>
                                                <th>报修照片</th>
                                                <th>报修原因</th>
                                                <th>工单详情</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list1 as $v)
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                    <td>{{$v->user_id?$v->user->name:""}}</td>
                                                    <td>{{@get_area($v->area_id)}}</td>
                                                    @if($v->other==1)
                                                        @if($v->otherAsset)
                                                            <td>{{$v->otherAsset->name}}</td>
                                                        @endif
                                                    @else
                                                        <td>{{$v->asset->name}}</td>
                                                    @endif

                                                    @if($v->category)
                                                        <td>{{$v->category->name}}</td>
                                                    @else
                                                        <td>通用报修</td>
                                                    @endif

                                                    <td>
                                                        @if(!collect($v->img)->isEmpty())
                                                            <span class="cursor_pointer"
                                                                  onclick="showImg('{{url('repair/process/showImg')}}/{{$v->id}}')"
                                                                  data-toggle="modal" data-target=".bs-example-modal-md"
                                                                  title="详情">详情</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$v->remarks}}</td>

                                                    <td>
                                                        <span>点击查看详情</span>
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
                                                                    data-toggle="modal" data-target=".bs-example-modal-md">
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
                                        <button type="button" onclick="edit(this)" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                                            批量接单
                                        </button>
                                        <button type="button" onclick="edit(this)" class="btn btn-sm btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg">
                                            批量拒单
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                <th>报修人</th>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                <th>报修分类</th>
                                                <th>报修照片</th>
                                                <th>报修原因</th>
                                                <th>工单详情</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list2 as $v)
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                    <td>{{$v->user_id?$v->user->name:""}}</td>
                                                    <td>{{@get_area($v->area_id)}}</td>
                                                    @if($v->other==1)
                                                        @if($v->otherAsset)
                                                            <td>{{$v->otherAsset->name}}</td>
                                                        @endif
                                                    @else
                                                        <td>{{$v->asset->name}}</td>
                                                    @endif

                                                    @if($v->category)
                                                        <td>{{$v->category->name}}</td>
                                                    @else
                                                        <td>通用报修</td>
                                                    @endif

                                                    <td>
                                                        @if(!collect($v->img)->isEmpty())
                                                            <span class="cursor_pointer"
                                                                  onclick="showImg('{{url('repair/process/showImg')}}/{{$v->id}}')"
                                                                  data-toggle="modal" data-target=".bs-example-modal-md"
                                                                  title="详情">详情</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$v->remarks}}</td>

                                                    <td>
                                                        <span>点击查看详情</span>
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
                                                                    data-toggle="modal" data-target=".bs-example-modal-md">
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
                                        <button type="button" onclick="edit(this)" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                                            批量接单
                                        </button>
                                        <button type="button" onclick="edit(this)" class="btn btn-sm btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg">
                                            批量拒单
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-3">
                                    <div class="tab-pane" id="tab-1">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修项目</th>
                                                    <th>报修分类</th>
                                                    <th>报修照片</th>
                                                    <th>报修原因</th>
                                                    <th>当前维修人员</th>
                                                    <th width="18%">工单详情</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list3 as $v)
                                                    <tr>
                                                        <td>{{$v->user_id?$v->user->name:""}}</td>
                                                        <td>{{@get_area($v->area_id)}}</td>
                                                        @if($v->other==1)
                                                            @if($v->otherAsset)
                                                                <td>{{$v->otherAsset->name}}</td>
                                                            @endif
                                                        @else
                                                            <td>{{$v->asset->name}}</td>
                                                        @endif

                                                        @if($v->category)
                                                            <td>{{$v->category->name}}</td>
                                                        @else
                                                            <td>通用报修</td>
                                                        @endif

                                                        <td>
                                                            @if(!collect($v->img)->isEmpty())
                                                                <span class="cursor_pointer"
                                                                      onclick="showImg('{{url('repair/repair_list/showImg')}}/{{$v->id}}')"
                                                                      data-toggle="modal" data-target=".bs-example-modal-md"
                                                                      title="详情">详情</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$v->remarks}}</td>
                                                        <td>{{@get_area($v->area_id)}}</td>
                                                        <td>查看详情</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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

        function refuse(id) {
            swal({
                    title: "确认要拒绝此报修项吗？",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "取消",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                },
                function () {
                    //发异步删除数据
                    $.ajax({
                        type: "get",
                        url: '{{url('repair/process/refuse')}}/' + id,
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
                });
        }

        function add(id) {
            $.ajax({
                url: '{{url('repair/process/create')}}/' + id,
                type: "post",
                data: {},
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function showImg(url) {
            $.ajax({
                "url": url,
                "type":"get",
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

    </script>

@endsection