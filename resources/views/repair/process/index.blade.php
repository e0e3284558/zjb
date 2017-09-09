@extends("layouts.app")
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>
                <li>
                    <a href="javascript:;">报修管理</a>
                </li>
                <li class="active">
                    <strong>维修单列表</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
    {{--资产入库--}}
<div class="wrapper wrapper-content ">
    <div class="row" >
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table style="min-width: 1000px" class="table table-striped  table-bordered" >
                            <thead>
                                <tr role="row">
                                    {{--<th><input type="checkbox" class="i-checks" name="checkAll" id="all" ></th>--}}
                                    <th>操作</th>
                                    <th>公司</th>
                                    <th>报修人</th>
                                    <th>资产名称</th>
                                    <th>资产分类</th>
                                    <th>维修工id</th>
                                    <th>服务商id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $value)
                                    <tr role="row">
                                        {{--<td role="gridcell">--}}
                                            {{--<input type="checkbox" class="i-checks" name="id" value="{{$value->id}}">--}}
                                        {{--</td>--}}
                                        @if($value->status=="20")
                                            <td><button class="btn btn-primary" onclick="edit('{{$value->id}}')" >接单</button>&nbsp;<button class="btn btn-danger">拒绝</button></td>
                                        @elseif($value->status=="4")
                                            <td><button class="btn btn-primary" onclick="add('{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-md">填写报修结果</button></td>
                                        @elseif($value->status=='10')
                                            <td><span>已修好</span></td>
                                        @elseif($value->status=='0')
                                            <td><span>不可再修</span></td>
                                        @endif
                                        <td>{{$value->org->name}}</td>
                                        <td>{{$value->user->name}}</td>
                                        <td>{{$value->asset->name}}</td>
                                        <td>{{$value->category->name}}</td>
                                        <td>{{$value->serviceWorker->name}}</td>
                                        <td>{{@$value->serviceProvider->name}}</td>
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

    <script type="text/javascript" >

        $("document").ready(function () {
            $('.i-checks,#all').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });
            $('#all').on('ifChecked ifUnchecked', function(event){
                if(event.type == 'ifChecked'){
                    $('.i-checks').iCheck('check');
                }else{
                    $('.i-checks').iCheck('uncheck');
                }
            });
        });
        function str(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" +
                message +
                "</div><div class='modal-footer'> <button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> </div>"
            return messages;
        }

        function confirms(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" + message + "</div><div class='modal-footer'> " +
                "<button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> " +
                "<button type='submit' class='btn btn-primary'>保存</button></div>"
            return messages;
        }

        function edit(id) {
            swal({
                    title: "确认要接单吗？",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "取消",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                },
                function(){
                    //发异步删除数据
                    $.ajax({
                        type: "get",
                        url: '{{url('repair/process')}}/'+id+'/edit',
                        dataType:"json",
                        success: function (data) {
                            if(data.code==1){
                                swal({
                                    title: "",
                                    text: data.message,
                                    type: "success",
                                    timer: 1000,
                                },function () {
                                    window.location.reload();
                                });
                            }else{
                                swal("", data.message, "error");
                            }
                        }
                    });
                });
        }

        function add(id) {
            $.ajax({
                url:'{{url('repair/process/create')}}/'+id,
                type:"post",
                data:{},
                success:function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function show_img(object,url) {
            $.ajax({
                url:url,
                success:function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function shows(title,url) {
            $.ajax({
                "url":url,
                success:function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

    </script>

@endsection