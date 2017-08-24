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
                    <strong>其他资产</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
    {{--其他资产 --}}
<div class="row" >
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <h3 class="h3">
                        <button type="button" onclick="adds('增加','{{url('other_asset/create')}}')" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                            <i class="fa  fa-plus"></i> 增加
                        </button>

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
                        <div class="dropdown inline">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sign-in"></i> 导入/导出
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="{{url('asset/ExcelTemplate')}}">下载导入模板</a></li>
                                <li><a href="javascript:;" onclick="add('批量导入资产','{{url('asset/addImport')}}','600','300')"  id="import" data-bind="click:showImportDialog">批量导入资产</a></li>
                                <li class="line" style="border-bottom: solid 1px #ddd; margin: 4px;"></li>
                                <li><a href="{{url('asset/export')}}" id="export" data-bind="click:exportAssetNpoi">导出资产</a></li>
                                <li><a href="###" data-bind="click:exportAssetLogs">导出资产及单据<i class="fa fa-download" style="margin-left: 10px;margin-right: 0px;color: #3c8dbc;"></i></a></li>
                            </ul>
                        </div>
                    </h3>
                </h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <table style="width: 1000px;" class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
                            <thead>
                                <tr role="row">
                                    <th><input type="checkbox" name="checkAll" id="all" ></th>
                                    <th>类别</th>
                                    <th>照片</th>
                                    <th>资产名称</th>
                                    <th>所属公司</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $k=>$v)
                                    <tr>
                                    <td><input type="checkbox" name="id" value="{{$v->id}}"></td>
                                    <td>{{$v->category_id}}</td>
                                    <td>
                                        @if($v->img_path)
                                            <img class="color1" src="{{$v->img_path}}" style="max-width: 30px;max-height: 30px;" onclick="show_img(this,'{{url('asset/showImg/'.$v->img)}}')" data-toggle="modal" data-target=".bs-example-modal-md">
                                        @endif
                                    </td>
                                    <td><span class="color1" onclick="show('{{$v->name}}','{{url('otherAsset')}}/{{$v->id}}')" data-toggle="modal" data-target=".bs-example-modal-lg" >{{$v->name}}</span></td>
                                    <td>{{$v->org_id}}</td>
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

        $("#all").click(function(){
            if(this.checked){
                $("table :checkbox").prop("checked", true);
            }else{
                $("table :checkbox").prop("checked", false);
            }
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
                    url:'{{url('other_asset')}}/'+id+"/edit",
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
                        title: "确认要删除此报修项资产？",
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
                            url: '{{url('other_asset')}}'+'/'+arr,
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

        function show(title,url) {
            $.ajax({
                "url":url,
                success:function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }
        /*加载添加视图*/
        function adds(title,url) {
            $.ajax({
                "url":url,
                "data":{},
                "type":"get",
                "dataType":"html",
                beforeSend:function () {
                    zjb.blockUI();
                },
                success:function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                },
                complete:function () {
                    zjb.unblockUI();
                },
            })
        }

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