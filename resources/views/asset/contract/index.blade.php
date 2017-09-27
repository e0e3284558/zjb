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
                    <strong>合同管理</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
    {{--合同管理--}}
{{--<div class="wrapper wrapper-content ">--}}
    {{--<div class="row" >--}}
        {{--<div class="col-lg-12">--}}
            {{--<div class="ibox float-e-margins">--}}
                {{--<div class="ibox-title">--}}
                    {{--<h5>合同列表列表</h5>--}}
                {{--</div>--}}
                {{--<div class="ibox-content">--}}
                    {{--<div class="table-tools">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<a href="{{url('contract/create')}}" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa  fa-plus"></i> 增加</a>--}}
                                {{--<button type="button" onclick="edit()" href="javascript:;" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">--}}
                                    {{--<i class="fa fa-pencil"></i> 修改--}}
                                {{--</button>--}}
                                {{--<button type="button" onclick="dlt()" href="javascript:;" class="btn btn-danger">--}}
                                    {{--<i class="fa  fa-trash-o"></i> 删除--}}
                                {{--</button>--}}
                                {{--<div class="dropdown inline">--}}
                                    {{--<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                        {{--<i class="fa fa-print"></i>更多操作--}}
                                        {{--<span class="caret"></span>--}}
                                    {{--</button>--}}
                                    {{--<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">--}}
                                        {{--<li><a class="btn btn-default" id="printBarcode download" href="{{url('asset/downloadModel')}}"><i class="fa fa-sign-in"></i> 下载模板</a></li>--}}
                                        {{--<li><a class="btn btn-default" id="print download" href="{{url('asset/add_import')}}" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-sign-in"></i> 资产导入</a></li>--}}
                                        {{--<li><a class="btn btn-default" id="print download" href="{{url('asset/export')}}"><i class="fa fa-sign-out"></i> 导出资产数据</a></li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<!-- 搜索 -->--}}
                                {{--<form action="{{url('asset')}}" method="get" id="forms" >--}}
                                    {{--<input type="hidden" name="app_groups" value="asset">--}}
                                    {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                                    {{--<div class="row m-b-xs m-t-xs">--}}
                                        {{--<div class="col-md-6" >--}}
                                            {{--<div class="form-group" >--}}
                                                {{--<select name="category_id" class="form-control select2">--}}
                                                    {{--<option value="">请选择资产类别查询</option>--}}
                                                    {{--@foreach($category_list as $k=>$v)--}}
                                                        {{--<option value="{{$v->id}}">{{$v->name}}</option>--}}
                                                    {{--@endforeach--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<div class="input-group">--}}
                                                {{--<input type="text" name="name" placeholder="按照资产名称查找" class="input-md form-control">--}}
                                                {{--<span class="input-group-btn">--}}
                                                    {{--<button  type="submit" class="btn btn-md btn-success"> 查找</button>--}}
                                                {{--</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="table-responsive">--}}
                        {{--<table  class="table table-striped  table-bordered"  lay-filter="asset-table">--}}
                            {{--<thead>--}}
                                {{--<tr role="row">--}}
                                    {{--<th><input type="checkbox" class="i-checks" name="checkAll" id="all" ></th>--}}
                                    {{--<th>合同名称</th>--}}
                                    {{--<th>甲方</th>--}}
                                    {{--<th>乙方</th>--}}
                                    {{--<th>丙方</th>--}}
                                    {{--<th>合同文件路径</th>--}}
                                    {{--<th>备注说明</th>--}}
                                    {{--<th>公司</th>--}}
                                {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                                {{--@if(count($list)>0)--}}
                                    {{--@foreach($list as $value)--}}
                                        {{--<tr role="row">--}}
                                            {{--<td role="gridcell">--}}
                                                {{--<input type="checkbox" class="i-checks" name="id" value="{{$value->id}}">--}}
                                            {{--</td>--}}
                                            {{--<td><span class="cursor_pointer" onclick="shows('{{$value->name}}','{{url('asset')}}/{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-lg" >{{$value->name}}</span></td>--}}
                                            {{--<td>{{$value->name}}</td>--}}
                                            {{--<td>{{$value->first_party}}</td>--}}
                                            {{--<td>{{$value->second_party}}</td>--}}
                                            {{--<td>{{$value->third_party}}</td>--}}
                                            {{--<td>{{$value->file->path}}</td>--}}
                                            {{--<td>{{$value->remarks}}</td>--}}
                                            {{--<td>{{$value->org->name}}</td>--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                                {{--@else--}}
                                    {{--<tr>--}}
                                        {{--<td colspan="8" style="text-align: center" >暂无数据</td>--}}
                                    {{--</tr>--}}
                                {{--@endif--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                    {{--{{ $list->links() }}--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div class="fh-breadcrumb full-height-layout-on white-bg layui-table-no-border">
    <div class="table-tools p-sm p-tb-xs border-bottom bg-f2">
        <div class="row">
            <div class="col-sm-7">
                <a href="{{ url('contract/create') }}" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn blue " id="add-btn"><i class="fa fa-plus"></i> 添加</a>
                <!-- <button class="btn blue-dark btn-edit"><i class="fa fa-edit"></i> 修改</button>  -->
                <button href="" class="btn red btn-delete">
                    <i class="fa fa-trash"></i> 删除
                </button>
            </div>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" id="search-text" placeholder="资产名称" class="form-control">
                    <span class="input-group-btn">
                          <button type="button" class="btn blue" id="simple-search"><i class="fa fa-search"></i> 查询</button>
                          <a href="#advancedSearch" class="btn blue-sharp default" data-toggle="modal" data-target="#advancedSearch"><i class="fa fa-search-plus"></i> 高级查询</a>
                          <a href="javascript:;" class="btn blue-madison" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>
                        </span>
                </div>
            </div>
        </div>
    </div>
    <table class="layui-table" lay-filter="data-user" lay-data="{id:'dataUser',height: 'full-194', url:'{{ url("contract") }}',page:true,limit:20,even:true,response:{countName: 'total'}}">
        <thead>
        <tr>
            <th lay-data="{fixed:'left',checkbox:true}"></th>
            <th lay-data="{field:'id', width:80, sort: true}">ID</th>
            <th lay-data="{field:'name', width:80, sort: true}">合同名称</th>
            <th lay-data="{field:'first_party', width:80, sort: true}">甲方</th>
            <th lay-data="{field:'second_party', width:180, sort: true}">乙方</th>
            <th lay-data="{field:'third_party', width:180, sort: true}">丙方</th>
            <th lay-data="{field:'file',templet: '#fileTpl', width:180, sort: true}">合同文件路径</th>
            <th lay-data="{field:'remarks', width:180, sort: true}">备注说明</th>
            <th lay-data="{field:'created_at', width:170, sort: true}">创建时间</th>
            <th lay-data="{field:'updated_at', width:170, sort: true}">更新时间</th>
            <th lay-data="{fixed:'right',width:200, align:'center', toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead>
    </table>
    <script type="text/html" id="fileTpl">
        @{{# if(d.file){  }}
        <a href=@{{ d.file.path }}>@{{d.file.old_name}}</a>
        @{{# } }}
    </script>
    <script type="text/html" id="barDemo">
        <a class="btn blue btn-xs" lay-event="detail" data-toggle="modal" data-target=".bs-example-modal-lg">添加清单</a>
        <a class="btn blue btn-xs" lay-event="show" data-toggle="modal" data-target=".bs-example-modal-lg">显示</a>
        <a class="btn blue-madison btn-xs" lay-event="edit" data-toggle="modal" data-target=".bs-example-modal-lg">编辑</a>
        <a class="btn red btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/javascript">
        var table;
        var curObj;
        var curTrObj;
        var curData;
        $(document).ready(function(){
            var deleteUser = function(id,obj){
                swal({
                        title: "确定要删除吗?",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText:'取消',
                        confirmButtonText: "确定",
                        showLoaderOnConfirm:true,
                        closeOnConfirm: false
                    },
                    function(){
                        // swal.close();
                        zjb.ajaxPostData('', '{{url("contract")}}/'+id, {
                            '_method':'DELETE',
                            'id':id
                        }, function(data, textStatus, xhr) {
                            console.log(table);
                            if(data.status){
                                // toastr.success(data.message);
                                if(obj){obj.del();}else{
                                    //刷新当前页面
                                    $(".layui-laypage-btn")[0].click();
                                }
                                swal({
                                    title: data.message,
                                    text: "",
                                    type: 'success',
                                    timer: 1000,
                                    confirmButtonText: "确定"
                                });
                            }else{
                                swal({
                                    title: data.message,
                                    text: "",
                                    type: 'error',
                                    timer: 2000,
                                    confirmButtonText: "确定"
                                });
                                // toastr.error(data.message,'警告');
                            }
                        }, function(xhr, textStatus, errorThrown) {
                            if(xhr.status == 422 && textStatus =='error'){
                                _$error = xhr.responseJSON.errors;
                                $.each(_$error,function(i,v){
                                    toastr.error(v[0],'警告');
                                });
                            }else{
                                toastr.error('请求出错，稍后重试','警告');
                            }
                        });
                    });
            };
            // $('#operationModal').on('hidden.bs.modal', function () {
            //     $(this).find(".modal-content").html('');
            //     $(this).removeData();
            // });
            layui.use(['laytpl','table'], function(){
                table = layui.table;
                table.on('checkbox(data-user)', function(obj){

                });
                table.on('tool(data-user)', function(obj){
                    curObj = obj;
                    curData = obj.data; //获得当前行数据
                    var event = obj.event; //获得 lay-event 对应的值
                    curTrObj = obj.tr; //获得当前行 tr 的DOM对象
                    if(event == 'edit'){
//                            $("#operationModal").modal('show');
                        zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("contract")}}/'+curData.id+"/edit",{'id':curData.id},true);
                    }else if(event== 'show'){
                        zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("contract")}}/'+curData.id,{'id':curData.id},true);
                    }else if(event== 'detail'){
                        zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("contract/add_bill")}}/'+curData.id,{'id':curData.id},true);
                    }else if(event == 'del'){
                        deleteUser(curData.id,curObj);
                    }
                });
                $(".btn-edit").click(function(){
                    var checkStatus = table.checkStatus('dataUser');
                    if(checkStatus.data.length != 1){
                        toastr.error('请选择一条要操作的数据','警告');
                    }else{
                        var data = checkStatus.data[0];
//                            $("#operationModal").modal('show');
                        zjb.ajaxGetHtml($(".bs-example-modal-md .modal-content"),'{{url("contract")}}/'+data.id+"/edit",{'id':data.id},true);
                    }
                });

                $(".btn-delete").click(function(){
                    var checkStatus = table.checkStatus('dataUser');
                    if(checkStatus.data.length <= 0){
                        toastr.error('请选择要操作的数据','警告');
                    }else{
                        //获取所有选中的行的id
                        var ids  = [];
                        $.each(checkStatus.data,function(i,v){
                            ids.push(v.id);
                        });
                        // console.log(ids);
                        deleteUser(ids);
                    }
                });
                var tableReload = function(query){
                    table.reload('dataUser', {
                        where: query
                    });
                }
                $("#simple-search").click(function(){
                    var searchText = $('#search-text').val();
                    tableReload({
                        search:searchText
                    });
                })
                $("#submitSearch").click(function(){
                    var query = $("#searchForm").serializeJSON();
                    $("#advancedSearch").modal('hide');
                    tableReload(query);
                })
                $('#refreshTable').click(function(){
                    tableReload({});
                })
            });
        });
    </script>


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
            // layui.use('table', function(){
            //   var table = layui.table;
            //   table.init('asset-table', { //转化静态表格
            //   }); 
            // });
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

        function copy() {
            if($("tbody input[type='checkbox']:checked").length == 1){

                var id = $("tbody input[type='checkbox']:checked").val();
                $.ajax({
                    url:'{{url('asset/add_copy')}}'+"/"+id,
                    type:"get",
                    success:function (data) {
                        $(".modal-content").html(data);
                    }
                })

            }else if($("tbody input[type='checkbox']:checked").length == 0){
                $(".modal-content").html(str("请选择要复制的资产"));
            }else{
                $(".modal-content").html(str("每次只能复制一条资产"));
            }
        }

        function edit() {
            if($("tbody input[type='checkbox']:checked").length == 1){

                var id = $("tbody input[type='checkbox']:checked").val();

                $.ajax({
                    url:'{{url('contract')}}/'+id+"/edit",
                    success:function (data) {
                        $(".modal-content").html(data);
                    }
                })

            }else if($("tbody input[type='checkbox']:checked").length == 0){
                $(".modal-content").html(str("请选择数据"));
            }else{
                $(".modal-content").html(str("每次只能修改一条数据"));
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
                        cancelButtonText: "取消",
                        confirmButtonText: "确认",
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

    </script>
</div>
@endsection