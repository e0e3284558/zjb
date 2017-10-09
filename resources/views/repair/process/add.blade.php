<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">填写维修结果</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button class="close" data-close="alert"></button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{$id}}">

        <div class="row" >
            <div class="col-md-12" >
                <div class="form-group" >
                    <div class="col-sm-2 control-label">维修结果</div>
                    <div class="col-sm-8">
                        <div class="icheck pull-left" style="margin-right: 10px">
                            <label>
                                <input type="radio" value="5" name="status" checked>
                                &nbsp;&nbsp;已修好
                            </label>
                        </div>
                        <div class=" icheck pull-left" style="margin-right: 10px">
                            <label>
                                <input type="radio" value="7" name="status" >
                                &nbsp;&nbsp;未修好
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" >
                <div class="form-group">
                    <div class="col-sm-2 control-label">维修记录</div>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="suggest" rows="3" style="height: 120px;resize: none;" placeholder="备注说明 ..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12" >
                <div class="form-group" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图片上传</label>
                        <div class="col-sm-10">
                            <div id="image-upload-instance"
                                 class="clearfix multi-image-upload multi-image-upload-lg">
                                <div id="image-upload-instance-file-list"
                                     class="pull-left"></div>
                                <div id="image-upload-instance-picker"
                                     class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker"
                                     data-toggle="tooltip" data-placement="top"
                                     data-original-title="文件大小10M以内">
                                    <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i>
                                    </p>
                                    选择图片
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="submitAssetsForm">保存</button>
</div>
<script type="text/javascript">

    $( document ).ready( function () {
        //通用报修图片上传
        zjb.imageUpload({
            uploader: 'imageUploadInstance',
            picker: 'image-upload-instance',
            swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
            server: '{{ route("image.upload") }}',
            isAutoInsertInput: true,//上传成功是否自动创建input存储区域
            storageInputName: 'images',//上传成功后input存储区域的name
            formData: {
                '_token': '{{ csrf_token() }}'
            },
            fileNumLimit: 5,
            uploadComplete: function (file, uploader) {
            },
            uploadError: function (file, uploader) {
            },
            uploadSuccess: function (file, response, uploader) {
            },
            fileCannel: function (fileId, uploader) {
            },
            fileDelete: function (fileId, uploader) {
            }
        });


        zjb.initAjax();
        var process_form = $( "#signupForm1" );
        var errorInfo = $('.alert-danger', process_form);
        $('#submitAssetsForm').click(function () {
            process_form.submit();
        });
        process_form.validate( {
            rules: {
                status:"required"
            },
            messages: {
                category_id:"请选择维修结果"
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
                errorInfo.hide();
                //表单验证之后ajax上传数据
                $.ajax({
                    url:"{{url('repair/process')}}",
                    data:process_form.serialize(),
                    type:"post",
                    dataType:"json",
                    beforeSend:function () {
                        zjb.blockUI('#signupForm1');
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
                        zjb.unblockUI('#signupForm1');
                    },
                    success:function (data) {
                        if(data.code){
                            swal({
                                title: "",
                                text: data.message,
                                type: "success",
                                timer: 1000,
                            },function () {
                                window.location.href="{{url('/repair/process?active=result')}}"
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
