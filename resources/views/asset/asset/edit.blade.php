<style>
    .form-group{
        overflow: auto;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产信息修改</h4>
</div>
<form id="signupForm1" class="form-horizontal ibox-content" method="post" >

    <div class="sk-spinner sk-spinner-double-bounce">
        <div class="sk-double-bounce1"></div>
        <div class="sk-double-bounce2"></div>
    </div>

    <div class="modal-body">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">资产条码</label>
                    <div class="col-sm-8">
                        <input type="text" name="asset_code" disabled value="{{$info->code}}" class="form-control" id="inputEmail3" placeholder="资产条码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">规格型号</label>

                    <div class="col-sm-8">
                        <input type="text" name="spec" value="{{$info->spec}}" class="form-control" id="inputEmail3" placeholder="规格型号">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">金额</label>
                    <div class="col-sm-8">
                        <input type="text" name="money" value="{{$info->money}}" class="form-control" id="inputEmail3" placeholder="金额">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">供应商</label>

                    <div class="col-sm-8">
                        <input type="text" name="supplier" value="{{$info->supplier}}" class="form-control" id="inputEmail3" placeholder="供应商">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">使用期限</label>

                    <div class="col-sm-8">
                        <input type="text" name="use_time" value="{{$info->use_time}}" class="form-control" id="inputEmail3" placeholder="使用期限">
                    </div>
                </div>

            </div>
            <div class="col-sm-4" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">资产类别<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <select name="category_id" onchange="finds(this.value)" id="type_sel" class="form-control">
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
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">SN号</label>

                    <div class="col-sm-8">
                        <input type="text" name="SN_code" value="{{$info->SN_code}}" class="form-control" id="inputEmail3" placeholder="SN号">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">使用人</label>

                    <div class="col-sm-8">
                        <input type="text" name="user_id" value="{{$info->user_id}}" class="form-control" id="inputEmail3" placeholder="使用人">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">所在场地<span style="color:red;">*</span></label>

                    <div class="col-sm-8">
                        <select name="area_id" class="form-control">
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

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">购入时间<span style="color:red;">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" disabled name="buy_time" value="{{date("Y/m/d")}}" class="form-control datepicker" data-date-end-date = "0d">
                    </div>
                </div>


            </div>
            <div class="col-sm-4" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">资产名称<span style="color:red;">*</span></label>

                    <div class="col-sm-8">
                        <input type="text" name="name" value="{{$info->name}}" class="form-control" id="inputEmail3" placeholder="资产名称">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">计量单位</label>

                    <div class="col-sm-8">
                        <input type="text" name="calculate" value="{{$info->calculate}}" class="form-control" id="inputEmail3" placeholder="计量单号">
                    </div>
                </div>
                <div class="form-group" style="position: relative;" >
                    <label for="inputEmail3" class="col-sm-4 control-label">使用部门</label>

                    <div class="col-sm-8">
                        <select id="use_department_id" name="use_department_id" class="form-control">
                            @foreach($list6 as $v)
                                @if($v->id== $info->use_department_id)
                                    <option selected value="{{$v->id}}">{{$v->name}}</option>
                                @else
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <a class="" data-toggle="tooltip" data-placement="bottom" style="font-size:14px; text-decoration:underline; cursor:pointer; position:absolute; right:0px; top:8px;" title="" data-original-title="如果 &quot; 使用部门&quot; 和 &quot;使用人&quot; 为空，系统将自动设置资产状态为 &quot;闲置&quot;"><i class="fa fa-question-circle" style="margin-right:6px;"></i></a>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">管理员</label>

                    <div class="col-sm-8">
                        <select name="admin_id" class="form-control">
                            @foreach($list3 as $v)
                                @if($info->admin_id == $v->admin)
                                    <option value="{{$v->id}}" selected>{{$v->name}}</option>
                                @else
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">来源</label>
                    <div class="col-sm-8">
                        <select name="source_id" class="form-control">
                            @foreach($list5 as $v)
                                @if($info->source_id == $v->source_id)
                                    <option value="{{$v->id}}" selected >{{$v->name}}</option>
                                @else
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="col-sm-6" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">资产信息备注</label>

                    <div class="col-sm-8">
                        <textarea class="form-control" name="remarks" rows="3" style="height: 120px;resize: none;" >{{$info->remarks}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" >
                <div class="form-group">
                    <label for="Comment" class="col-sm-4 control-label">照片</label>
                    <div class="col-sm-8">
                        <!--dom结构部分-->
                        <div id="uploader-demo">
{{--                            @if($img_path)--}}
                                {{--<img id="thumb_img" src="{{$img_path}}" alt="" width="130px" height="100px">--}}
                            {{--@else--}}
                                <img id="thumb_img" src="{{url('uploads/imgs/nopicture.jpg')}}" alt="" width="130px" height="100px">
                            {{--@endif--}}
                            <!--用来存放item-->
                            <div id="fileList" class="uploader-list"></div>
                            <div id="filePicker">选择图片</div>
                            <input type="hidden" id="upload_id" name="img" value="{{$info->img}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
</form>

<script type="text/javascript">

    $( document ).ready( function () {

        $( "#signupForm1" ).validate( {
            rules: {
                type_id:"required",
                name:"required",
                money:{
                    number:true,
                    min:0
                },
                use_org_id:"required",
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
                use_org_id:"请选择使用公司",
                use_time: {
                    min: "请输入一个有效整数",
                    digits:"请输入一个正整数"
                }
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );

                // Add `has-feedback` class to the parent div.form-group
                // in order to add icons to inputs
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
<script type="text/javascript">
    //查看是否还有子公司
    function finds(id) {
        $.ajax({
            "url":'{{url('asset/finds')}}'+"/"+id,
            "type":"get",
            'data':{id:id},
            success:function (data) {
                if(data=="还有子类"){
                    $("#type_sel option:first").prop("selected","selected");
                    alert("只能选择子分类....");
                }
            }
        })
    }

    //查找部门
    function seldep(id) {
        $.ajax({
            "url":'{{url('asset/sel')}}'+"/"+id,
            "type":"get",
            'data':{id:id},
            'dataType':"json",
            success:function (data) {
                var select = $("#use_department_id");
                if(data.length>0){
                    select.append("<option value=''>请选择</option>");
                    //遍历
                    for (var i = 0; i < data.length; i++) {
                        //把遍历出来数据添加到option
                        info = '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        //把当前info数据添加到创建的select
                        select.append(info);
                    }
                    //把带有数据的select 追加
                    o.after(select);
                }
            }
        })
    }
</script>

<script type="text/javascript" >
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '{{url("admin/plugins/webuploader/Uploader.swf")}}',
        // 文件接收服务端。
        server: '{{url('upload/uploadFile')}}',
        formData: {"_token": "{{ csrf_token() }}"},
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker1',
        // 只允许选择word文档文件。
        accept: {
            title: 'Images',
            extensions: 'doc,docx',
            mimeTypes: '*'
        }
    });
    uploader.on('uploadSuccess', function (file, response) {
        $('#fileList1').attr('value',response.old_name);
        $('#files').attr('value', response.id);
    });
</script>

<script>
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '{{url("admin/plugins/webuploader/Uploader.swf")}}',
        // 文件接收服务端。
        server: '{{url('upload/uploadFile')}}',
        formData: {"_token": "{{ csrf_token() }}"},
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader.on('uploadSuccess', function (file, response) {
        $('#thumb_img').attr('src', '/' + response.path);
        $('#upload_id').attr('value', response.id);
    });
</script>