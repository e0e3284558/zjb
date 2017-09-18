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
                <li>
                    <a href="{{ url('repair/service_provider') }}">服务商管理</a>
                </li>

                <li class="active">
                    <strong>服务商添加</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content wrapper-content2  ">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="m-b-md">
                            <a href="#" class="btn btn-white btn-xs pull-right" onclick="del({{$data->id}})">移除该服务商</a>
                            <a href="#" class="btn btn-white btn-xs pull-right"
                               onclick="edit({{$data->id}})">修改服务商信息</a>
                            <h2>{{$data->name}}</h2>
                        </div>
                        <dl class="dl-horizontal">
                            <dt>所属:</dt>
                            <dd>
                        <span class="label label-primary">
                            <?php
                            if ($data->org->toArray() !== []) {
                                foreach ($data->org as $v) {
                                    if ($v->pivot->status == 0) {
                                        echo '内部服务商';
                                    }
                                }
                            } else {
                                echo '外部服务商';
                            }
                            ?>
                        </span>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <dl class="dl-horizontal">
                            <dt>服务商负责人:</dt>
                            <dd>{{$data->user}}</dd>
                            <dt>服务商电话:</dt>
                            <dd>{{$data->tel}}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-7" id="cluster_info">
                        <dl class="dl-horizontal">
                            <dt>服务商成员:</dt>
                            <dd class="project-people">
                                @foreach($serviceWorker as $j)
                                    @if($j['upload_id'])
                                        {!! avatar_circle($j['upload_id'],'') !!}
                                    @else
                                        {!! avatar_circle(null,$j['name'] )!!}
                                    @endif
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <dl class="dl-horizontal">
                            <dt>好评率:</dt>
                            <dd>
                                <div class="progress m-b-sm">
                                    <div style="width: 97%;" class="progress-bar progress-bar-info"></div>
                                </div>
                                <small>综合好评率为 <strong>97%</strong></small>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-lg-12">
                        <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li class="@if (request()->active=='appraisal' || !request()->active) active  @endif"><a href="#tab-1" data-toggle="tab">客户评价</a></li>
                                        <li class="@if (request()->active=='record') active  @endif"><a href="#tab-2" data-toggle="tab">维修记录</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane @if (request()->active=='appraisal' || !request()->active) active  @endif" id="tab-1">
                                        @foreach($processProvider1 as $v)
                                            <div class="feed-activity-list">
                                                <div class="feed-element"  style="padding-top: 12px">
                                                    <div class="pull-left">
                                                        <a href="#" >
                                                            <img alt="image" class="img-circle"
                                                                 src="{{get_avatar($v->user_id)}}">
                                                        </a>
                                                        <span class="block" >{{$v->user->name}}</span>
                                                    </div>
                                                    <div class="media-body ">
                                                        @if($day=intval((time()-strtotime($v->updated_at))/(60*60*24)))
                                                            <small class="pull-right">{{$day}}天前</small>
                                                        @else
                                                            @if($hour=intval((time()-strtotime($v->updated_at))/(60*60)))
                                                                <small class="pull-right">{{$hour}}小时前</small>
                                                            @else
                                                                @if($minter=intval((time()-strtotime($v->updated_at))/(60)))
                                                                    <small class="pull-right">
                                                                        {{$minter}}分钟前
                                                                    </small>
                                                                @else
                                                                    刚刚
                                                                @endif
                                                            @endif
                                                        @endif
                                                        {{$v->appraisal?$v->appraisal:'用户暂未评价'}}
                                                    </div>
                                                    <div class="media-bottom pull-left" style="padding-top: 15px">
                                                        <small class="pull-right">
                                                            @for($i=0;$i< $v->score;$i++ )
                                                                <i class="fa fa-star"
                                                                   @if($v->score>3)
                                                                   style="color:#e8bd0d"
                                                                   @else
                                                                   style="color:#dbdfb0"
                                                                @endif"></i>
                                                            @endfor
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                            <div class="page-header">{{ $processProvider1->appends(['active' => 'appraisal'])->links() }}</div>

                                    </div>
                                    <div class="tab-pane @if (request()->active=='record') active  @endif" id="tab-2">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>当前状态</th>
                                                <th>报修人</th>
                                                <th>维修人员</th>
                                                <th>维修场地</th>
                                                <th>维修项目</th>
                                                <th>当前操作完成时间</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($processProvider2 as $v)
                                                <tr>
                                                    <td>
                                                        @switch($v->status)
                                                            @case(3)
                                                            <span class="label label-warning"><i
                                                                        class="fa fa-check"></i> 维修中</span>
                                                            @break
                                                            @case(5)
                                                            <span class="label label-success"><i
                                                                        class="fa fa-check"></i> 待评价</span>
                                                            @break
                                                            @case(6)
                                                            <span class="label label-primary" title="{{$v->appraisal}}"><i
                                                                        class="fa fa-check"></i> 已评价</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        {{get_username($v->user_id)}}
                                                    </td>
                                                    <td>
                                                        {{$v->serviceWorker->name}}
                                                    </td>
                                                    <td>
                                                        {{get_area($v->area_id)}}
                                                    </td>
                                                    @if($v->classify && (!$v->asset_id))
                                                        <td>{{$v->classify->name}}(场地报修)</td>
                                                    @else
                                                        @if($v->asset)
                                                            <td>{{$v->asset->name}}</td>
                                                        @endif
                                                    @endif
                                                    <td>
                                                        {{$v->updated_at}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="page-header">{{ $processProvider2->appends(['active' => 'record'])->links() }}</div>
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

        /*更新所选分类的维修人员*/
        function edit(id) {
            url = '{{url('repair/service_provider')}}/' + id + '/edit';
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#create").html(data);
                }
            })
        }

        /*删除*/
        function del(id) {

            swal({
                    title: "确认要移除该服务商吗？",
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
                        type: "post",
                        url: '{{url('repair/service_provider')}}/' + id,
                        data: {
                            "_token": '{{csrf_token()}}',
                            '_method': 'delete'
                        },
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
    </script>
@endsection