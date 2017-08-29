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
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
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
                                    <li class="dd-item" onclick="serviceProvider('{{$v->id}}')">
                                        <div class="dd-handle" title="{{$v->comment}}">
                                            <img alt="member" class="img-circle-a" src="/img/a1.jpg">
                                            {{$v->name}}
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" id="create">

                <div class="row gray-bg">

                    {{--@foreach($serviceWorker as $v)--}}

                    <div class="ibox">
                        <div class="ibox-title  center-version " style="height: 80px">
                            <span class="pull-left">
                                <a><img class=" img-circle-a" src="/img/a1.jpg"></a>
                            </span>
                            <h5 style="padding:15px 0 0 10px">安徽这就办信息技术有限责任公司</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="/img/a1.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="/img/a2.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="/img/a3.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="/img/a5.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="/img/a6.jpg"></a>
                            </div>
                            <h4>有关这支团队的信息</h4>
                            <p>
                                安徽这就办信息技术有限责任公司，这就办也是公司主 要的企业文化，秉承服务至上的原则，公司名称突出了客户对维修服务的要 求，也代表公司的服务理念。
                            </p>
                            <div>
                                <span>好评率</span>
                                <div class="stat-percent">48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 99%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">总维修次数</div>
                                    12
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">为本单位维修次数</div>
                                    4th
                                </div>

                            </div>

                        </div>
                    </div>

                    {{--@endforeach--}}
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


        /*更新所选分类的维修工*/
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
