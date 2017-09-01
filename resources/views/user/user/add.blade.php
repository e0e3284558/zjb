<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">创建用户</h4>
</div>
<div class="modal-body">
    <form id="AddUserForm" class="form-horizontal " method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label">用户名<span style="color:red;">*</span></label>
            <input type="text" value="" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">用户密码<span style="color:red;">*</span></label>
            <input type="password" value="" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">用户邮箱<span style="color:red;">*</span></label>
            <input type="email" value="" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">用户手机号<span style="color:red;">*</span></label>
            <input type="number" value="" name="tel" class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">
                所属部门
            </label>
            <div>
                <select name="department_id" class="form-control select2">
                    {!! department_select() !!}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">
                上传头像
            </label>
            <img src="" alt="">
            <div>
                <button class="btn btn-success">点击上传</button>
                <input type="hidden" name="avatar" value="">
                <input type="hidden" name="org_id" value="{{Auth::user()->org_id}}">
            </div>
        </div>


    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="submitUserForm">保存</button>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        //$('select').chosen({width:'100%'});

        zjb.initAjax();
        var assets_form = $("#AddUserForm");
        var errorInfo = $('.alert-danger', assets_form);
        $('#submitUserForm').click(function () {
            assets_form.submit();
        });
        assets_form.validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 20
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                tel: {
                    required: true,
                    phoneUS: true
                }
            },
            messages: {
                name: {
                    required: '请填写用户帐号',
                    minlength: '帐号最少不能小于2位',
                    maxlength: '帐号最多不能多于20位'
                },
                password: {
                    required: '请填写用户密码',
                    minlength: '密码最少不能少于2位',
                    maxlength: '密码最多不能多于20位'
                },
                tel: {
                    required: '请填写用户手机号码',
                    phoneUS: '请输入正确的手机号码'
                }
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            invalidHandler: function (error, validator) {
                errorInfo.show();
            },
            errorPlacement: function (error, element) {
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
                errorInfo.hide();
                //表单验证之后ajax上传数据
                $.ajax({
                    url: "{{url('users/default/store')}}",
                    data: assets_form.serialize(),
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {
                        zjb.blockUI('#AddUserForm');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 422) {
                            var arr = "";
                            for (var i in jqXHR.responseJSON) {
                                var xarr = jqXHR.responseJSON[i];
                                for (var j = 0; j < xarr.length; j++) {
                                    var str = xarr[j];
                                    arr += str + ",";
                                }
                            }
                            swal("", arr.substring(0, arr.length - 1), "error");
                        }
                    },
                    complete: function () {
                        zjb.unblockUI('#AddUserForm');
                    },
                    success: function (data) {
                        if (data.status) {
                            swal({
                                title: "",
                                text: data.message,
                                type: "success",
                                timer: 1000,
                            }, function () {
                                window.location.reload();
                            });
                        } else {
                            swal("", data.message, "error");
                        }
                    }
                })
            }
        });
    });
</script>


