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
                <div class="input-group">
                  <input type="text" id="search-text" placeholder="用户名、姓名、邮箱、电话" class="form-control"> 
                  <span class="input-group-btn"> 
                  <button type="button" class="btn blue" id="simple-search"><i class="fa fa-search"></i> 查询</button> 
                  <a href="#advancedSearch" class="btn blue-sharp default" data-toggle="modal" data-target="#advancedSearch"><i class="fa fa-search-plus"></i> 高级查询</a>
                  <a href="javascript:;" class="btn blue-madison" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>
                  </span>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-lg-12 m-b-sm">
               <div class="ibox ">
                    <div class="ibox-title">
                        <h5>服务商列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                <li>
                                    <button class="btn btn-primary"
                                            onclick="add('{{url("repair/service_provider/create")}}')">添加服务商
                                    </button>
                                </li>
                                @foreach($data as $v)
                                    <li class="dd-item" onclick="serviceProvider('{{$v['id']}}')">
                                        <div class="dd-handle" title="{{$v['comment']}}">
                                            @if($v['logo_id'])
                                                {!! img_circle($v['logo_id'],'') !!}
                                            @else
                                                {!! img_circle(null,$v['name']) !!}
                                            @endif
                                            {{$v['name']}}
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                
            </div> -->
 
            <div class="row" id="create">

                <!-- <div class="row gray-bg">

                    @foreach($data as $k=>$v)
                        <div class="ibox">
                            <div class="ibox-title  center-version " style="height: 80px">
                            <span class="pull-left">
                                @if($v['logo_id'])
                                    {!! img_circle($v['logo_id'],'') !!}
                                @else
                                    {!! img_circle(null,$v['name']) !!}
                                @endif
                            </span>
                                <h5 style="padding:15px 0 0 10px">{{$v['name']}}</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="team-members">
                                    <div class="form-group">
                                        维修成员
                                    </div>
                                    @if(isset($service_worker[$k]))
                                        @foreach($service_worker[$k] as $img)
                                            @foreach($img as $a)
                                                @if($a['upload_id']!==null)
                                                    {!! avatar_circle($a['upload_id'],'') !!}
                                                @else
                                                    {!! avatar_circle(null,$a['name'] )!!}
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                                {{--<h4>有关这支团队的信息</h4>--}}
                                {{--<p>--}}
                                    {{--{{$v['comment']}}--}}
                                {{--</p>--}}
                              {{--<div>--}}
                                    {{--<span>好评率</span>--}}
                                    {{--<div class="stat-percent">99%</div>--}}
                                    {{--<div class="progress progress-mini">--}}
                                        {{--<div style="width: 99%;" class="progress-bar"></div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="row  m-t-sm">--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<div class="font-bold">总维修次数</div>--}}
                                        {{--12--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<div class="font-bold">为本单位维修次数</div>--}}
                                        {{--5--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                            </div>
                        </div>

                    @endforeach
                </div> -->
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">编辑</span>
                                <h5>安徽这就办信息技术有限责任公司</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="team-members">
                                    {!! avatar_circle(null,'章' )!!}
                                    {!! avatar_circle(null,'刘' )!!}
                                    {!! avatar_circle(null,'里' )!!}
                                </div>
                                
                                <p>如果设置 false，则在切换分页时，不会出现加载条。该参数只适用于“异步数据请求”的方式（即设置了url的情况下</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">编辑</span>
                                <h5>安徽这就办信息技术有限责任公司</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="team-members">
                                    {!! avatar_circle(null,'章' )!!}
                                    {!! avatar_circle(null,'刘' )!!}
                                    {!! avatar_circle(null,'里' )!!}
                                </div>
                                
                                <p>如果设置 false，则在切换分页时，不会出现加载条。该参数只适用于“异步数据请求”的方式（即设置了url的情况下</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">编辑</span>
                                <h5>安徽这就办信息技术有限责任公司</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="team-members">
                                    {!! avatar_circle(null,'章' )!!}
                                    {!! avatar_circle(null,'刘' )!!}
                                    {!! avatar_circle(null,'里' )!!}
                                </div>
                                
                                <p>如果设置 false，则在切换分页时，不会出现加载条。该参数只适用于“异步数据请求”的方式（即设置了url的情况下</p>
                            </div>
                        </div>
                    </div>
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
            layer.confirm('确认要删除吗？', function () {
                //发异步删除数据
                $.post("{{url('repair/service_worker/')}}/" + id, {
                    '_method': 'delete',
                    '_token': "{{csrf_token()}}"
                }, function (data) {
                    if (data.status == 'success') {
                        layer.msg(data.message, {icon: 6});
                        window.location.reload();
                    } else {
                        layer.msg('删除失败', {icon: 5});
                    }
                });
            });
        }
    </script>
@endsection
