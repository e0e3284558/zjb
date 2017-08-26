<h4 class="modal-title" id="myModalLabel">添加子场地</h4>
<div class="pt20"></div>
<form id="signupForm1" class="form-horizontal" method="post" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="pid" value="{{$info->id}}">
    <div class="form-group">
        <label class="col-sm-3 control-label" for="name">场地名称<span style=" color:red">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="name" name="name" placeholder="区域名称" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="pid">父级场地</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" disabled name="pid" value="{{$info->name}}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="remarks">备注</label>
        <div class="col-sm-8">
            <textarea class="form-control" name="remarks" cols="4" style="resize: none;" placeholder="添加备注"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-8 control-label" ></label>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-success">保存</button>
        </div>
    </div>
</form>

<script type="text/javascript">

    $( document ).ready( function () {

        $( "#signupForm1" ).validate( {
            rules: {
                name: "required",
            },
            messages: {
                name: "请输出区域名称",
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
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
                    url:"{{url('area')}}",
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
</script>
