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

    <div class="modal" id="advancedSearch" role="dialog" aria-labelledby="advancedSearchModalLabel">
        <div class="modal-dialog modal-md  animated bounceInDown" aria-hidden="true" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">高级查询</h4>
                </div>
                <div class="modal-body p-b-xs">
                    <form action="#" id="searchForm" class="form-horizontal " method="post" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">资产名称</label>
                                    <div class="col-md-8">
                                        <input type="text" value="" name="name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">资产编号</label>
                                    <div class="col-md-8">
                                        <input type="text" value="" name="code" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">资产类别</label>
                                    <div class="col-md-8">
                                        <select name="category_id" class="form-control select2">
                                            {!! category_select('',1) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">使用部门</label>
                                    <div class="col-md-8">
                                        <select name="use_department_id" class="form-control select2">
                                            {!! department_select('',1) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        所属部门
                                    </label>
                                    <div class="col-md-8">
                                        <select name="department_id" class="form-control select2">
                                            {!! department_select('',1) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                        供应商
                                    </label>
                                    <div class="col-md-8">
                                        <select name="supplier_id" class="form-control select2">
                                            {!! supplier_select('',1) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-success blue" id="submitSearch">查询</button>
                </div>
            </div>
        </div>
    </div>

    <div class="fh-breadcrumb full-height-layout-on white-bg layui-table-no-border">
        <div class="table-tools p-sm p-tb-xs border-bottom bg-f2">
            <div class="row">
                <div class="col-sm-7">
                    <a href="{{ url('asset/create') }}" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn blue " id="add-btn"><i class="fa fa-plus"></i> 添加</a>
                    <a href="{{url('asset/contract_create')}}" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn blue-dark"><i class="fa fa-edit"></i> 合同资产录入</a>
                    <button href="" class="btn red btn-delete">
                        <i class="fa fa-trash"></i> 删除
                    </button>
                    <div class="dropdown inline">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-print"></i>更多操作
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a class="btn btn-default" id="printBarcode download" href="{{url('asset/downloadModel')}}"><i class="fa fa-sign-in"></i> 下载模板</a></li>
                            <li><a class="btn btn-default" id="print download" href="{{url('asset/add_import')}}" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-sign-in"></i> 资产导入</a></li>
                            <li><a class="btn btn-default" id="print download" href="{{url('asset/export')}}"><i class="fa fa-sign-out"></i> 导出资产数据</a></li>
                            <li><a class="btn btn-default" id="print download" href="{{url('asset/export')}}"><i class="fa fa-sign-out"></i> 打印资产二维码</a></li>
                            <li><a class="btn btn-default" id="print download" href="{{url('asset/export')}}"><i class="fa fa-sign-out"></i> 批量打印资产二维码</a></li>
                        </ul>
                    </div>
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
        <table class="layui-table" lay-filter="data-user" lay-data="{id:'dataUser',height: 'full-194', url:'{{ url("asset") }}',page:true,limit:20,even:true,response:{countName: 'total'}}">
            <thead>
            <tr>
                <th lay-data="{fixed:'left',checkbox:true}"></th>
                <th lay-data="{field:'id', width:80, sort: true}">ID</th>
                <th lay-data="{field:'status', width:80, sort: true}">状态</th>
                <th lay-data="{field:'code', width:150, sort: true}">资产编号</th>
                <th lay-data="{field:'name', width:150, sort: true}">资产名称</th>
                <th lay-data="{field:'category',templet: '#categoryTpl', width:180, sort: true}">资产类别</th>
                <th lay-data="{field:'spec', width:140, sort: true}">规格型号</th>
                <th lay-data="{field:'calculate', width:80, sort: true}">计量单位</th>
                <th lay-data="{field:'money', width:80, sort: true}">金额(元)</th>
                <th lay-data="{field:'area',templet: '#areaTpl', width:180, sort: true}">所在场地</th>
                <th lay-data="{field:'buy_time', width:120, sort: true}">购入时间</th>
                <th lay-data="{field:'created_at', width:120, sort: true}">创建时间</th>
                <th lay-data="{field:'updated_at', width:120, sort: true}">更新时间</th>
                <th lay-data="{fixed:'right',width:190, align:'center', toolbar: '#barDemo'}">操作</th>
            </tr>
            </thead>
        </table>
        <script type="text/html" id="categoryTpl">
            @{{# if(d.category){  }}
                @{{d.category.name}}
            @{{# } }}
        </script>
        <script type="text/html" id="areaTpl">
            @{{# if(d.area){  }}
            @{{d.area.name}}
            @{{# } }}
        </script>
        <script type="text/html" id="barDemo">
            <a class="btn blue btn-xs" lay-event="detail" data-toggle="modal" data-target=".bs-example-modal-lg">查看</a>
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
                            zjb.ajaxPostData('', '{{url("asset")}}/'+id, {
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
                            zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("asset")}}/'+curData.id+"/edit",{'id':curData.id},true);
                        }else if(event== 'detail'){
                            zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("asset")}}/'+curData.id,{'id':curData.id},true);
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
                            zjb.ajaxGetHtml($(".bs-example-modal-md .modal-content"),'{{url("asset")}}/'+data.id+"/edit",{'id':data.id},true);
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
    </script>
</div>
@endsection