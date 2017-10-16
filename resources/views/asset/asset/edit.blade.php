
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产信息修改</h4>
</div>
<div class="modal-body">
    <form id="signupForm1" class="form-horizontal" method="post" >

        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PUT">

        <div class="row" >
            <div class="col-md-4" >
                <div class="form-group">
                    <label class="col-sm-4 control-label">资产编号</label>
                    <div class="col-sm-8">
                        <input type="text" name="code" value="{{$info->code}}" class="form-control"  placeholder="资产编号">
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label class="col-sm-4 control-label">资产类别<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <select name="category_id" onchange="finds(this.value)" id="type_sel" class="form-control select2">
                            <option value=""></option>
                            @foreach($list1 as $value)
                                @if($info->category_id==$value->id)
                                    <option value="{{$value->id}}" selected >{{$value->name}}</option>
                                @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">资产名称<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="name" value="{{$info->name}}" class="form-control" id="inputEmail3" placeholder="资产名称">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">购入时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="buy_time" value="{{date("Y-m-d")}}" class="form-control datepicker" data-date-end-date = "0d">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">所在场地<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <select name="area_id" class="form-control select2">
                            @foreach($list4 as $v)
                                @if($info->category_id==$v->id)
                                    <option value="{{$v->id}}" selected >{{$v->name}}</option>
                                @else
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">金额</label>
                    <div class="col-sm-8">
                        <input type="text" name="money" value="{{$info->money}}" class="form-control" id="inputEmail3" placeholder="金额">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">供应商</label>
                    <div class="col-sm-8">
                        <select id="supplier_id" data-error-container="#error-block" name="supplier_id" class="form-control select2">
                            <option value="">请选择</option>
                            @foreach($list7 as $v)
                                @if($v->id==$info->supplier_id)
                                    <option value="{{$v->id}}" selected>{{$v->name}}</option>
                                @else
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">计量单位</label>

                    <div class="col-sm-8">
                        <input type="text" name="calculate" value="{{$info->calculate}}" class="form-control" id="inputEmail3" placeholder="计量单号">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="position: relative;" >
                    <label class="col-sm-4 control-label">所属部门</label>
                    <div class="col-sm-8">
                        <select id="department_id" name="department_id" class="form-control select2">
                            {!! department_select($info->department_id,1) !!}
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8" >
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="remarks" rows="3" style="height: 120px;resize: none;" placeholder="备注说明 ...">{{$info->remarks}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label class="col-sm-4 control-label">照片</label>
                    <div class="col-sm-8">
                        @if($info->img_path)
                            <img id="thumb_img" src="{{url($info->img_path)}}" alt="" width="160px" height="120px">
                        @else
                            <img id="thumb_img" src="{{url('img/nopicture.jpg')}}" alt="" class="img-lg">
                        @endif
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

    $( document ).ready( function () {
        $('.datepicker').datepicker({
            language: "zh-CN",
            format: 'yyyy-mm-dd',
            autoclose:true
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

        zjb.initAjax();
        var assets_form = $( "#signupForm1" );
        var errorInfo = $('.alert-danger', assets_form);
        $('#submitAssetsForm').click(function () {
            assets_form.submit();
        });
        assets_form.validate( {
            rules: {
                type_id:"required",
                name:"required",
                money:{
                    number:true,
                    min:0
                },
                use_time: {
                    min: 1,
                    digits:true
                }
            },
            messages: {
                type_id:"资产类别不能为空",
                name:"资产名称不能为空",
                money:{
                    number:"必须为数值类型",
                    min:"金额必须为大于零的有效数字"
                },
                use_time: {
                    min: "请输入一个有效整数",
                    digits:"请输入一个正整数"
                }
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

                // Add the span element, if doesn't exists, and apply the icon classes to it.
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
                    url:"{{url('asset/'.$info->id)}}",
                    data:assets_form.serialize(),
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