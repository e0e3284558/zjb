<div class="ibox float-e-margins ">
    <div class="ibox-title">
        <h5>部门添加</h5>
        <div class="ibox-tools pull-right">
        </div>
    </div>
    <div class="ibox-content margin-padding-0 relative-ibox-content">
        <div class="full-height-scroll">
        <form action="{{ url('users/departments') }}" class="padding-20" method="post" id="dep-form">
            <div class="form-group">
                <label class="control-label">
                    上级部门
                </label>
                <div>
                    <select name="parent_id" class="form-control">
                        {!! department_select() !!}
                    </select> 
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label">
                    部门名称
                </label>
                <div>
                    <input type="text" placeholder="部门名称" name="name" value="" class="form-control">
                    <span class="help-block">请输入部门名称</span>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label">
                    状态
                </label>
                <div>
                    <label class="radio-inline i-checks"> <input type="radio" name="status" class="" value="1" checked> 可用 </label>
                    <label class="radio-inline i-checks"> <input type="radio" class="" name="status" value="0"> 不可用 </label>
                </div>
            </div>
            <div class="form-actions border-top right">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-success">保存</button>
                <button type="reset" class="btn btn-default" id="cannel">取消</button>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.i-checks').iCheck({
                    radioClass: 'iradio_minimal-blue'
                });
                $('select').chosen({
                    width:'100%'
                });
                var forms = $('#dep-form');
                forms.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",
                    rules: {
                        name: {
                            required: true
                        },
                        parent_id: {
                            required: true
                        },
                        status: {
                            required: true
                        }
                    },
                    messages:{},
                    invalidHandler: function (event, validator) { //display error alert on form submit
                    },
                    errorPlacement: function (error, element) { // render error placement for each input type
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
                    submitHandler: function (form) {
                        jQuery.ajax({
                            url: forms.attr('action'),
                            type: 'POST',
                            dataType: 'json',
                            data: $("#dep-form").serialize(),
                            beforeSend: function(){
                                zjb.blockUI();
                            },
                            complete: function(xhr, textStatus) {
                                zjb.unblockUI();
                            },
                            success: function(data, textStatus, xhr) {
                                if(data.status){
                                    toastr.success(data.message);
                                    $('#cannel').click();
                                    //重新载入左侧树形菜单
                                    $('#departments-tree').jstree('refresh');

                                }else{
                                   toastr.error(data.message); 
                                }
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                if(xhr.status == 422 && textStatus =='error'){
                                    $.each(xhr.responseJSON,function(i,v){
                                        toastr.error(v[0]);
                                    });
                                }else{
                                    toastr.error('请求出错，稍后重试');
                                }
                            }
                        });
                        return false;
                    }
                });
            });
        </script>
        </div>
    </div>
</div>