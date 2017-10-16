<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"></span>
    </button>
    <h4 class="modal-title" id="myModalLabel">物品添加</h4>
</div>

<form action="{{url('consumables/goods/')}}" method="post" id="signupForm1" class="form-horizontal">
    <div class="modal-body">
        {{csrf_field()}}
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">物品编码</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="coding" placeholder="物品编码">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">物品名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="物品名称">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">商品条码</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="barcode" placeholder="商品条码">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">规格型号</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="norm" placeholder="规格型号">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">单位</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="unit" placeholder="单位">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">品牌商标</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="trademark" placeholder="品牌商标">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">安全库存</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="inventory_cap" placeholder="上限">
                </div>
                <div class="col-sm-1">-</div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="inventory_lower" placeholder="下限">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">禁用</label>
                <div class="col-sm-4">
                    <input type="checkbox" class="form-control  icheck" name="disable">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">备注</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="comment" placeholder="备注">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">所属分类</label>
                <div class="col-sm-10">
                    @if(isset($id))
                        <select name="classify_id" id="" class="form-control" disabled>
                            @foreach($sort as $v)
                                <option value="{{$v->id}}" @if($v->id==$id) selected @endif>{{$v->name}}</option>
                            @endforeach
                        </select>
                    @else
                        <select name="classify_id" id="" class="form-control">
                            <option value="">请选择分类</option>
                            @foreach($sort as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <!--dom结构部分-->
            <div class="form-group">
                <label for="Comment" class="col-sm-2 control-label">照片</label>
                <div class="col-sm-8">
                    <img id="thumb_img" src="{{url('img/noavatar.png')}}" alt="" class="img-lg">
                    <input type="hidden" id="upload_id" name="upload_id" value="">
                    <input type="hidden" name="upload_id" value="">
                    <div id="single-upload" class="btn-upload m-t-xs">
                        <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 选择图片
                        </div>
                        <div id="single-upload-file-list"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-success" id="submitAssetsForm">保存</button>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        zjb.initAjax();
        zjb.singleImageUpload({
            uploader: 'singleUpload',
            picker: 'single-upload',
            swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
            server: '{{ route("image.upload") }}',
            formData: {
                '_token': '{{ csrf_token() }}'
            },
            errorMsgHiddenTime: 2000,

            uploadSuccess: function (file, response) {
                //上传完成触发时间
                $('#upload_id').val(response.data.id);
                $('#thumb_img').attr({src: response.data.url});
                window.setTimeout(function () {
                    $('#' + file.id).remove();
                }, 2000);
            }
        });


        var l = $("button[type='submit']").ladda();
        var process_form = $("#signupForm1");
        var errorInfo = $('.alert-danger', process_form);
        $('#submitAssetsForm').click(function () {
            process_form.submit();
        });
        process_form.validate({
            rules: {},
            messages: {},
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
                    url: "{{url('consumables/goods')}}",
                    data: process_form.serialize(),
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {
                        l.ladda('start');
                    },
                    complete: function (xhr, textStatus) {
                        l.ladda('stop');
                    },
                    success: function (data, textStatus, xhr) {
                        if (data.status) {
                            toastr.success(data.message);
                            zjb.backUrl('{{url('consumables/archiving')}}', 1000);
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
                });
                return false;
            }
        });
    });
</script>