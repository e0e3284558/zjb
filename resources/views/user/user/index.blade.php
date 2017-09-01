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
                    <a href="javascript:;">用户管理</a>
                </li>

                <li class="active">
                    <strong>用户列表</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight" id="userList">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>用户列表 </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-5 m-b-xs">
                                <select class="form-control  inline" onchange="change(this.value)">
                                    {!! department_select('',1) !!}
                                </select>
                            </div>
                            <div class="col-sm-4 m-b-xs">
                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-sm btn-white"
                                           onclick="add('添加用户','{{route('users.create')}}')"
                                           data-toggle="modal" data-target=".bs-example-modal-lg">
                                        添加用户
                                    </label>
                                    <label class="btn btn-sm btn-white ">
                                        批量导入
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" placeholder="搜索" class="input-sm form-control" id="search">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"
                                                onclick="search()"> 搜索</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 240px;">用户名</th>
                                    <th style="width: 240px;">邮箱</th>
                                    <th style="width: 200px;">手机号</th>
                                    <th style="width: 280px;">所属部门</th>
                                    <th style="width: 240px;">创建时间</th>
                                    <th style="width: 180px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                    <tr>
                                        <td>{{$v->name}}</td>
                                        <td>{{$v->email}}</td>
                                        <td>{{$v->tel}}</td>
                                        <td>{{$v->department->name}}</td>
                                        <td>{{$v->created_at}}</td>
                                        <td>
                                            <button class="btn btn-primary"
                                                    onclick="edit('编辑用户信息','{{url("users/default/$v->id/edit")}}')"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg">编辑
                                            </button>
                                            <button class="btn btn-danger" onclick="del('{{$v->id}}')">删除</button>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').removeClass('full-height-layout');
        });

        //添加用户
        function add(title, url) {
            $.ajax({
                "url": url,
                "title": title,
                success: function (data) {
                    $(".modal-content").html(data);

                }
            })
        }

        //添加用户
        function search() {
            var v = $("#search").val();

            if (v != '') {
                $.ajax({
                    "url": '{{url('users/default/search')}}/' + v,
                    success: function (data) {
                        $("#userList").html(data);
                    }
                })
            } else {
                $.ajax({
                    "url": '{{url('users/default/*')}}',
                    success: function (data) {
                        $("#userList").html(data);
                        alert(1);
                    }
                })
            }

        }

        function change(id) {
            $.ajax({
                "url": '{{url('users/default')}}/' + id,
                success: function (data) {
                    $("#userList").html(data);
                }
            })
        }

        //修改用户
        function edit(title, url) {
            $.ajax({
                "url": url,
                "title": title,
                success: function (data) {
                    $(".modal-content").html(data);

                }
            })
        }

        //删除用户
        /*删除*/
        function del(id) {
            layer.confirm('确认要删除吗？', function () {
                //发异步删除数据
                $.post("{{url('users/default')}}/" + id, {
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