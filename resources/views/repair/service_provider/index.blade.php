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
                    <strong>服务商管理</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section('content')
    <div class="wrapper wrapper-content wrapper-content2  ">

        <div class="row m-b-sm">
            <div class="col-md-7">
                <div class="tools">
                    <a class="btn blue"
                       href="{{url("repair/service_provider/create")}}">添加服务商
                    </a>
                </div>
            </div>
            <div class="col-md-5">
                {{--<div class="input-group">--}}
                    {{--<input type="text" id="search-text" placeholder="用户名、姓名、邮箱、电话" class="form-control">--}}
                    {{--<span class="input-group-btn">--}}
                  {{--<button type="button" class="btn blue" id="simple-search"><i class="fa fa-search"></i> 查询</button> --}}
                  {{--<a href="#advancedSearch" class="btn blue-sharp default" data-toggle="modal"--}}
                     {{--data-target="#advancedSearch"><i class="fa fa-search-plus"></i> 高级查询</a>--}}
                  {{--<a href="javascript:;" class="btn blue-madison" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>--}}
                  {{--</span>--}}
                {{--</div>--}}
            </div>
        </div>


        <div class="row" id="create">


            @foreach($serviceProvider as $k=>$v)
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right" onclick="del('{{$v->id}}')">移除</span>
                            <a href="{{url('repair/service_provider'.'/'.$v->id.'/edit')}}">
                                <span class="label label-primary pull-right">编辑</span>
                            </a>
                            <a href="{{url('repair/service_provider'.'/'.$v->id)}}">
                                <span class="label label-success pull-right">详情</span></a>
                            <h5>{{$v->name}}</h5>
                        </div>
                        <div class="ibox-content h-150">
                            <div class="team-members h-x-50">
                                @if((!$v->service_worker->isEmpty()))
                                    @foreach($v->service_worker as $k=>$img)
                                        @if($k>10)
                                            @break
                                        @endif
                                        @if($img->upload_id)
                                            {!! avatar_circle($img->upload_id,'') !!}
                                        @else
                                            {!! avatar_circle(null,$img->name )!!}
                                        @endif
                                    @endforeach
                                @else
                                    <strong>
                                        暂无维修人员，请联系服务商添加
                                    </strong>
                                @endif
                            </div>
                            <div class="h-x-50">
                                @if(strlen($v['comment'])>120)
                                    <p>{{mb_substr($v['comment'],0,120)}}...</p>
                                @else
                                    <p>{{$v['comment']}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>

    <script type="text/javascript">
        /*创建*/
        function add(url) {
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#create").html(data);
                }
            })
        }


        /*更新所选分类的维修人员*/
        function serviceProvider(id) {
            url = '{{url('repair/service_provider')}}/' + id;
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
                }
            );
        }
    </script>
@endsection
