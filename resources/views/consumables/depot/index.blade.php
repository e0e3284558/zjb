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
                    <a href="javascript:;">角色管理</a>
                </li>

                <li class="active">
                    <strong>角色列表</strong>
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
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>仓库列表</h5>
                    </div>
                    <div class="ibox-content">

                        <p class="m-b-lg">
                        </p>

                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                @foreach($data as $v)
                                    <li class="dd-item">
                                        <div class="dd-handle" title="{{$v->coding}}">
                                            {{$v->coding.'-------'.$v->name}}
                                            <span class="span-icon-right">
                                    <i class="fa fa-edit"
                                       onclick="edit('{{url('consumables/depot/'.$v->id.'/edit')}}')"></i>
                                    <i class="fa fa-times span-i-icon-right" onclick="del({{$v->id}})"></i></span>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" id="create">
                @include('consumables.depot.add')
            </div>
        </div>
    </div>
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

        /*修改*/
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
                    title: "确认要删除该仓库吗？",
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
                        url: '{{url('consumables/depot')}}/' + id,
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
