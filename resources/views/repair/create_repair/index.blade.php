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
                                                    <td>{{$v->user->name}}</td>
                                                    <td>{{$v->area->name}}</td>
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
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-2">
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
                                                    <th>报修备注</th>
                                                    <th>当前维修人员</th>
                                                    <th width="18%">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data2 as $v)
                                                    <tr>
                                                        <td>{{$v->user->name}}</td>
                                                        <td>{{get_area($v->area_id)}}</td>
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
                                                        <td>{{get_area($v->area_id)}}</td>

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
                                        </div>
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
                                                        <td>{{$v->user->name}}</td>
                                                        <td>{{get_area($v->area_id)}}</td>
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
                                                        @if($v->serviceWorker)
                                                            <td>{{$v->serviceWorker->name}}</td>
                                                        @endif
                                                        @if($v->serviceProvider)
                                                            <td>{{$v->serviceProvider->name}}</td>
                                                        @endif

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
                                                        <td>{{$v->user->name}}</td>
                                                        <td>{{get_area($v->area_id)}}</td>
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
                                                        <td>
                                                            @if($v->status=='1' || $v->status=='4' || $v->status=='7')
                                                                <span class="label label-default" >待分派</span>
                                                            @elseif($v->status=='2')
                                                                <span class="label label-info" >待服务</span>
                                                            @elseif($v->status=='3')
                                                                <span class="label label-primary" >维修中</span>
                                                            @elseif($v->status=='5')
                                                                <span class="label label-primary" >待评价</span>
                                                            @elseif($v->status=='6')
                                                                <span class="label label-success" >已完成</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$v->user->name}}</td>
                                                        <td>{{get_area($v->area_id)}}</td>
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
                                                                <span class="label label-info" >待服务</span>
                                                            @elseif($v->status=='3')
                                                                <span class="label label-primary" >维修中</span>
                                                            @elseif($v->status=='5')
                                                                <span class="label label-primary" >待评价</span>
                                                            @elseif($v->status=='6')
                                                                <span class="label label-success" >已完成</span>
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
    </script>
@endsection