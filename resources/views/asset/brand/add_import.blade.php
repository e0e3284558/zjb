<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">导入数据</h4>
</div>
<div class="modal-body">
    <div class="alert alert-danger display-hide" id="error-block">
        <button class="close" data-close="alert"></button>
        请更正下列输入错误：
    </div>
    <form id="signupForm" class="form-horizontal " method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="upload_id" data-error-container="#error-block" name="file_path" value="">
        <div id="single-file-upload-instance" class="clearfix multi-file-upload">
            <div id="single-file-upload-instance-file-list" class="pull-left">
            </div>
            <div id="single-file-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                <p class="m-b-sm"><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                上传导入文件
            </div>
        </div>
        <div class="clearfix"></div>
    </form>
    <div class="hide" id="result_log">
        导入错误日志
        <table id="import_result">
            
        </table>
    </div>
</div>
<div class="modal-footer">
    <a href="{{asset('uploads/temp/brand_import.xlsx')}}" class="btn btn-default">下载模板</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="sub">导入</button>
</div>

<script type="text/javascript">

    $( document ).ready( function () {
        zjb.fileUpload({
            uploader:'singleFileUploadInstance',
            picker:'single-file-upload-instance',
            swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
            server: '{{ route("file.upload") }}',
            formData: {
                '_token':'{{ csrf_token() }}'
            },
            fileNumLimit:1,
            isAutoInsertInput:false,//上传成功是否自动创建input存储区域
            uploadComplete:function(file,uploader){},
            uploadError:function(file,uploader){},
            uploadSuccess:function(file,response,uploader){
                //上传完成触发时间
                $('#upload_id').val(response.data.path);
            },
            fileCannel:function(fileId,uploader){},
            fileDelete:function(fileId,uploader){}
        });

        var import_form = $( "#signupForm" );
        var errorInfo = $('.alert-danger');
        $('#sub').click(function () {
            import_form.submit();
        });
        import_form.validate( {
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
                    url:"{{url('brand/import')}}",
                    data:import_form.serialize(),
                    type:"post",
                    dataType:"json",
                    beforeSend:function () {
                        zjb.blockUI('.modal-body');
                    },
                    success:function (data) {
                        if(data.status){
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
                        }else{
                            swal("",'导入失败，系统出错', "error");
                        }
                    },
                    complete:function () {
                        zjb.unblockUI('.modal-body');
                    }

                })
            }
        } );
    } );
</script>