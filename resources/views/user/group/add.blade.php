<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">创建用户</h4>
</div>
<div class="modal-body">
    <form action="{{url('users/groups/store')}}" id="AddUserForm" class="form-horizontal " method="post"
          enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-md-3">角色名称<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" value="" name="name" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">显示名称<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" value="" name="display_name" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">拥有权限<span class="required">*</span></label>
            <div class="col-md-8">
                <ul id="treeDemo" class="ztree"></ul>
                <SCRIPT LANGUAGE="JavaScript">
                    $(document).ready(function () {
                        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
                        var setting = {
                            callback: {
                                //onClick: zTreeOnClick
                            },
                            check:{
                                enable: true,
                                chkboxType :{ "Y" : "ps", "N" : "ps" }
                            },
                            data: {
                                simpleData: {
                                    enable: true,
                                    idKey: "id",
                                    pIdKey: "parent_id",
                                    rootPId: 0
                                },
                                key:{
                                    name:'display_name'
                                }
                            }
                        };
                        var treeNodes = {!! $permission !!};
                        $.fn.zTree.init($("#treeDemo"), setting, treeNodes);

                    });
                </SCRIPT>
            </div>
        </div>
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
            var tree = $.fn.zTree.getZTreeObj("treeDemo");
            var selectedNodes = tree.getCheckedNodes(true);
            permission_name = [];
            $.each(selectedNodes,function (i,v) {
                permission_name.push(v.name);
            });
            assets_form.submit();
        });
        assets_form.validate({
            rules: {
                name: {
                    required: true,
                    minlength: 4,
                    maxlength: 30
                },
                display_name: {
                    required: true,
                    minlength: 4,
                    maxlength: 30
                }
            },
            messages: {
                name: {
                    required: '请填写角色名称',
                    minlength: '角色名称不能小于4个字符',
                    maxlength: '角色名称不能多于30个字符'
                },
                display_name: {
                    required: '请填写显示名称',
                    minlength: '显示名称不能小于4个字符',
                    maxlength: '显示名称不能多于30个字符'
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
//                console.log(assets_form.serialize());

                //表单验证之后ajax上传数据
                $.ajax({
                    url: "{{url('users/groups/store')}}",
                    data: assets_form.serialize()+'&permission='+permission_name,
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {
                        zjb.blockUI('.modal-content');
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        if (xhr.status == 422 && textStatus == 'error') {
                            _$error = xhr.responseJSON.errors;
                            $.each(_$error, function (i, v) {
                                toastr.error(v[0], '警告');
                            });
                        } else {
                            toastr.error('请求出错，稍后重试', '警告');
                        }
                    },
                    complete: function () {
                        zjb.unblockUI('.modal-content');
                    },
                    success: function (data) {
                        if (data.status) {
                            toastr.success(data.message);
                            location.reload(true);
                        } else {
                            toastr.error(data.message, '警告');
                        }
                    }
                });
                return false;
            }
        });
    });
</script>