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
                    <strong>报修分类管理</strong>
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
                        <h5>分类列表</h5>
                    </div>
                    <div class="ibox-content">

                        <p class="m-b-lg">
                        </p>

                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                @foreach($data as $v)
                                    <li class="dd-item">
                                        <div class="dd-handle" title="{{$v->comment}}">
                                            <span class="label label-info"><i
                                                        class="{{$v->icon}}"></i></span>{{$v->name}}
                                            <span class="span-icon-right">
                                    <i class="fa fa-edit"
                                       onclick="edit('{{url('repair/classify/'.$v->id.'/edit')}}')"></i>
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
                @include('repair.classify.add')
            </div>
        </div>
    </div>
    <script>
        /*字段验证*/
        $(document).ready(function () {
            $(".form-horizontal").validate(
                {
                    submitHandler: function () {
                        return true;
                    }
                }
            );

        });


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
            layer.confirm('确认要删除吗？', function () {
                //发异步删除数据
                $.post("{{url('repair/classify/')}}/" + id, {
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