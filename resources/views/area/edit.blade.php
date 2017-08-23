<div class="modal-header">
    <a style="float: right;" href="javascript:;" onclick="dlt('{{$info->id}}')" >删除</a>
    <a style="float: right;margin: 0px 10px;" href="javascript:;" onclick="adds('{{$info->id}}')" >添加子类</a>
    <h4 class="modal-title" id="myModalLabel">编辑类别信息</h4>
</div>
<form id="signupForm1" class="form-horizontal ibox-content" method="post" >
    <div class="sk-spinner sk-spinner-double-bounce">
        <div class="sk-double-bounce1"></div>
        <div class="sk-double-bounce2"></div>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{$info->id}}" >
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="firstname1">类别名称<span style=" color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="name" value="{{$info->name}}" class="form-control" placeholder="区域名称">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
</form>

<script type="text/javascript">
    $( document ).ready( function () {
        $( "#signupForm1" ).validate( {
            rules: {
                name: "required"
            },
            messages: {
                name: "请输出类别名称"
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                element.parents( ".col-sm-8" ).addClass( "has-feedback" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else {
                    error.insertAfter( element );
                }
                if ( !element.next( "span" )[ 0 ] ) {
                    $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
                }
            },
            success: function ( label, element ) {
                // Add the span element, if doesn't exists, and apply the icon classes to it.
                if ( !$( element ).next( "span" )[ 0 ] ) {
                    $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".col-sm-8" ).addClass( "has-error" ).removeClass( "has-success" );
                $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
            },
            unhighlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".col-sm-8" ).addClass( "has-success" ).removeClass( "has-error" );
                $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
            },
            submitHandler: function () {
                //表单验证之后ajax上传数据
                $.ajax({
                    url:"{{url('asset_category/'.$info->id)}}",
                    data:$('#signupForm1').serialize(),
                    type:"post",
                    dataType:"json",
                    beforeSend:function () {
                        zjb.blockUI();
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
                        zjb.unblockUI();
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
        });

    });
    /*删除*/
    function dlt(id){
    swal({
            title: "确认要删除该资产类别吗？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "是的, 确认删除!",
            closeOnConfirm: false
        },
        function(){
            //发异步删除数据
            $.ajax({
                type:"post",
                url:'{{url('asset_category')}}'+'/'+id,
                data:{
                    "_token":'{{csrf_token()}}',
                    '_method':'delete'
                },
                dataType:"json",
                success: function (data) {
                    if(data.code==1){
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
            });
        });

    }


    /*加载添加视图*/
    function adds(id) {
        $.ajax({
            url:'{{url('asset_category/add_son')}}/'+id,
            type:"get",
            success:function (data) {
                $("#right_content").html(data);
            }
        })
    }
</script>