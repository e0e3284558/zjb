@extends("layouts.app")
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>
                <li>
                    <a href="javascript:;">合同管理</a>
                </li>
                <li class="active">
                    <strong>清单管理</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
<div class="fh-breadcrumb full-height-layout-on white-bg layui-table-no-border">
    <div class="table-tools p-sm p-tb-xs border-bottom bg-f2">
        <div class="row">
            <div class="col-sm-7">
                <a href="{{ url('bill/create') }}" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn blue " id="add-btn"><i class="fa fa-plus"></i> 添加</a>
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
    <table class="layui-table" lay-filter="data-user" lay-data="{id:'dataUser',height: 'full-194', url:'{{ url("bill") }}',page:true,limit:20,even:true,response:{countName: 'total'}}">
        <thead>
        <tr>
            <th lay-data="{fixed:'left',checkbox:true}"></th>
            <th lay-data="{field:'id', width:80, sort: true}">ID</th>
            <th lay-data="{field:'name', width:140, sort: true}">清单名称</th>
            <th lay-data="{field:'contract',templet: '#contractTpl', width:140, sort: true}">所属合同</th>
            <th lay-data="{field:'remarks', width:180, sort: true}">备注说明</th>
            <th lay-data="{field:'created_at', width:170, sort: true}">创建时间</th>
            <th lay-data="{field:'updated_at', width:170, sort: true}">更新时间</th>
            <th lay-data="{fixed:'right',width:210, align:'center', toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead>
    </table>
    <script type="text/html" id="contractTpl">
        @{{# if(d.contract){  }}
        @{{d.contract.name}}
        @{{# } }}
    </script>
    <script type="text/html" id="barDemo">
        <a class="btn blue btn-xs" lay-event="detail" data-toggle="modal" data-target=".bs-example-modal-lg">录入资产</a>
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
                        zjb.ajaxPostData('', '{{url("bill")}}/'+id, {
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
                        zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("bill")}}/'+curData.id+"/edit",{'id':curData.id},true);
                    }else if(event== 'show'){
                        zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("bill")}}/'+curData.id,{'id':curData.id},true);
                    }else if(event== 'detail'){
                        zjb.ajaxGetHtml($(".bs-example-modal-lg .modal-content"),'{{url("bill/create")}}/'+curData.id,{'id':curData.id},true);
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
    </script>
</div>
@endsection