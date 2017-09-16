<form id="signupForm1" class="form-horizontal" method="post" enctype="multipart/form-data" >

    <div class="alert alert-danger display-hide" id="error-block">
        <button class="close" data-close="alert"></button>
        请更正下列输入错误：
    </div>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label class="col-sm-3 control-label">供应商名称<span style="color:red;">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="{{$info->name}}" data-error-container="#error-block">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">类别<span class="required">*</span></label>
        <div class="col-sm-8">
            <select name="category_id" class="form-control select2" data-error-container="#error-block">
                <option >请选择</option>
                @foreach($list as $v)
                    @if($v->id == $info->category_id)
                        <option value="{{$v->id}}" selected >{{$v->name}}</option>
                    @else
                        <option value="{{$v->id}}">{{$v->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">备注</label>
        <div class="col-sm-8">
            <textarea class="form-control" name="remarks" rows="3" style="height: 120px;resize: none;" placeholder="备注说明 ...">{{$info->remarks}}</textarea>
        </div>
    </div>
    <div class="col-md-offset-8">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-success">保存</button>
    </div>
</form>
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
        $('#submitAssetsForm').click(function () {
            supplier_form.submit();
        });
        supplier_form.validate( {
            rules: {
                name:"required",
                category_id:"required"
            },
            messages: {
                name:"名称不能为空",
                category_id:"分类不能为空"
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
                    url:"{{url('supplier/'.$info->id)}}",
                    data:$('#signupForm1').serialize(),
                    type:"post",
                    dataType:"json",
                    beforeSend:function () {
                        $('#signupForm1').toggleClass('sk-loading');
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
                        $('#signupForm1').toggleClass('sk-loading');
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