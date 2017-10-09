<div style="padding: 20px;">
<div class="pt20"></div>
<form id="signupForm1" class="form-horizontal" method="post" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="{{$info->id}}" >
    <div class="form-group">
        <label class="col-sm-3 control-label" for="name">类别名称<span class="required">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="name" value="{{$info->name}}" class="form-control" placeholder="区域名称">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="name">类别编号<span class="required">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="category_code" value="{{$info->category_code}}" name="category_code" placeholder="类别编号" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" ></label>
        <div class="col-sm-8">
            <a style="margin: 0 5px;" class="btn btn-default pull-right" onclick="adds('{{$info->id}}')" >添加子类</a>
            <a style="margin: 0 5px;" class="btn btn-danger pull-right" onclick="dlt('{{$info->id}}')" >删除</a>
            <button style="margin: 0 5px;" type="submit" class="btn btn-success pull-right">保存</button>
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
    $( document ).ready( function () {
        $( "#signupForm1" ).validate( {
            rules: {
                category_code:{
                    required:true,
                } ,
                name: "required",
            },
            messages: {
                category_code:{
                    required:"请输出类别编号",
                } ,
                name: "请输出类别名称",
            },
            errorElement: 'span',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
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
                    url:"{{url('asset_category/'.$info->id)}}",
                    data:$('#signupForm1').serialize(),
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
        });

    });
    /*删除*/
    function dlt(id){
    swal({
            title: "确认要删除该资产类别吗？",
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
                type:"post",
                url:'{{url('asset_category')}}'+'/'+id,
                data:{
                    "_token":'{{csrf_token()}}',
                    '_method':'delete'
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

    }

    /*加载添加视图*/
    function adds(id) {
        $.ajax({
            url:'{{url('asset_category/add_son')}}/'+id,
            type:"get",
            success:function (data) {
                $("#right_content").html(data);
            }
        })
    }
</script>