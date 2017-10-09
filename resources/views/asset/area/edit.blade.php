<div class="ibox m-b-none">
    <div class="ibox-title">
        <h5>场地编辑</h5>
    </div>
    <div class="ibox-content margin-padding-0 relative-ibox-content">
        <form action="{{ url('area/'.$area->id) }}" class="padding-20" method="post" id="dep-form">
            <div class="form-group">
                <label class="control-label">
                    上级场地
                </label>
                <div>
                    <select name="pid" class="form-control select2" data-error-container="#pid-error">
                        {!! area_select($area->pid) !!}
                    </select>
                    <span class="help-block" id="pid-error">请选择上级场地</span>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label">
                    场地编码<span class="required">*</span>
                </label>
                <div>
                    <input type="text" placeholder="场地编码" disabled="" name="code" value="{{$area->code}}" class="form-control">
                    <span class="help-block">请输入场地编码</span>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label">
                    场地名称
                </label>
                <div>
                    <input type="text" placeholder="部门名称" name="name" value="{{$area->name}}" class="form-control">
                    <span class="help-block">请输入部门名称</span>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label" for="remarks">备注</label>
                <div>
                    <textarea class="form-control" name="remarks" cols="5"  placeholder="场地备注">{{$area->remarks}}</textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label">
                    状态
                </label>
                <div>
                    <label class="radio-inline i-checks"> <input type="radio" name="status" class="icheck" value="1" {{ $area->status ? 'checked' : '' }}> 可用 </label>
                    <label class="radio-inline i-checks"> <input type="radio" class="icheck" name="status" value="0" {{ $area->status ? '' : 'checked' }}> 不可用 </label>
                </div>
            </div>
            {{-- <div class="form-group">
                <label class="control-label">
                    排序
                </label>
                <div class="">
                    <input type="number" placeholder="排序" name="sort" value="{{ $area->sort }}" class="form-control">
                </div>
            </div>--}}
            <div class="form-actions border-top ">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{ $area->id }}">
                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><span class="ladda-label">保存</span></button>
                <button type="button" class="btn btn-danger ladda-button" id="delete" data-style="expand-left">删除</button>
                <button type="button" class="btn btn-default" id="cannel">取消</button>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                var forms = $('#dep-form');
                var l = $("button[type='submit']").ladda();
                $('#cannel').click(function(){
                    zjb.ajaxGetHtml('#dep-form-wrapper','{{ url("area/create") }}',{},false);
                });
                $('#delete').click(function(){
                    var dl = $("#delete").ladda();
                    swal({
                      title: "确定要删除吗?",
                      text: "",
                      type: "warning",
                      showCancelButton: true,
                      cancelButtonText:'取消',
                      confirmButtonText: "确定",
                      closeOnConfirm: false
                    },
                    function(){
                        swal.close();
                        jQuery.ajax({
                            url: forms.attr('action'),
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                '_method':'DELETE'
                            },
                            beforeSend: function(){
                                // zjb.blockUI();
                                dl.ladda('start');
                                $('.form-actions button').attr({'disabled':'disabled'});
                            },
                            complete: function(xhr, textStatus) {
                                // zjb.unblockUI();
                                dl.ladda('stop');
                                $('.form-actions button').removeAttr('disabled');
                            },
                            success: function(data, textStatus, xhr) {
                                if(data.status){
                                    toastr.success(data.message);
                                    $('#cannel').click();
                                    //重新载入左侧树形菜单
                                    $.fn.zTree.getZTreeObj("departments-tree").reAsyncChildNodes(null, "refresh");
                                }else{
                                    toastr.error(data.message,'警告'); 
                                }
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
                            }
                        });  
                    });
                });
                forms.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",
                    rules: {
                        pid: "required",
                        name: "required",
                        code: "required",
                        status: "required"
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
                            data: forms.serialize(),
                            beforeSend: function(){
                                // zjb.blockUI();
                                l.ladda('start');
                            },
                            complete: function(xhr, textStatus) {
                                // zjb.unblockUI();
                                l.ladda('stop');
                            },
                            success: function(data, textStatus, xhr) {
                                if(data.status){
                                    toastr.success(data.message);
                                    //重新载入左侧树形菜单
                                    $.fn.zTree.getZTreeObj("departments-tree").reAsyncChildNodes(null, "refresh");
                                    zjb.ajaxGetHtml($('#dep-form-wrapper'),'{{ url("area/".$area->id."/edit") }}',{},false);
                                }else{
                                   toastr.error(data.message,'警告'); 
                                }
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
                            }
                        });
                        return false;
                    }
                });
            });
        </script>
    </div>
</div>