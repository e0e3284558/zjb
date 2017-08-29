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
                    <strong>其他报修项</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
    {{--其他资产 --}}
<div class="wrapper wrapper-content">
    <div class="row" >
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>
                        <a type="button" href="{{url('other_asset/create')}}" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">
                            <i class="fa  fa-plus"></i> 增加
                        </a>

                        {{--<div class="dropdown inline">--}}
                            {{--<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                {{--<i class="fa fa-pencil"></i> 编辑--}}
                                {{--<span class="caret"></span>--}}
                            {{--</button>--}}
                            {{--<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">--}}
                                {{--<li><a href="javascript:;" id="edit" onclick="edit()" data-toggle="modal" data-target=".bs-example-modal-lg">修改</a></li>--}}
                                {{--<li><a href="#" id="dlt" onclick="dlt()" >删除</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}

                        <button type="button" onclick="edit()" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">
                            <i class="fa  fa-wrench"></i> 修改
                        </button>

                        <button type="button" onclick="dlt()" class="btn btn-danger">
                            <i class="fa  fa-trash-o"></i> 删除
                        </button>

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

                </div>
                <div class="ibox-content">
                    <!-- 搜索 -->
                    <form action="{{url('other_asset')}}" method="get" id="forms" >
                        <input type="hidden" name="app_groups" value="asset">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="row m-b-xs m-t-xs">
                            <div class="col-md-6" ></div>
                            <div class="col-md-3" >
                                <div class="form-group" >
                                    <select name="category_id" class="form-control select2">
                                        <option value="">请选择查询</option>
                                        @foreach($category_list as $k=>$v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="name" placeholder="按照报修项名称查找" class="input-md form-control">
                                    <span class="input-group-btn">
                                        <button  type="submit" class="btn btn-md btn-success"> 查找</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <table style="width: 100%;" class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th><input type="checkbox" name="checkAll" id="all" ></th>
                                        <th>类别</th>
                                        <th>资产名称</th>
                                        <th>所属公司</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $k=>$v)
                                        <tr>
                                        <td><input type="checkbox" class="i-checks" name="id" value="{{$v->id}}"></td>
                                        <td>{{$v->category_id}}</td>
                                        <td><span class="cursor_pointer" href="{{url('other_asset')}}/{{$v->id}}" data-toggle="modal" data-target=".bs-example-modal-lg" >{{$v->name}}</span></td>
                                        <td>{{$v->org_id}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $list->links() }}
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
                "</div><div class='modal-footer'> <button type='button' class='btn btn-success ' data-dismiss='modal'>确定</button> </div>"
            return messages;
        }

        function confirms(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" +
                message +
                "</div><div class='modal-footer'> <button type='button' class='btn btn-success' data-dismiss='modal'>确定</button> <button type='submit' class='btn btn-primary'>保存</button></div>"
            return messages;
        }


        {{--function slt() {--}}
            {{--$.ajax({--}}
                {{--url:'{{url('other_asset')}}/slt',--}}
                {{--data:$('#forms').serialize(),--}}
                {{--type:"post",--}}
                {{--dataType:"",--}}
                {{--success:function (data) {--}}
                    {{--$(".modal-content").html(data);--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}

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
    </script>

@endsection