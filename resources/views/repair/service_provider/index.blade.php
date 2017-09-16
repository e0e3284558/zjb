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
                  <a href="#advancedSearch" class="btn blue-sharp default" data-toggle="modal"
                     data-target="#advancedSearch"><i class="fa fa-search-plus"></i> 高级查询</a>
                  <a href="javascript:;" class="btn blue-madison" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>
                  </span>
                </div>
            </div>
        </div>


        <div class="row" id="create">


            @foreach($serviceProvider as $k=>$v)
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">移除</span>
                            <span class="label label-primary pull-right">编辑</span>
                            <span class="label label-success pull-right">详情</span>
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
