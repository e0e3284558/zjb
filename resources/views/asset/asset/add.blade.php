<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产新增</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button class="close" data-close="alert"></button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="code" class="col-sm-4 control-label">资产条码</label>
                    <div class="col-sm-8">
                        <input type="text" name="code" disabled class="form-control" id="inputEmail3" placeholder="资产条码">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="category_id" class="col-sm-4 control-label">资产类别<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="category_id" data-error-container="#error-block" onchange="find(this.value)" id="category_id">
                            <option value="">请选择</option>
                            @foreach($list1 as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">资产名称<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" data-error-container="#error-block" placeholder="资产名称">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-4">
                <div class="form-group">
                    <label for="buy_time" class="col-sm-4 control-label">购入时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="buy_time" value="{{date("Y-m-d")}}" data-error-container="#error-block" class="form-control datepicker" data-date-end-date = "0d">
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="area_id" class="col-sm-4 control-label">所在场地<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <select name="area_id" class="form-control select2" data-error-container="#error-block">
                            <option value="">请选择</option>
                            @foreach($list4 as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4" >
                <div class="form-group">
                    <label for="money" class="col-sm-4 control-label">规格型号</label>
                    <div class="col-sm-8">
                        <input type="text" name="spec" class="form-control" data-error-container="#error-block" placeholder="规格型号">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="money" class="col-sm-4 control-label">金额</label>
                    <div class="col-sm-8">
                        <input type="text" name="money" class="form-control" data-error-container="#error-block" placeholder="金额">
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="calculate" class="col-sm-4 control-label">计量单位</label>
                    <div class="col-sm-8">
                        <input type="text" name="calculate" class="form-control" id="inputEmail3" placeholder="计量单位">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="position: relative;" >
                    <label for="department_id" class="col-sm-4 control-label">所属部门</label>
                    <div class="col-sm-8">
                        <select id="department_id" data-error-container="#error-block" name="department_id" class="form-control select2">
                            <option value="">请选择</option>
                            @foreach($list6 as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="admin_id" class="col-sm-4 control-label">管理员</label>
                    <div class="col-sm-8">
                        <select name="admin_id" class="form-control select2">
                            @foreach($list3 as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="source_id" class="col-sm-4 control-label">来源</label>
                    <div class="col-sm-8">
                        <select name="source_id" class="form-control select2">
                            @foreach($list5 as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="supplier" class="col-sm-4 control-label">供应商</label>
                    <div class="col-sm-8">
                        <input type="text" name="supplier" class="form-control" id="inputEmail3" placeholder="供应商">
                    </div>
                </div>
            </div>
            {{--<div class="col-md-4">--}}
                {{--<div class="form-group" style="position: relative;" >--}}
                    {{--<label for="use_department_id" class="col-sm-4 control-label">使用部门</label>--}}
                    {{--<div class="col-sm-8">--}}
                        {{--<select id="use_department_id" name="use_department_id" class="form-control select2">--}}
                            {{--<option value="">请选择</option>--}}
                            {{--@foreach($list6 as $v)--}}
                                {{--<option value="{{$v->id}}">{{$v->name}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>

        <div class="row">

            <div class="col-md-8" >
                <div class="form-group">
                    <label for="remarks" class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="remarks" rows="3" style="height: 120px;resize: none;" placeholder="备注说明 ..."></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="Comment" class="col-sm-4 control-label">照片</label>
                    <div class="col-sm-8">
                        <img id="thumb_img" src="{{url('uploads/imgs/nopicture.jpg')}}" alt="" class="img-lg">
                        <input type="hidden" id="upload_id" name="file_id" value="">
                        <div id="single-upload" class="btn-upload m-t-xs">
                            <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 选择图片</div>
                            <div id="single-upload-file-list"></div>
                        </div>
                    </div>
                </div>
            </div>



            <input type="hidden" name="org_id" value="{{$org_id}}">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="submitAssetsForm">保存</button>
</div>
<script type="text/javascript">

    $( document ).ready( function () {

        zjb.singleImageUpload({
            uploader:'singleUpload',
            picker:'single-upload',
            swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
            server: '{{ route("image.upload") }}',
            formData: {
                '_token':'{{ csrf_token() }}'
            },
            errorMsgHiddenTime:2000,

            uploadSuccess:function(file,response){
                //上传完成触发时间
                $('#upload_id').val(response.data.id);
                $('#thumb_img').attr({src:response.data.url});
                window.setTimeout(function () {
                    $('#'+file.id).remove();
                }, 2000);
            }
        });

        $('.datepicker').datepicker({
            language: "zh-CN",
            format: 'yyyy/mm/dd',
            autoclose:true
        });
        zjb.initAjax();
        var assets_form = $( "#signupForm1" );
        var errorInfo = $('.alert-danger', assets_form);
        $('#submitAssetsForm').click(function () {
            assets_form.submit();
        });
        assets_form.validate( {
            rules: {
                category_id:"required",
                name:"required",
                area_id:"required",
                money:{
                    number:true,
                    min:0
                },
                buy_time:"required",
                use_time: {
                    min: 1,
                    digits:true
                }
            },
            messages: {
                category_id:"资产类别不能为空",
                name:"资产名称不能为空",
                area_id:'所在场地不能为空',
                money:{
                    number:"必须为数值类型",
                    min:"金额必须为大于零的有效数字"
                },
                buy_time:"购入时间不能为空",
                use_time: {
                    min: "请输入一个有效整数",
                    digits:"请输入一个正整数"
                }
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
                    url:"{{url('asset')}}",
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
