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
{{--其他报修项 --}}
<div class="fh-breadcrumb fh-breadcrumb-m full-height-layout-on">
    <div class="wrapper wrapper-content2 full-height">
        <div class="row full-height">
            <div class="col-md-6 full-height">
                <div class="ibox full-height-ibox">
                    <div class="ibox-title">
                        <h5>其他报修项</h5>
                    </div>
                    <div class="ibox-content margin-padding-0">
                        <div class="ibox-content-wrapper">
                            <div class="scroller" style="padding: 0 5px;">
                                <table style="width: 100%;" class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th><input type="checkbox" name="checkAll" id="all" ></th>
                                        <th>类别</th>
                                        <th>资产名称</th>
                                        <th>备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $k=>$v)
                                        <tr>
                                            <td><input type="checkbox" class="i-checks" name="id" value="{{$v->id}}"></td>
                                            <td>{{$v->category_id}}</td>
                                            <td><span class="cursor_pointer" href="{{url('other_asset')}}/{{$v->id}}" data-toggle="modal" data-target=".bs-example-modal-lg" >{{$v->name}}</span></td>
                                            <td>{{$v->remarks}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-actions border-top ">
                            <button type="button" onclick="add('{{url('other_asset/create')}}')" class="btn btn-success" >
                                <i class="fa  fa-plus"></i> 增加
                            </button>
                            <button type="button" onclick="edit()" class="btn btn-default">
                                <i class="fa fa-pencil"></i> 修改
                            </button>

                            <button type="button" onclick="dlt()" class="btn btn-danger">
                                <i class="fa  fa-trash-o"></i> 删除
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 full-height">
                <div class="ibox full-height-ibox">
                    <div class="ibox-title">
                        <h5>编辑</h5>
                    </div>
                    <div class="ibox-content margin-padding-0">
                        <div class="scroller">
                            <div id="right_content" class="full-height-wrapper">

                                <form id="signupForm1" class="form-horizontal" method="post" enctype="multipart/form-data" >
                                    <div class="alert alert-danger display-hide" id="error-block">
                                        <button class="close" data-close="alert"></button>
                                        请更正下列输入错误：
                                    </div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">资产类别<span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <select name="category_id" onchange="find(this.value)" id="type_id" class="form-control select2 " data-error-container="#error-block">
                                                    <option value="">请选择</option>
                                                    @foreach($category_list as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">资产名称<span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="资产名称" data-error-container="#error-block">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">备注</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="remarks" rows="3" style="height: 120px;resize: none;" placeholder="备注说明 ..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-offset-10">
                                        <button type="submit" class="btn btn-success" id="submitAssetsForm">保存</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $( document ).ready( function () {
        $('.datepicker').datepicker({
            language: "zh-CN",
            format: 'yyyy/mm/dd',
            autoclose:true
        });

        zjb.initAjax();
        var otherAssets_form = $( "#signupForm1" );
        var errorInfo = $('.alert-danger', otherAssets_form);
        $('#submitAssetsForm').click(function () {
            otherAssets_form.submit();
        });
        otherAssets_form.validate( {
            rules: {
                category_id:"required",
                name:"required"
            },
            messages: {
                category_id:"资产类别不能为空",
                name:"资产名称不能为空"
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
                    url:"{{url('other_asset')}}",
                    data:otherAssets_form.serialize(),
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
    //查找是否还有子类别
    function find(id) {
        $.ajax({
            url:'{{url('asset_category/find')}}'+"/"+id,
            type:"get",
            data:{id:id},
            dataType:"json",
            success:function (data) {
                if(data.code){
                    $("#type_id option:first").prop("selected","selected");
                    alert("只能选择子分类....");
                }
            }
        })
    }
    //查看是否还有子部门
    function seldep(id) {
        $.ajax({
            "url":'{{url('asset/sel')}}'+"/"+id,
            "type":"get",
            'data':{id:id},
            'dataType':"json",
            success:function (data) {
                var select = $("#use_department_id");
                if(data.length>0){
                    select.append("<option value=''>请选择</option>");
                    //遍历
                    for (var i = 0; i < data.length; i++) {
                        //把遍历出来数据添加到option
                        info = '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        //把当前info数据添加到创建的select
                        select.append(info);
                    }
                }
            }
        })
    }
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
                url:'{{url('other_asset')}}/'+id+"/edit",
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