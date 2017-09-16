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
                    <strong>维修工列表</strong>
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
                        <h5>维修分类列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                <li>
                                    <button class="btn btn-primary"
                                            onclick="add('{{url("repair/service_worker/create")}}')">添加维修工
                                    </button>
                                </li>
                                <a href="{{url('repair/service_worker')}}">
                                    <li class="dd-item">
                                        <div class="dd-handle" title="{{Auth::user()->name}}下的所有维修人员">
                                            <span class="label label-info"><i class="fa fa-users"></i></span>
                                            所有维修人员
                                        </div>
                                    </li>
                                </a>
                                @foreach($data as $v)
                                    <li class="dd-item">
                                        <div class="dd-handle" title="{{$v->comment}}"
                                             onclick="serviceWorker('{{$v->id}}')">
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

                <div class="row gray-bg">
                    @if(isset($serviceWorker))
                        <?php $repeat = []; ?>
                        @foreach($serviceWorker as $a)
                            @foreach($a as $v)
                                <?php
                                if (in_array($v->id, $repeat)) {
                                    continue;
                                } else {
                                    $repeat[] = $v->id;
                                }

                                ?>
                                <div class="col-lg-4">
                                    <div class="contact-box center-version">

                                        <a href="profile.html">

                                            @if($v->upload_id!==null)
                                                <img alt="image" class="img-circle m-t-xs img-responsive center-block"
                                                     src="{{get_img_path($v->upload_id)}}">
                                            @else
                                                <button class="btn btn-circle btn-lg {{randomClass()}}"
                                                        type="button">{{mb_substr($v->name,0,1)}}</button>
                                            @endif

                                            <h3 class="m-b-xs"><strong>{{$v-> name}}</strong></h3>

                                            <address class="m-t-md">
                                                <strong><i class="fa fa-phone"></i> {{$v-> tel}}</strong><br>
                                                <p><i class="fa fa-map-marker"></i> {{@$v->service_provider[0]->name}}
                                                </p>
                                            </address>

                                        </a>
                                        <div class="contact-box-footer">
                                            <div class="m-t-xs btn-group">
                                                {{--<a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> 发送短信 </a>--}}

                                                <a class="btn btn-xs btn-white"
                                                   onclick="edit('{{url("repair/service_worker/$v->id/edit")}}')"><i
                                                            class="fa fa-edit"></i> 编辑</a>
                                                <a class="btn btn-xs btn-white" onclick="del('{{$v->id}}')"><i
                                                            class="fa fa-mail-forward"></i> 移除</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @endforeach
                    @endif
                </div>


            </div>
        </div>
    </div>

    <script type="text/javascript">

        /*更新所选分类的维修工*/
        function serviceWorker(id) {
            url = '{{url('repair/service_worker')}}/' + id;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#create").html(data);
                }
            })
        }

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


        /*删除*/
        function del(id) {

            swal({
                    title: "确认要删除该分类吗？",
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
                        url: '{{url('repair/service_worker')}}/' + id,
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
