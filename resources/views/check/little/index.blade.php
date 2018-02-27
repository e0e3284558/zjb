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
                    <a href="javascript:;">检查管理</a>
                </li>

                <li class="active">
                    <strong>点检管理</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection

@section('content')
    <div class="modal" id="operationModal" role="dialog" aria-labelledby="operationModalLabel">
        <div class="modal-dialog modal-md  animated bounceInDown" aria-hidden="true" role="document">
            <div class="modal-content">
                <div class="progress m-b-none">
                    <div class="progress-bar progress-bar-info progress-bar-striped active"
                         role="progressbar" aria-valuenow="100" aria-valuemin="0"
                         aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    <label class="control-label col-md-3">资产分类</label>
                                    <div class="col-md-9">
                                        <input type="text" value="" name="username" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">资产名</label>
                                    <div class="col-md-9">
                                        <input type="text" value="" name="name" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">资产位置</label>
                                    <div class="col-md-9">
                                        <input type="text" value="" name="tel" minlength="11" maxlength="11" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">资产购入时间</label>
                                    <div class="col-md-9">
                                        <input type="email" value="" name="email" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">
                                        部门
                                    </label>
                                    <div class="col-md-9">
                                        <select name="department_id" class="form-control select2">
                                            {!! department_select('',1) !!}
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
                    <a href="{{ route('users.create') }}" data-toggle="modal" data-target="#operationModal"
                       class="btn blue " id="add-btn"><i class="fa fa-plus"></i> 添加</a>
                    <!-- <button class="btn blue-dark btn-edit"><i class="fa fa-edit"></i> 修改</button>  -->
                    <button href="" class="btn red btn-delete">
                        <i class="fa fa-trash"></i> 删除</button>
                </div>
                <div class="col-sm-5">
                    <div class="input-group">
                        <input type="text" id="search-text" placeholder="用户名、姓名、邮箱、电话" class="form-control">
                        <span class="input-group-btn">
          <button type="button" class="btn blue" id="simple-search"><i class="fa fa-search"></i> 查询</button>
          <a href="#advancedSearch" class="btn blue-sharp default" data-toggle="modal" data-target="#advancedSearch"><i class="fa fa-search-plus"></i> 高级查询</a>
          <a href="javascript:;" class="btn blue-madison" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>
          </span>
                    </div>
                </div>
            </div>
        </div>
        <table class="layui-table" lay-filter="data-user" lay-data="{id:'dataUser',height: 'full-194', url:'{{ route("users.index") }}',page:true,limit:20,even:true,response:{countName: 'total'}}">
            <thead>
            <tr>
                <th lay-data="{fixed:'left',checkbox:true}"></th>
                <th lay-data="{field:'id', width:80, sort: true}">ID</th>
                <th lay-data="{field:'username', width:180, sort: true}">用户名</th>
                <th lay-data="{field:'name', width:80, sort: true}">姓名</th>
                <th lay-data="{field:'email', width:180, sort: true}">邮箱</th>
                <th lay-data="{field:'tel', width:180, sort: true}">手机号</th>
                <th lay-data="{field:'department',templet: '#departmentTpl', width:180, sort: true}">所属部门</th>
                <th lay-data="{field:'created_at', width:170, sort: true}">创建时间</th>
                <th lay-data="{field:'updated_at', width:170, sort: true}">更新时间</th>
                <th lay-data="{fixed:'right',width:160, align:'center', toolbar: '#barDemo'}">操作</th>
            </tr>
            </thead>
        </table>
        <script type="text/html" id="departmentTpl">
            @{{# if(d.department){  }}
            @{{d.department.name}}
            @{{# } }}
        </script>
        <script type="text/html" id="barDemo">
            <!-- <a class="btn blue btn-xs" lay-event="detail">查看</a> -->
            <a class="btn blue-madison btn-xs" lay-event="edit">编辑</a>
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
                            zjb.ajaxPostData('', '{{route("users.destroy")}}', {
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
                            $("#operationModal").modal('show');
                            zjb.ajaxGetHtml($('#operationModal .modal-content'),'{{url("users/default/edit")}}',{'id':curData.id},true);
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
                            $("#operationModal").modal('show');
                            zjb.ajaxGetHtml($('#operationModal .modal-content'),'{{url("users/default/edit")}}',{'id':data.id},true);
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
    </div>
@endsection
