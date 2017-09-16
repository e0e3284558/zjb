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
                                <li class="active"><a href="#tab-1" data-toggle="tab">等待派工</a></li>
                                <li class=""><a href="#tab-2" data-toggle="tab">正在维修</a></li>
                                <li class=""><a href="#tab-3" data-toggle="tab">维修完成</a></li>
                                <li class=""><a href="#tab-4" data-toggle="tab">待评价</a></li>
                                <li class=""><a href="#tab-5" data-toggle="tab">全部维修</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="checkAll" id="all1" ></th>
                                                <th>状态</th>
                                                <th>报修人</th>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                <th>报修分类</th>
                                                <th>报修照片</th>
                                                <th>报修备注</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data1 as $v)
                                                <tr>
                                                    <td role="gridcell">
                                                        <input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">
                                                    </td>
                                                    <td>
                                                        @if($v->status=='1' || $v->status=='4' || $v->status=='7')
                                                            <span class="label label-info" >待分派</span>
                                                        @endif
                                                    </td>
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

                                                    <td>
                                                        @if($v->status=='4' || $v->status=='7')
                                                            <button class="btn btn-danger btn-sm pull-left" data-toggle="modal"
                                                                    data-target=".bs-example-modal-md"
                                                                    onclick="reason('{{$v->id}}')">查看原因</button>
                                                        @endif
                                                        <button class="btn btn-success btn-sm pull-left"
                                                                onclick="assign('{{$v->id}}')"
                                                                data-toggle="modal"
                                                                data-target=".bs-example-modal-lg">
                                                            分派维修
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <button type="button" onclick="edit(this)" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                                            批量分派
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <div class="tab-pane" id="tab-1">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll" id="all2" ></th>
                                                    <th>状态</th>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修项目</th>
                                                    <th>报修分类</th>
                                                    <th>报修照片</th>
                                                    <th>报修备注</th>
                                                    <th>当前维修人员</th>
                                                    <th width="18%">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data2 as $v)
                                                    <tr>
                                                        <td role="gridcell">
                                                            <input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">
                                                        </td>
                                                        <td>
                                                            <span class="label label-warning" >维修中</span>
                                                        </td>
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
                                                        <td>{{$v->serviceWorker?$v->serviceWorker->name:""}}</td>

                                                        <td>
                                                            <button class="btn btn-warning btn-sm left"
                                                                    data-toggle="modal"
                                                                    data-target=".bs-example-modal-lg"
                                                                    onclick="change_status({{$v->id}})">重新分派
                                                            </button>

                                                            <button class="btn btn-info btn-sm left"
                                                                    data-toggle="modal"
                                                                    data-target=".bs-example-modal-md"
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
                                            <button type="button" onclick="batchSuccess(this)" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-md">
                                                批量完成
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-3">
                                    <div class="tab-pane" id="tab-1">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll" id="all3" ></th>
                                                    <th>状态</th>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修资产</th>
                                                    <th>报修分类</th>
                                                    <th>报修照片</th>
                                                    <th>报修备注</th>
                                                    <th>维修人员</th>
                                                    <th>服务商</th>
                                                    <th>评分</th>
                                                    <th>评价</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data3 as $v)
                                                    <tr>
                                                        <td role="gridcell">
                                                            <input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">
                                                        </td>
                                                        <td><span class="label label-success" >已完成</span></td>
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
                                                        <td>{{$v->serviceWorker?$v->serviceWorker->name:""}}</td>
                                                        <td>{{$v->serviceProvider?$v->serviceProvider->name:""}}</td>
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
                                </div>
                                <div class="tab-pane" id="tab-4">
                                    <div class="tab-pane" id="tab-1">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll" id="all4" ></th>
                                                    <th>状态</th>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修项目</th>
                                                    <th>报修分类</th>
                                                    <th>报修照片</th>
                                                    <th>报修备注</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data4 as $v)
                                                    <tr>
                                                        <td role="gridcell">
                                                            <input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">
                                                        </td>
                                                        <td><span class="label label-warning" >待评价</span></td>
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
                                                        <td>
                                                            @if($v->status=='5')
                                                                <span class="label label-primary" >待评价</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-5">
                                    <div class="tab-pane" id="tab-1">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="checkAll" id="all5" ></th>
                                                    <th>状态</th>
                                                    <th>报修人</th>
                                                    <th>报修场地</th>
                                                    <th>报修项目</th>
                                                    <th>报修分类</th>
                                                    <th>报修照片</th>
                                                    <th>报修备注</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data5 as $v)
                                                    <tr>
                                                        <td role="gridcell">
                                                            <input type="checkbox" class="i-checks" name="id" value="{{$v->id}}">
                                                        </td>
                                                        <td>
                                                            @if($v->status=='1' || $v->status=='4' || $v->status=='7')
                                                                <span class="label label-info" >待分派</span>
                                                            @elseif($v->status=='2')
                                                                <span class="label label-primary" >待服务</span>
                                                            @elseif($v->status=='3')
                                                                <span class="label label-warning" >维修中</span>
                                                            @elseif($v->status=='5')
                                                                <span class="label label-warning" >待评价</span>
                                                            @elseif($v->status=='6')
                                                                <span class="label label-success" >已完成</span>
                                                            @elseif($v->status=='0')
                                                                <span class="label label-default" >工单已取消</span>
                                                            @endif
                                                        </td>
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

                                                        <td>
                                                            @if($v->status=='1')
                                                                <button class="btn btn-success btn-sm pull-left"
                                                                        onclick="assign('{{$v->id}}')"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-lg">
                                                                    分派维修
                                                                </button>
                                                            @elseif($v->status=='4' || $v->status=='7')
                                                                <button class="btn btn-danger btn-sm pull-left" data-toggle="modal"
                                                                        data-target=".bs-example-modal-md"
                                                                        onclick="reason('{{$v->id}}')">查看原因</button>
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
                                                            @endif
                                                        </td>
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

    <script>
        $("document").ready(function () {
            $('.i-checks,#all1,#all2,#all3,#all4,#all5').iCheck({
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
            if($(obj).prev('table').find("tbody input[type='checkbox']:checked").length >= 1){
                var arr = [];
                $(obj).prev('table').find("tbody input[type='checkbox']:checked").each(function() {
                    //判断
                    var id = $(this).val();
                    arr.push(id);
                });
                $.ajax({
                    type: "get",
                    url: '{{url('repair/create_repair/edit')}}/'+arr,

                    success: function (data) {
                        $(".modal-content").html(data);
                    }
                });

            }else{
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

        function showImg(url) {
            $.ajax({
                "url": url,
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
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
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function success(cid) {
            var url = '{{url('repair/create_repair/success')}}/' + cid;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function batchSuccess(obj) {
            if($(obj).prev('button').prev('table').find("tbody input[type='checkbox']:checked").length >= 1){
                var arr = [];
                $(obj).prev('button').prev('table').find("tbody input[type='checkbox']:checked").each(function() {
                    //判断
                    var id = $(this).val();
                    arr.push(id);
                });
                var url = '{{url('repair/create_repair/batch_success')}}/' + arr;
                $.ajax({
                    "url": url,
                    "type": 'get',
                    success: function (data) {
                        $(".bs-example-modal-md .modal-content").html(data);
                    }
                })
            }else{
                $(".modal-content").html(str("请选择数据"));
            }
        }

    </script>
@endsection