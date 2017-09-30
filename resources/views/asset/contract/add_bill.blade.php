<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">清单新增</h4>
</div>
<div class="modal-body overflow-auto">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="contract_id" value="{{$contract_id}}">
        <div style="overflow-x: auto" >
            <a href="javascript:;" class="add btn btn-md btn-success" >增加一栏</a>
            <a href="javascript:;" class="reduce btn btn-md btn-danger" >减去最后一栏</a>
            <table  class="table table-striped  table-bordered"  lay-filter="asset-table">
                <thead>
                <tr role="row">
                    <th>资产名称<span style="color: red;" >*</span></th>
                    <th>数量<span style="color: red;" >*</span></th>
                    <th style="width: 200px;" >资产类别<span style="color: red;" >*</span></th>
                    <th>规格型号<span style="color: red;" >*</span></th>
                    <th>计量单位<span style="color: red;" >*</span></th>
                    <th>单价(元)<span style="color: red;" >*</span></th>
                    <th style="width: 150px;">供应商<span style="color: red;" >*</span></th>
                </tr>
                </thead>
                <tbody>
                <tr >
                    <td><input class="form-control" type="text" name="name[]" data-error-container="#error-block" ></td>
                    <td><input class="form-control" type="text" name="num[]" data-error-container="#error-block" ></td>
                    <td>
                        <select class="form-control select2" name="category_id[]" data-error-container="#error-block" id="category_id">
                            {!! category_select() !!}
                        </select>
                    </td>
                    <td><input class="form-control" type="text" name="spec[]" data-error-container="#error-block" ></td>
                    <td><input class="form-control" type="text" name="calculate[]" data-error-container="#error-block"></td>
                    <td><input class="form-control" type="text" name="money[]" data-error-container="#error-block"></td>
                    <td>
                        <select class="form-control select2" name="supplier_id[]" data-error-container="#error-block" id="supplier_id">
                            {!! supplier_select() !!}
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
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
            rules: {
                'name[]':"required",
                'num[]':{
                    min:1,
                    digits:true
                },
                'category_id[]':"required",
                'spec[]':'required',
                'calculate[]':'required',
                'money[]':{
                    min:0,
                    number:true
                },
                'supplier_id[]':'required'
            },
            messages: {
                'name[]':"清单名称不能为空",
                'num[]':{
                    min:'必须为正整数',
                    digits:"必须为正整数",
                    'category_id[]':'请选择资产类别'
                },
                'spec[]':'规格型号不能为空',
                'calculate[]':'计量单位不能为空',
                'money[]':{
                    min:'请输入正确单价',
                    number:'请输入正确单价'
                },
                'supplier_id[]':"请选择供应商"
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
                    url:"{{url('contract/bill_store')}}",
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

<script type="text/javascript" >
    //查找是否还有子类别
    $("document").ready(function () {
        $(".add").click(function () {
            $(".table-bordered tbody").append(
                '<tr>' +
                '<td><input class="form-control" type="text" name="name[]" data-error-container="#error-block"></td>' +
                '<td><input class="form-control" type="text" name="num[]" data-error-container="#error-block"></td>' +
                '<td><select class="form-control select2" name="category_id[]" data-error-container="#error-block" id="category_id">' +
                '{!! category_select() !!}'+
                '</select></td>' +
                '<td><input class="form-control" type="text" name="spec[]" data-error-container="#error-block"></td>'+
                '<td><input class="form-control" type="text" name="calculate[]" data-error-container="#error-block"></td>'+
                '<td><input class="form-control" type="text" name="money[]" data-error-container="#error-block"></td>' +
                '<td><select class="form-control select2" name="supplier_id[]" data-error-container="#error-block" id="supplier_id">' +
                '{!! supplier_select() !!}' +
                '</select></td>' +
                '</tr>'
            )
        });
        $(".reduce").click(function () {
            $(".table-bordered tbody tr:last").remove();
        })
    });
</script>
