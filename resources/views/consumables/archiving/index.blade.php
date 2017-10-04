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
                    <strong>物品管理</strong>
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
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <h3 class="box-title">
                                <!-- Single button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        分类管理 <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li data-toggle="modal" data-target=".bs-example-modal-lg"
                                            onclick="add('新增顶级分类','{{url('consumables/classify/create')}}')">
                                            <a>新增顶级分类</a>
                                        </li>
                                        <li data-toggle="modal" data-target=".bs-example-modal-lg"
                                            onclick="add_id('新增下级分类','{{url('consumables/classify')}}')">
                                            <a>新增下级分类</a>
                                        </li>
                                        <li data-toggle="modal" data-target=".bs-example-modal-lg"
                                            onclick="edit('修改下级分类','{{url('consumables/classify/')}}')">
                                            <a>修改分类</a></li>
                                        <li onclick="del()"><a>删除分类</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a>导出分类</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target=".bs-example-modal-lg"
                                        onclick="add('新增物品','{{url('consumables/archiving/create')}}')">+
                                    新增物品
                                </button>

                                <button type="button" class="btn btn-default">导出Excel</button>
                            </h3>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-2 shadow table-bordered min-height ">
                                    <ul id="treeDemo" class="ztree"></ul>
                                </div>
                                <SCRIPT LANGUAGE="JavaScript">
                                    $(document).ready(function () {
                                        var id = 0;

                                        function zTreeOnClick(event, treeId, treeNode) {
                                            id = treeNode.id;
                                            tableReload({});
                                        }

                                        var zTreeObj;
                                        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
                                        var setting = {
                                            callback: {
                                                onClick: zTreeOnClick
                                            },
                                            data: {
                                                simpleData: {
                                                    enable: true,
                                                    idKey: "id",
                                                    pIdKey: "parent_id",
                                                    rootPId: 0
                                                }
                                            }
                                        };
                                        var treeNodes = {!! $data !!};

                                        $.fn.zTree.init($("#treeDemo"), setting, treeNodes);
                                    });
                                </SCRIPT>
                                <div class="col-sm-10">
                                    <table class="layui-table" lay-filter="data-user"
                                           lay-data="{id:'dataUser',height: 'full-194',
                                           url:'{{ route("goods.index") }}',page:true,limit:20,
                                           even:true,response:{countName: 'total'}}">
                                        <thead>
                                        <tr>
                                            <th lay-data="{fixed:'left',checkbox:true}"></th>
                                            <th lay-data="{field:'display', width:120, sort: true,templet: '#disable'}">
                                                是否禁用
                                            </th>
                                            <th lay-data="{field:'upload_id', width:120, sort: true,templet: '#img'}">
                                                图片
                                            </th>
                                            <th lay-data="{field:'coding', width:120, sort: true}">物品编码</th>
                                            <th lay-data="{field:'classify_id', width:120, sort: true}">所属分类</th>
                                            <th lay-data="{field:'barcode', width:120, sort: true}">物品条形码</th>
                                            <th lay-data="{field:'norm', width:120, sort: true}">规格型号</th>
                                            <th lay-data="{field:'unit', width:120, sort: true}">单元</th>
                                            <th lay-data="{field:'trademark', width:120, sort: true}">商标</th>
                                            <th lay-data="{field:'inventory_cap', width:120, sort: true}">安全库存上限</th>
                                            <th lay-data="{field:'inventory_lower', width:120, sort: true}">安全库存下限</th>
                                            <th lay-data="{fixed:'right',width:160, align:'center', toolbar: '#barDemo'}">
                                                操作
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <script type="text/html" id="barDemo">
                                        <a class="btn blue-madison btn-xs" lay-event="edit">编辑</a>
                                        <a class="btn red btn-xs" lay-event="del">删除</a>
                                    </script>
                                    <script type="text/html" id="disable">
                                        @{{#  if(d.disable == 1){ }}
                                        <label class="btn btn-sm btn-danger">禁用</label>
                                        @{{#  } else { }}
                                        <label class="btn btn-sm btn-primary">启用</label>
                                        @{{#  } }}
                                    </script>
                                    <script type="text/html" id="img">
                                        @{{#  if(d.upload_id){ }}
                                        @{{ d.upload_id }}
                                        @{{#  } }}
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var table;
        var curObj;
        var curTrObj;
        var curData;

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


        /*加载添加视图带ID*/
        function add_id(title, url) {
            url = url + '/' + id + '/createSub';
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#myModal").css("display", "block");
                    $(".modal-content").html(data);
                }
            })
        }
        $(document).ready(function () {
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
                        zjb.ajaxPostData('', '{{route("consumables.goods.destroy")}}', {
                            '_method':'DELETE',
                            'id':id
                        }, function(data, textStatus, xhr) {
                            console.log(table);
                            if(data.code){
                                if(obj){obj.del();}else{
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

            $('#operationModal').on('hidden.bs.modal', function () {
                $(this).find(".modal-content").html('');
                $(this).removeData();
            });
            layui.use(['laytpl', 'table'], function () {
                table = layui.table;
                table.on('checkbox(data-user)', function (obj) {
                    console.log(obj);
                });
            });
            table.on('tool(data-user)', function (obj) {
                curObj = obj;
                curData = obj.data; //获得当前行数据
                var event = obj.event; //获得 lay-event 对应的值
                curTrObj = obj.tr; //获得当前行 tr 的DOM对象
                if (event == 'edit') {
                    $("#operationModal").modal('show');
                    zjb.ajaxGetHtml($('#operationModal .modal-content'),
                        '{{url("consumables/goods/edit")}}', {'id': curData.id}, true);
                } else if (event == 'del') {
                    deleteUser(curData.id, curObj);
                }
            });
            $(".btn-edit").click(function () {
                var checkStatus = table.checkStatus('dataUser');
                if (checkStatus.data.length != 1) {
                    toastr.error('请选择一条要操作的数据', '警告');
                } else {
                    var data = checkStatus.data[0];
                    $("#operationModal").modal('show');
                    zjb.ajaxGetHtml($('#operationModal .modal-content'),
                        '{{url("users/groups/edit")}}', {'id': data.id}, true);
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
            var tableReload = function (query) {
                table.reload('dataUser', {
                    where: query
                });
            }
            $("#simple-search").click(function () {
                var searchText = $('#search-text').val();
                tableReload({
                    search: searchText
                });
            })
            $("#submitSearch").click(function () {
                var query = $("#searchForm").serializeJSON();
                $("#advancedSearch").modal('hide');
                tableReload(query);
            })
            $('#refreshTable').click(function () {
                tableReload({});
            })
        });
    </script>


@endsection
