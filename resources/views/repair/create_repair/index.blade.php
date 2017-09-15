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
                        <h5>维修列表</h5>
                    </div>


                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">等待派工</a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab">正在维修</a></li>
                                    <li class=""><a href="#tab-3" data-toggle="tab">维修完成</a></li>
                                    <li class=""><a href="#tab-4" data-toggle="tab">全部维修</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="ibox-content">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>报修人</th>
                                                <th>资产</th>
                                                <th>分类</th>
                                                <th>照片</th>
                                                <th>备注</th>
                                                <th>地址</th>
                                                {{--<th>上次维修工</th>--}}
                                                {{--<th>维修建议</th>--}}
                                                <th>当前状态</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data1 as $v)
                                                <tr>
                                                    <td>{{$v->user->name}}</td>
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

                                                    @if(collect($v->img)->isEmpty())
                                                        <td>用户未上传图片</td>
                                                    @else
                                                        <td>
                                                            @foreach($v->img as $k=>$img)
                                                                <?php
                                                                if ($k > 3) break;
                                                                ?>
                                                                <img src='{{url("$img->path")}}' alt=""
                                                                     class="img-circle-b">
                                                            @endforeach
                                                        </td>
                                                    @endif
                                                    <td>{{$v->remarks}}</td>
                                                    <td>{{get_area($v->area_id)}}</td>
                                                    <td>
                                                        @if($v->status==1)
                                                            等待分派维修中
                                                        @endif
                                                        @if($v->status==20 ||$v->status==4)
                                                            已分派维修工
                                                        @endif
                                                        @if($v->status==10)
                                                            已完成维修
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($v->status==1)
                                                            <button class="btn btn-success btn-sm pull-left"
                                                                    onclick="assign('{{$v->id}}')"
                                                                    data-toggle="modal"
                                                                    data-target=".bs-example-modal-lg">
                                                                分派维修
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>


                                <div class="tab-pane" id="tab-2">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>报修人</th>
                                                    <th>资产</th>
                                                    <th>分类</th>
                                                    <th>照片</th>
                                                    <th>备注</th>
                                                    <th>报修位置</th>
                                                    <th>当前状态</th>
                                                    <th width="18%">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data2 as $v)
                                                    <tr>
                                                        <td>{{$v->user->name}}</td>
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

                                                        @if(collect($v->img)->isEmpty())
                                                            <td>用户未上传图片</td>
                                                        @else
                                                            <td>
                                                                @foreach($v->img as $k=>$img)
                                                                    <?php
                                                                    if ($k > 3) break;
                                                                    ?>
                                                                    <img src='{{url("$img->path")}}' alt=""
                                                                         class="img-circle-b">
                                                                @endforeach
                                                            </td>
                                                        @endif
                                                        <td>{{$v->remarks}}</td>
                                                        <td>{{get_area($v->area_id)}}</td>
                                                        <td>
                                                            @if($v->status==1)
                                                                等待分派维修中
                                                            @endif
                                                            @if($v->status==20 ||$v->status==4)
                                                                已分派维修工:{{$v->serviceWorker->name}}
                                                            @endif
                                                            @if($v->status==10)
                                                                已完成维修:{{$v->serviceWorker->name}}
                                                            @endif
                                                        </td>
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
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>报修人</th>
                                                    <th>资产</th>
                                                    <th>分类</th>
                                                    <th>照片</th>
                                                    <th>备注</th>
                                                    <th>维修工</th>
                                                    <th>服务商</th>
                                                    <th>评分</th>
                                                    <th>评价</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data3 as $v)
                                                    <tr>
                                                        <td>{{$v->user->name}}</td>
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

                                                        @if(collect($v->img)->isEmpty())
                                                            <td>用户未上传图片</td>
                                                        @else
                                                            <td>
                                                                @foreach($v->img as $k=>$img)
                                                                    <?php
                                                                    if ($k > 3) break;
                                                                    ?>
                                                                    <img src='{{url("$img->path")}}' alt=""
                                                                         class="img-circle-b">
                                                                @endforeach
                                                            </td>
                                                        @endif
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
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>报修人</th>
                                                    <th>资产</th>
                                                    <th>分类</th>
                                                    <th>照片</th>
                                                    <th>备注</th>
                                                    {{--<th>上次维修工</th>--}}
                                                    {{--<th>维修建议</th>--}}
                                                    <th>当前状态</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data4 as $v)
                                                    <tr>
                                                        <td>{{$v->user->name}}</td>
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

                                                        @if(collect($v->img)->isEmpty())
                                                            <td>用户未上传图片</td>
                                                        @else
                                                            <td>
                                                                @foreach($v->img as $k=>$img)
                                                                    <?php
                                                                    if ($k > 3) break;
                                                                    ?>
                                                                    <img src='{{url("$img->path")}}' alt=""
                                                                         class="img-circle-b">
                                                                @endforeach
                                                            </td>
                                                        @endif
                                                        <td>{{$v->remarks}}</td>
                                                        {{--<td>{{@$v->serviceWorker->name}}</td>--}}
                                                        {{--<td>{{$v->suggest}}</td>--}}
                                                        <td>
                                                            @if($v->status==1)
                                                                等待分派维修中
                                                            @endif
                                                            @if($v->status==20 ||$v->status==4)
                                                                已分派维修工
                                                            @endif
                                                            @if($v->status==10)
                                                                已完成维修
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($v->status==1 || $v->status==10 || $v->status==0)
                                                                @if($v->status==1)
                                                                    <button class="btn btn-success btn-sm pull-left"
                                                                            onclick="assign('{{$v->id}}')"
                                                                            data-toggle="modal"
                                                                            data-target=".bs-example-modal-lg">
                                                                        分派维修
                                                                    </button>
                                                                @endif
                                                                @if($v->status==10)

                                                                    @if($v->appraisal)
                                                                        <button class="btn btn-primary btn-sm  pull-left">
                                                                            已评价
                                                                        </button>
                                                                    @else
                                                                        <button class="btn btn-primary btn-sm  pull-left">
                                                                            维修完成
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                @if($v->status==0)
                                                                    <label class="btn btn-danger btn-sm pull-left">不可再修</label>
                                                                @endif
                                                            @else

                                                                <button class="btn btn-warning btn-sm pull-left"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-lg"
                                                                        onclick="change_status({{$v->id}})">重新分派
                                                                </button>

                                                                <button class="btn btn-info btn-sm pull-left"
                                                                        onclick="success({{$v->id}})">
                                                                    完成维修
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