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
                    <strong>供应商管理</strong>
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
                <a href="{{ url('supplier/create') }}" data-toggle="modal" data-target=".bs-example-modal-md" class="btn blue " id="add-btn"><i class="fa fa-plus"></i> 添加</a>
                <!-- <button class="btn blue-dark btn-edit"><i class="fa fa-edit"></i> 修改</button>  -->
                <button href="" class="btn red btn-delete">
                    <i class="fa fa-trash"></i> 删除
                </button>
            </div>
            <div class="col-sm-5">
                <div class="input-group">
                    <input type="text" id="search-text" placeholder="供应商名称" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" class="btn blue" id="simple-search"><i class="fa fa-search"></i> 查询</button>
                      <a href="#advancedSearch" class="btn blue-sharp default" data-toggle="modal" data-target="#advancedSearch"><i class="fa fa-search-plus"></i> 高级查询</a>
                      <a href="javascript:;" class="btn blue-madison" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <table class="layui-table" lay-filter="data-user" lay-data="{id:'dataUser',height: 'full-194', url:'{{ url("supplier") }}',page:true,limit:20,even:true,response:{countName: 'total'}}">
        <thead>
        <tr>
            <th lay-data="{fixed:'left',checkbox:true}"></th>
            <th lay-data="{field:'id', width:80, sort: true}">ID</th>
            <th lay-data="{field:'name', width:80, sort: true}">名称</th>
            <th lay-data="{field:'category',templet: '#categoryTpl', width:180, sort: true}">类别</th>
            <th lay-data="{field:'remarks', width:180, sort: true}">备注</th>
            <th lay-data="{field:'created_at', width:170, sort: true}">创建时间</th>
            <th lay-data="{field:'updated_at', width:170, sort: true}">更新时间</th>
            <th lay-data="{fixed:'right',width:160, align:'center', toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead>
    </table>
    <script type="text/html" id="categoryTpl">
        @{{# if(d.category){  }}
        @{{d.category.name}}
        @{{# } }}
    </script>
    <script type="text/html" id="barDemo">
        {{--<a class="btn blue btn-xs" lay-event="detail">查看</a>--}}
        <a class="btn blue-madison btn-xs" lay-event="edit" data-toggle="modal" data-target=".bs-example-modal-md">编辑</a>
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
                            zjb.ajaxPostData('', '{{url("supplier")}}/'+id, {
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
                            zjb.ajaxGetHtml($(".bs-example-modal-md .modal-content"),'{{url("supplier")}}/'+curData.id+"/edit",{'id':curData.id},true);
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
                            zjb.ajaxGetHtml($(".bs-example-modal-md .modal-content"),'{{url("supplier")}}/'+data.id+"/edit",{'id':data.id},true);
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
    <script type="text/javascript">
        $( document ).ready( function () {
            $('.datepicker').datepicker({
                language: "zh-CN",
                format: 'yyyy/mm/dd',
                autoclose:true
            });

            zjb.initAjax();
            var supplier_form = $( "#signupForm1" );
            var errorInfo = $('.alert-danger', supplier_form);
            supplier_form.validate( {
                rules: {
                    category_id:"required",
                    name:"required"
                },
                messages: {
                    category_id:"类别不能为空",
                    name:"名称不能为空"
                },
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                invalidHandler: function(error,validator){
                    errorInfo.show();
                },
                errorPlacement: function ( error, element ) {
                    if (element.parent(".input-group").length > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').length > 0) {
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').length > 0) {
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').length > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').length > 0) {
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function () {
                    //表单验证之后ajax上传数据
                    $.ajax({
                        url:"{{url('supplier')}}",
                        data:supplier_form.serialize(),
                        type:"post",
                        dataType:"json",
                        beforeSend:function () {
                            zjb.blockUI();
                        },
                        error:function (jqXHR, textStatus, errorThrown) {
                            if(jqXHR.status == 422){
                                var arr = "";
                                for (var i in jqXHR.responseJSON){
                                    var xarr = jqXHR.responseJSON[i];
                                    for (var j=0;j<xarr.length;j++){
                                        var str = xarr[j];
                                        arr += str+",";
                                    }
                                }
                                swal("",arr.substring(0,arr.length-1), "error");
                            }
                        },
                        complete:function () {
                            zjb.unblockUI();
                        },
                        success:function (data) {
                            if(data.code){
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
                    })
                }
            } );
        } );
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


        function add(url) {
            $.ajax({
                url:url,
                success:function (data) {
                    $("#right_content").html(data);
                }
            })
        }

        function edit() {
            if($("tbody input[type='checkbox']:checked").length == 1){
                var id = $("tbody input[type='checkbox']:checked").val();
                $.ajax({
                    url:'{{url('supplier')}}/'+id+"/edit",
                    success:function (data) {
                        $("#right_content").html(data);
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
                        cancelButtonText: "取消",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },
                    function(){
                        //发异步删除数据
                        $.ajax({
                            type: "post",
                            url: '{{url('supplier')}}'+'/'+arr,
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
</div>

@endsection