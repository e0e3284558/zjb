<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">修改用户</h4>
</div>
<div class="modal-body">
    <form action="{{url('users/default/'.$data->id)}}" id="AddUserForm" class="form-horizontal " method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-md-3">用户名<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="text" value="{{ $data->username }}" name="username" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">登录密码<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="password" value="" name="password" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">姓名<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" value="{{ $data->name }}" name="name" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">邮箱<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="email" value="{{ $data->email }}" name="email" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">手机号<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="text" value="{{ $data->tel }}" name="tel" minlength="11" maxlength="11" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">
                所属部门
            </label>
            <div class="col-md-8">
                <select name="department_id" class="form-control select2">
                    {!! department_select($data->department_id,1) !!}
                </select>
            </div>
        </div>
        {{ method_field('PUT') }}
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success blue" id="submitUserForm">保存</button>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        zjb.initAjax();
        var assets_form = $("#AddUserForm");
        $('#submitUserForm').click(function () {
            assets_form.submit();
        });
        assets_form.validate({
            rules: {
                username: {
                    required: true,
                    minlength: 4,
                    maxlength: 30
                },
                // password: {
                //     required: true,
                //     minlength: 6
                // },
                tel: {
                    required: true
                },
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email:true
                }
            },
            messages: {
                username: {
                    required: '请填写用户帐号',
                    minlength: '帐号最少不能小于4个字符',
                    maxlength: '帐号最多不能多于30个字符'
                },
                password: {
                    required: '请填写登录密码',
                    minlength: '密码最少不能小于6个字符'
                },
                tel: {
                    required: '请填写手机号码'
                }
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            invalidHandler: function (error, validator) {
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
                //表单验证之后ajax上传数据
                $.ajax({
                    url: assets_form.attr('action'),
                    data: assets_form.serialize(),
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {
                        zjb.blockUI('.modal-content');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        if(xhr.status == 422 && textStatus =='error'){
                            _$error = xhr.responseJSON.errors;
                            $.each(_$error,function(i,v){
                                toastr.error(v[0],'警告');
                            });
                        }else{
                            toastr.error('请求出错，稍后重试','警告');
                        }
                    },
                    complete: function () {
                        zjb.unblockUI('.modal-content');
                    },
                    success: function (data) {
                        if (data.status) {
                            toastr.success(data.message);
                            $("#operationModal").modal('hide');
                            curObj.update(data.data);
                            //重载table
                            //table.reload('dataUser');
                        } else {
                            toastr.error(data.message,'警告'); 
                        }
                    }
                });
                return false;
            }
        });
    });
</script>