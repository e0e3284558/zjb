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
                    <strong>维修工管理</strong>
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
                        <h5>分类列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                <li >
                                    <button class="btn btn-primary" onclick="add('{{url("repair/service_worker/create")}}')">添加维修工</button>
                                </li>
                                @foreach($data as $v)
                                    <li class="dd-item" onclick="serviceWorker('{{$v->id}}')">
                                        <div class="dd-handle" title="{{$v->comment}}">
                                            <span class="label label-info"><i class="{{$v->icon}}"></i></span>
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
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>维修工列表</h5>
                    </div>
                    <div class="ibox-content">
                        <p class="m-b-lg text-center">
                            维修人员信息
                            @if (count($errors) > 0)
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        @foreach ($errors->all() as $error)
                                        toastr.error('{{$error}}');
                                        @endforeach
                                    });
                                </script>
                            @endif

                            @if (session('success'))
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        toastr.success('{{session('success') }}');
                                    });
                                </script>
                            @endif
                            @if (session('error'))
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        toastr.warning('{{session('error') }}');
                                    });
                                </script>
                            @endif
                            <br>

                        </p>

                        <div class="dd" id="nestable2">
                            <div class="row gray-bg">
                                <p></p>
                                @foreach($serviceWorker as $v)
                                    <div class="col-lg-4">
                                        <div class="contact-box center-version">

                                            <a href="profile.html">

                                                @if($v->upload_id)
                                                    <img alt="image" class="img-circle m-t-xs img-responsive" src="">
                                                @else
                                                    <button class="btn btn-circle btn-lg {{randomClass()}}"
                                                            type="button">{{mb_substr($v->name,0,1)}}</button>
                                                @endif

                                                <h3 class="m-b-xs"><strong>{{$v-> name}}</strong></h3>

                                                <address class="m-t-md">
                                                    <strong><i class="fa fa-phone"></i> {{$v-> tel}}</strong><br>
                                                    <p><i class="fa fa-map-marker"></i> 安徽省芜湖市弋江区</p>
                                                </address>

                                            </a>
                                            <div class="contact-box-footer">
                                                <div class="m-t-xs btn-group">
                                                    <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> 发送短信 </a>
                                                    <a class="btn btn-xs btn-white" onclick="edit('{{url("repair/service_worker/$v->id/edit")}}')"><i class="fa fa-edit"></i> 编辑</a>
                                                    <a class="btn btn-xs btn-white" onclick="del('{{$v->id}}')"><i class="fa fa-mail-forward"></i> 移除</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
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
    /*编辑*/
    function edit(url) {
        $.ajax({
            "url": url,
            "type": 'get',
            success: function (data) {
                $("#create").html(data);
            }
        })
    }


    /*更新所选分类的维修工*/
    function serviceWorker(id) {
        url='{{url('repair/service_worker')}}/'+id;
        $.ajax({
            "url": url,
            "type": 'get',
            success: function (data) {
                $("#create").html(data);
            }
        })
    }
</script>