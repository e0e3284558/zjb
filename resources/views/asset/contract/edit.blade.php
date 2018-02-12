<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">合同信息修改</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">合同名称<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="name" value="{{$info->name}}" class="form-control" data-error-container="#error-block" placeholder="资产名称">
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group">
                    <label for="money" class="col-sm-4 control-label">甲方</label>
                    <div class="col-sm-8">
                        <input type="text" name="first_party" disabled value="{{$info->first_party}}" class="form-control" data-error-container="#error-block" placeholder="规格型号">
                    </div>
                </div>
            </div>

        </div>

        <div class="row" >
            <div class="col-md-6" >
                <div class="form-group">


                    <label class="col-sm-4 control-label">乙方(供应商)</label>
                    <div class="col-sm-8">
                        <select id="second_party" data-error-container="#error-block" name="second_party" class="form-control select2">
                            <option value="" >请选择</option>
                            @foreach($supplier_list as $v)
                                @if($v->name == $info->second_party)
                                    <option value="{{$v->name}}" selected >{{$v->name}}</option>
                                @else
                                    <option value="{{$v->name}}">{{$v->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group">
                    <label for="money" class="col-sm-4 control-label">丙方</label>
                    <div class="col-sm-8">
                        <input type="text" name="third_party" value="{{$info->third_party}}" class="form-control" data-error-container="#error-block" placeholder="丙方">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="remarks" class="col-sm-4 control-label">备注</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="remarks" rows="3" style="height: 80px;resize: none;" placeholder="备注说明 ...">{{$info->remarks}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group">
                    <label class="col-sm-4 control-label">维保起止时间</label>
                    <div class="col-sm-4">
                        <input type="text" name="start_date" value="{{$info->start_date}}" class="form-control datepicker" data-date-date = "0d" data-error-container="#error-block" placeholder="开始日期">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="end_date" value="{{$info->end_date}}" class="form-control datepicker" data-date-date = "0d" data-error-container="#error-block" placeholder="终止日期">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" >
                <div class="form-group">
                    <label for="Comment" class="col-sm-4 control-label">上传合同文件</label>
                    <div class="col-sm-8">
                        <input type="hidden" id="upload_id" name="file_id" value="">
                        <div id="single-file-upload-instance" class="clearfix multi-file-upload">
                            <div id="single-file-upload-instance-file-list" class="pull-left">
                            </div>
                            <div id="single-file-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                                <p class="m-b-sm"><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                                选择文件
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

        //单文件上传实例
        zjb.fileUpload({
            uploader:'singleFileUploadInstance',
            picker:'single-file-upload-instance',
            swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
            server: '{{ route("file.upload") }}',
            formData: {
                '_token':'{{ csrf_token() }}'
            },
            fileNumLimit:1,
            isAutoInsertInput:true,//上传成功是否自动创建input存储区域
            storageInputName:'file',//上传成功后input存储区域的name
            uploadComplete:function(file,uploader){},
            uploadError:function(file,uploader){},
            uploadSuccess:function(file,response,uploader){
//                console.log(response.data.id);
                $('#upload_id').val(response.data.id);
            },
            fileCannel:function(fileId,uploader){},
            fileDelete:function(fileId,uploader){}
        });

        $('.datepicker').datepicker({
            language: "zh-CN",
            format: 'yyyy-mm-dd',
            autoclose:true
        });
        zjb.initAjax();
        var assets_form = $( "#signupForm1" );
        var errorInfo = $('.alert-danger', assets_form);
        $('#submitAssetsForm').click(function () {
            assets_form.submit();
        });
        assets_form.validate( {
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
                    url:"{{url('contract/'.$info->id)}}",
                    data:assets_form.serialize(),
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
                    }
                })
            }
        } );
    } );
</script>