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
                    <strong>待维修列表</strong>
                </li>
            </ol>
        </div>
    </div>

@endsection

@section('content')
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>待维修列表</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>报修人</th>
                                <th>资产</th>
                                <th>分类</th>
                                <th>照片</th>
                                <th>备注</th>
                                {{--<th>上次维修工</th>--}}
                                {{--<th>维修建议</th>--}}
                                <th>当前状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{$v->user->name}}</td>
                                    @if($v->other==1)
                                        @if($v->otherAsset)
                                            <td>{{$v->otherAsset->name}}</td>
                                        @endif
                                    @else
                                        <td>{{$v->asset->name}}</td>
                                    @endif

                                    @if($v->category)
                                        <td>{{$v->category->name}}</td>
                                    @else
                                        <td>通用报修</td>
                                    @endif

                                    @if(collect($v->img)->isEmpty())
                                        <td>用户未上传图片</td>
                                    @else
                                        <td>
                                            @foreach($v->img as $k=>$img)
                                                <?php
                                                if ($k > 3) break;
                                                ?>
                                                <img src='{{url("$img->path")}}' alt="" class="img-circle-b">
                                            @endforeach
                                        </td>
                                    @endif
                                    <td>{{$v->remarks}}</td>
                                    {{--<td>{{@$v->serviceWorker->name}}</td>--}}
                                    {{--<td>{{$v->suggest}}</td>--}}
                                    <td>
                                        @if($v->status==1)
                                            等待分派维修中
                                        @endif
                                        @if($v->status==20 ||$v->status==4)
                                            已分派维修工
                                        @endif
                                    </td>
                                    <td>
                                        @if($v->status==1 || $v->status==10 || $v->status==0)
                                            @if($v->status==1)
                                                <button class="btn btn-success btn-sm" onclick="assign('{{$v->id}}')"
                                                        data-toggle="modal" data-target=".bs-example-modal-lg">
                                                    分派维修
                                                </button>
                                            @endif
                                            @if($v->status==10)

                                                @if($v->appraisal)
                                                    <button class="btn btn-primary btn-sm">已评价</button>
                                                @else
                                                    <button class="btn btn-primary btn-sm">完成维修</button>
                                                @endif
                                            @endif
                                                @if($v->status==0)
                                                    <button class="btn btn-danger btn-sm">不可再修</button>
                                                    @endif
                                        @else
                                            <button class="btn btn-warning btn-sm"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg"
                                                    onclick="change_status({{$v->id}})">重新分派
                                            </button>
                                            <br>
                                            <button class="btn btn-info btn-sm" onclick="success({{$v->id}})">完成维修
                                            </button>
                                        @endif
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

    <script>
        function assign(id) {
            var url = '{{url("repair/create_repair/assign_worker/")}}/' + id;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function change_status(sid) {
            var url = '{{url("repair/create_repair/change_status/")}}/' + sid;
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function success(cid) {
            swal({
                    title: "确认要完成维修吗？",
                    text: "",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#00cc00",
                    cancelButtonText: "取消",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                },
                function () {
                    //发异步删除数据
                    $.ajax({
                        type: "post",
                        url: '{{url('repair/create_repair/success')}}/' + cid,
                        data: {
                            "_token": '{{csrf_token()}}'
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