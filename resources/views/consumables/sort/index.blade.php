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
                    <a href="javascript:;">耗材管理</a>
                </li>

                <li class="active">
                    <strong>物品分类</strong>
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
            <div class="col-lg-12">
                <div class="box-header">
                    <h3 class="box-title">
                        <button type="button" class="btn btn-success"
                                onclick="add('新增一个分类','{{url('consumables/sort/create')}}')"
                                data-toggle="modal" data-target=".bs-example-modal-lg">+ 新增顶级分类
                        </button>

                        <button type="button" class="btn btn-default">导出Excel</button>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">

                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending"
                                            style="width: 181px;">分类名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Browser: activate to sort column ascending"
                                            style="width: 223px;">
                                            上级分类
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 197px;">
                                            操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $v)
                                        <tr role="row" class="odd">
                                            <td class="">{{$v->name}}</td>
                                            <td>{{getCateNameByCateId($v->parent_id)}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target=".bs-example-modal-lg"
                                                        onclick="add('新增一个子类','{{url('consumables/sort/'.$v->id.'/createSub')}}')">
                                                    添加下级分类
                                                </button>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target=".bs-example-modal-lg"
                                                        onclick="add('修改分类信息','{{url('consumables/sort/'.$v->id.'/edit')}}')">
                                                    编辑
                                                </button>
                                                <button type="button" class="btn btn-warning"
                                                        onclick="del(this,'{{$v->id}}')">
                                                    删除
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">显示 1 到
                                    10
                                    共 57 总条数
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {{--{{ $data->links() }}--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <script type="text/javascript">
        /*加载添加视图*/
        function add(title, url) {
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#myModal").css("display", "block");
                    $(".modal-content").html(data);
                }
            })
        }

        /*删除*/
        function del(obj, id) {
            swal({
                    title: "确认要删除吗？",
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
                        url: "{{url('consumables/sort/')}}/" + id,
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
