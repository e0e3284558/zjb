@extends("layouts.app")
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>

                <li>
                    <a href="javascript:;">资产管理</a>
                </li>

                <li class="active">
                    <strong>资产入库</strong>
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
                    <h5>
                        <h3 class="h3">
                            <a href="{{url('asset/create')}}" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa  fa-plus"></i> 增加</a>

                            <div class="dropdown inline">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-pencil"></i> 编辑
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="javascript:;" id="edit" onclick="edit()" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a></li>

                                    <li><a href="#" id="dlt" onclick="dlt()" >删除</a></li>
                                    <li class="line" style="border-bottom: solid 1px #ddd; margin: 4px;"></li>
                                    <li><a href="#" id="edit" data-bind="click:showCustomDialog">管理自定义属性</a></li>
                                </ul>
                            </div>
                        </h3>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">

                            <table style="min-width: 2200px" class="table table-striped  table-bordered" >
                                <thead>
                                    <tr role="row">
                                        <th><input type="checkbox" class="i-checks" name="checkAll" id="all" ></th>
                                        <th>资产条码</th>
                                        <th>图片</th>
                                        <th>资产名称</th>
                                        <th>资产类别</th>
                                        <th>规格型号</th>
                                        <th>SN号</th>
                                        <th>计量单位</th>
                                        <th>金额</th>
                                        <th>使用部门</th>
                                        <th>使用人</th>
                                        <th>区域</th>
                                        <th>管理员</th>
                                        <th>所属公司</th>
                                        <th>所属部门</th>
                                        <th>购入时间</th>
                                        <th>使用期限(月)</th>
                                        <th>来源</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $value)
                                        <tr role="row">
                                            <td role="gridcell">
                                                <input type="checkbox" class="i-checks" name="id" value="{{$value->id}}">
                                            </td>
                                            <td>{{$value->code}}</td>
                                            <td>
                                                @if($value->img_path)
                                                    <img onclick="show_img(this,'{{url('asset/show_img/'.$value->file_id)}}')" src="{{asset($value->img_path)}}" style="max-width: 30px;max-height: 30px;" data-toggle="modal" data-target=".bs-example-modal-md">
                                                @endif
                                            </td>
                                            <td><span class="color1" onclick="shows('{{$value->name}}','{{url('asset')}}/{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-lg" >{{$value->name}}</span></td>
                                            <td>{{$value->category_id}}</td>
                                            <td>{{$value->spec}}</td>
                                            <td>{{$value->SN_code}}</td>
                                            <td>{{$value->calculate}}</td>
                                            <td>{{$value->money}}</td>
                                            <td>{{$value->use_department_id}}</td>
                                            <td>{{$value->user_id}}</td>
                                            <td>{{$value->area_id}}</td>
                                            <td>{{$value->admin_id}}</td>
                                            <td>{{$value->org_id}}</td>
                                            <td>{{$value->department_id}}</td>
                                            <td>{{$value->buy_time}}</td>
                                            <td>{{$value->use_time}}</td>
                                            <td>{{$value->source_id}}</td>
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
                "<div class='modal-body'>" +
                message +
                "</div><div class='modal-footer'> <button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> <button type='submit' class='btn btn-primary'>保存</button></div>"
            return messages;
        }

        function edit() {
            if($("tbody input[type='checkbox']:checked").length == 1){

                var id = $("tbody input[type='checkbox']:checked").val();

                $.ajax({
                    url:'{{url('asset')}}/'+id+"/edit",
                    success:function (data) {
                        $(".modal-content").html(data);
                    }
                })

            }else if($("tbody input[type='checkbox']:checked").length == 0){
                $(".modal-content").html(str("请选择资产"));
            }else{
                $(".modal-content").html(str("每次只能修改一条资产"));
            }
        }

        function dlt() {
            if($("tbody input[type='checkbox']:checked").length >= 1){

                var arr = [];
                $("tbody input[type='checkbox']:checked").each(function() {
                    //判断
                    var id = $(this).val();
                    arr.push(id);
                });

                swal({
                        title: "确认要删除该资产吗？",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "是的, 确认删除!",
                        closeOnConfirm: false
                    },
                    function(){
                        //发异步删除数据
                        $.ajax({
                            type: "post",
                            url: '{{url('asset')}}'+'/'+arr,
                            data: {
                                "_token": '{{csrf_token()}}',
                                '_method': 'delete'
                            },
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
            }else if($("tbody input[type='checkbox']:checked").length == 0){
                $(".modal-content").html(str("请选择资产"));
            }
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
        /*加载添加视图*/

        function edits (url,status) {
            $.ajax({
                "url":url,
                success:function (data) {
                    $(".modal-content").html(data);
                }
            })
        }

        /*删除*/
        function del(obj,id,status){
            if(status!="闲置"){
                alert('此物品已经处在非闲置时期，不能进行删除!');
                return false;
            }

            swal({
                title: "确认要删除吗？",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "是的, 确认删除!",
                closeOnConfirm: false
            },
            function(){
                //发异步删除数据
                $.ajax({
                    type: "post",
                    url: '{{url('asset')}}'+'/'+id,
                    data: {
                        "_token": '{{csrf_token()}}',
                        '_method': 'delete'
                    },
                    dataType:"json",
                    success: function (data) {
                        if(data.code==1){
                            swal({
                                title: "",
                                text: data.message,
                                type: "success",
                                timer: 1000,
                            },function () {
                                $(obj).parents("tr").remove();
                                window.location.reload();
                            });
                        }else{
                            swal("", data.message, "error");
                        }
                    }
                });
            });
        }

    </script>

@endsection