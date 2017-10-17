<div class="ibox">
    <div class="ibox-title">
        <h5>创建分类</h5>
    </div>
    <div class="ibox-content margin-padding-0 relative-ibox-content">
        <form id="signupForm1" class="form-horizontal  padding-20 " method="post" id="dep-form">
            <div class="modal-body">
                <div class="form-group">
                    <i class="i-red">*</i>
                    <label class="control-label">选择父类</label>
                    <select name="parent_id" id="" class="form-control">
                        @if(isset($id))
                            <option value="{{$id}}">{{$sort->name}}</option>
                        @else
                            <option value="0">新建根分类</option>
                            @foreach($sort as $k=>$v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <i class="i-red">*</i>
                    <label class="control-label">分类名称</label>
                    <input type="text" name="name" value="" class="form-control" placeholder="请输入分类名称">
                </div>
            </div>
                <div class="form-actions border-top ">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-success blue ladda-button" data-style="expand-left"><span
                                class="ladda-label">保存</span></button>
                    <button type="reset" class="btn btn-default" id="cannel">取消</button>
                </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    $.validator.setDefaults({});
    $(document).ready(function () {
        $("#signupForm1").validate({
            rules: {
                name: {
                    required: true,
                },
                name: "required",
            },
            messages: {
                category_code: {
                    required: "请输出类别编号",
                },
                name: "请输出类别名称",
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
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
                    url: "{{url('consumables/sort')}}",
                    data: $('#signupForm1').serialize(),
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {
                        $('#signupForm1').toggleClass('sk-loading');
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
                        $('#signupForm1').toggleClass('sk-loading');
                    },
                    success: function (data, textStatus, xhr) {
                        if (data.status) {
                            toastr.success(data.message);
                            zjb.backUrl('{{url('consumables/sort')}}', 1000);
                        } else {
                            toastr.error(data.message, '警告');
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        if (xhr.status == 422 && textStatus == 'error') {
                            $.each(xhr.responseJSON, function (i, v) {
                                toastr.error(v[0], '警告');
                            });
                        } else {
                            toastr.error('请求出错，稍后重试', '警告');
                        }
                    }
                })
            }
        });

    });
</script>
