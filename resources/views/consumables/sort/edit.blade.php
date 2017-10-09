<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">创建用户</h4>
</div>



<form id="signupForm1" class="form-horizontal  " method="post" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    {{method_field('PUT')}}
    <div class="modal-body">
        <div class="form-group">
            <i class="i-red">*</i>
            <label for="exampleInputEmail1">分类名称</label>
            <input type="text" name="name" value="{{$only->name}}" class="form-control" placeholder="请输入分类名称">
        </div>
        <div class="form-group">
            <i class="i-red">*</i>
            <label for="exampleInputPassword1">选择父类</label>
            <select name="parent_id" id="" class="form-control">
                @if(isset($parent))
                    <option value="{{$parent->id}}">{{$parent->name}}</option>
                @else
                    <option value="0">顶级分类</option>
                @endif
                @foreach($sort as $k=>$v)
                    @if($v->id !==$only->id)
                        <option value="{{$v->id}}">{{$v->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-success blue" id="submitUserForm">保存</button>
    </div>
</form>
<script type="text/javascript">
    $.validator.setDefaults( {

    } );
    $( document ).ready( function () {
        $( "#signupForm1" ).validate( {
            rules: {
                name:{
                    required:true,
                } ,
                name: "required",
            },
            messages: {
                category_code:{
                    required:"请输出类别编号",
                } ,
                name: "请输出类别名称",
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
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
                //表单验证之后ajax上传数据
                $.ajax({
                    url:"{{url('consumables/sort/'.$only->id)}}",
                    data:$('#signupForm1').serialize(),
                    type:"post",
                    dataType:"json",
                    beforeSend:function () {
                        $('#signupForm1').toggleClass('sk-loading');
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
                        $('#signupForm1').toggleClass('sk-loading');
                    },
                    success: function (data, textStatus, xhr) {
                        if (data.status) {
                            toastr.success(data.message);
                            zjb.backUrl('{{url('consumables/sort')}}', 1000);
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
                })
            }
        });

    });
</script>
