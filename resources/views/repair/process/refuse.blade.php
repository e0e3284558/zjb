<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">填写原因</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button class="close" data-close="alert"></button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="str" value="{{$str}}">

        <div class="row">
            <div class="col-md-12" >
                <div class="form-group">
                    <div class="col-sm-2 control-label">拒单原因</div>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="suggest" rows="3" style="height: 120px;resize: none;" placeholder="拒单说明 ..."></textarea>
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
                    url:"{{url('repair/process/batchRefuse/'.$str)}}",
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

<script type="text/javascript" >
    //查找是否还有子类别
    function find(id) {
        $.ajax({
            url:'{{url('asset_category/find')}}'+"/"+id,
            type:"get",
            data:{id:id},
            dataType:"json",
            success:function (data) {
                if(data.code){
                    $("#type_id option:first").prop("selected","selected");
                    alert("只能选择子分类....");
                }
            }
        })
    }
</script>

<script type="text/javascript" >
    // 初始化Web Uploader
    {{--var uploader = WebUploader.create({--}}
        {{--// 选完文件后，是否自动上传。--}}
        {{--auto: true,--}}
        {{--// swf文件路径--}}
        {{--swf: '{{url("admin/plugins/webuploader/Uploader.swf")}}',--}}
        {{--// 文件接收服务端。--}}
        {{--server: '{{url('upload/uploadFile')}}',--}}
        {{--formData: {"_token": "{{ csrf_token() }}"},--}}
        {{--// 选择文件的按钮。可选。--}}
        {{--// 内部根据当前运行是创建，可能是input元素，也可能是flash.--}}
        {{--pick: '#filePicker',--}}
        {{--// 只允许选择图片文件。--}}
        {{--accept: {--}}
            {{--title: 'Images',--}}
            {{--extensions: 'gif,jpg,jpeg,bmp,png',--}}
            {{--mimeTypes: 'image/jpg,image/jpeg,image/png'   //修改这行--}}
        {{--}--}}
    {{--});--}}
    {{--uploader.on('uploadSuccess', function (file, response) {--}}
        {{--$('#thumb_img').attr('src', '/' + response.path);--}}
        {{--$('#upload_id').attr('value', response.id);--}}
    {{--});--}}
</script>
