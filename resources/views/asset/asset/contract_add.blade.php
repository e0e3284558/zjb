<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产新增</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <div class="table-responsive">
            <table  class="table table-striped  table-bordered"  lay-filter="asset-table">
                <tbody>
                    @if(count($list)>0)
                        <tr role="row" >
                            <th>合同名称</th>
                            <th>甲方</th>
                            <th>乙方</th>
                            <th>丙方</th>
                            <th>维保起始时间</th>
                            <th>维保终止时间</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list as $k=>$v)
                            <tr role="row" >
                                <td>{{$v->name}}</td>
                                <td>{{$v->first_party}}</td>
                                <td>{{$v->second_party}}</td>
                                <td>{{$v->third_party}}</td>
                                <td>{{$v->start_date}}</td>
                                <td>{{$v->end_date}}</td>
                                <td>{{$v->remarks}}</td>
                                <td><a href="javascript:;" onclick="tgl(this,'{{$v->id}}')" class="toggle btn btn-sm btn-primary" >展开/关闭</a></td>
                            </tr>
                            @if($v->bill)
                                <tr role="row" class="aaa{{$v->id}}" style="display: none;">
                                    <th>
                                        <input type="checkbox" class="i-checks" name="checkAll" id="all" >
                                    </th>
                                    <th>资产名称</th>
                                    <th>数量</th>
                                    <th style="width: 200px;" >资产类别</th>
                                    <th>规格型号</th>
                                    <th>计量单位</th>
                                    <th>单价(元)</th>
                                    <th style="width: 150px;">供应商</th>
                                </tr>
                                @foreach($v->bill as $key=>$value)
                                    <tr role="row" class="aaa{{$v->id}}" style="display: none;">
                                        <td role="gridcell">
                                            <input type="checkbox" class="i-checks" name="id[]" value="{{$value->id}}">
                                        </td>
                                        <td>{{$value->asset_name}}</td>
                                        <td>{{$value->num}}</td>
                                        <td>{{$value->category->name}}</td>
                                        <td>{{$value->spec}}</td>
                                        <td>{{$value->calculate}}</td>
                                        <td>{{$value->money}}</td>
                                        <td>{{$value->supplier->name}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" style="text-align: center">暂无数据</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="row" >
            <div class="col-md-4">
                <div class="form-group">
                    <label for="buy_time" class="col-sm-4 control-label">购入时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="buy_time" value="{{date("Y-m-d")}}" data-error-container="#error-block" class="form-control datepicker" data-date-date = "0d">
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="area_id" class="col-sm-4 control-label">所在场地<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <select name="area_id" class="form-control select2" data-error-container="#error-block">
                            {!! area_select("","1") !!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="position: relative;" >
                    <label for="department_id" class="col-sm-4 control-label">所属部门</label>
                    <div class="col-sm-8">
                        <select id="department_id" data-error-container="#error-block" name="department_id" class="form-control select2">
                            {!! department_select('',1) !!}
                        </select>
                    </div>
                </div>
            </div>
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
                        <img id="thumb_img" src="{{url('img/nopicture.jpg')}}" alt="" class="img-lg">
                        <input type="hidden" id="upload_id" name="file_id" value="">
                        <div id="single-upload" class="btn-upload m-t-xs">
                            <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 选择图片</div>
                            <div id="single-upload-file-list"></div>
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
    function tgl(obj,id) {
        $(obj).parents('tr').nextAll(".aaa"+id).slideToggle();
    }
    $( document ).ready( function () {
        $('.i-checks,#all').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
        $('#all').on('ifChecked ifUnchecked', function(event){
            if(event.type == 'ifChecked'){
                $('.i-checks').iCheck('check');
            }else{
                $('.i-checks').iCheck('uncheck');
            }
        });
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
                    url:"{{url('asset/contract_store')}}",
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

</script>