<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">借用单</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal " method="post" enctype="multipart/form-data" >
        <div class="alert alert-danger display-hide" id="error-block">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            请更正下列输入错误：
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="code" class="col-sm-4 control-label">借用人</label>
                    <div class="col-sm-8">
                        <input type="text" name="borrow_user_name" class="form-control" placeholder="借用人">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="buy_time" class="col-sm-4 control-label">借出时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="borrow_time" value="{{date("Y-m-d")}}" data-error-container="#error-block" class="form-control datepicker" data-date-end-date = "0d">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_id" class="col-sm-4 control-label">预计归还时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="expect_return_time" value="{{date("Y-m-d")}}" data-error-container="#error-block" class="form-control datepicker" data-date-start-date = "0d">
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">借出处理人<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" value="{{Auth::user()->name}}" disabled class="form-control" data-error-container="#error-block">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_id" class="col-sm-4 control-label">实际归还时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" disabled value="{{date("Y-m-d")}}" data-error-container="#error-block" class="form-control datepicker" data-date-end-date = "0d">
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">归还处理人<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" disabled class="form-control" data-error-container="#error-block" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <div class="form-group">
                    <label for="remarks" class="col-sm-2 control-label">说明</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="remarks" rows="2" style="resize: none;" placeholder="备注说明 ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <a class="btn btn-info" href="{{url('borrow/slt_asset')}}"  data-toggle="modal" data-target=".bs-example-modal-md" >选择资产</a>
            <a href="javascript:;" class="btn btn-info" id="dlt-asset" >删除</a>
        </div>

        <div class="row" style="overflow:auto;height:195px;margin-top:10px;">
            <table id="borrow_asset" class="table table-striped table-bordered table-hove">
                <thead>
                <tr>
                    <th class="dialogtableth"><input type="checkbox" id="all" ></th>
                    {{--<td class="dialogtableth">照片</td>--}}
                    <th class="dialogtableth">资产条码</th>
                    <th class="dialogtableth">资产名称</th>
                    <th class="dialogtableth">资产类别</th>
                    <th class="dialogtableth">规格型号</th>
                    <th class="dialogtableth">金额(元)</th>
                    <th class="dialogtableth">所在场地</th>
                </tr>
                </thead>
                <tbody>

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
                    url:"{{url('borrow')}}",
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

    $(document).ready(function () {
        $("#all").click(function(){
            if(this.checked){
                $("#borrow_asset :checkbox").prop("checked", true);
            }else{
                $("#borrow_asset :checkbox").prop("checked", false);
            }
        });

        $("#dlt-asset").click(function () {
            $("#borrow_asset input[type='checkbox']:checked").each(function() {
                //判断
                if($(this).val()!="on"){
                    $(this).parents('tr').remove();
                }
            });

        });
    })
</script>
