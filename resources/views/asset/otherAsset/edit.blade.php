<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产新增</h4>
</div>
<form id="signupForm1" class="form-horizontal ibox-content" method="post" enctype="multipart/form-data" >
    <div class="sk-spinner sk-spinner-double-bounce">
        <div class="sk-double-bounce1"></div>
        <div class="sk-double-bounce2"></div>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-sm-6" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">资产类别<span style="color:red;">*</span></label>
                    <div class="col-sm-9">
                        <select name="category_id" onchange="find(this.value)" id="type_id" class="form-control">
                            <option value=""></option>
                            @foreach($list as $value)
                                @if($info->category_id == $value->id)
                                    <option selected value="{{$value->id}}">{{$value->name}}</option>
                                @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">资产名称<span style="color:red;">*</span></label>

                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" id="inputEmail3" value="{{$info->name}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-8" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">备注</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" name="remarks" rows="3" style="height: 120px;resize: none;" placeholder="备注说明 ...">{{$info->remarks}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" >
                <div class="form-group">
                    <label for="Comment" class="col-sm-4 control-label">照片</label>
                    <div class="col-sm-8">

                        <!--dom结构部分-->
                        <div id="uploader-demo">
                            @if($file)
                                <img id="thumb_img" src="{{$file->path}}" alt="" width="160px" height="120px">
                            @else
                                <img id="thumb_img" src="{{url('img/nopicture.jpg')}}" alt="" width="160px" height="120px">
                            @endif
                            <!--用来存放item-->
                            <div id="fileList" class="uploader-list"></div>
                            <div id="filePicker">选择图片</div>
                            <input type="hidden" id="upload_id" name="img" value="{{$file->id}}">
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
        $('.datepicker').datepicker({
            language: "zh-CN",
            format: 'yyyy/mm/dd',
            autoclose:true
        });
        
        $( "#signupForm1" ).validate( {
            rules: {
                category_id:"required",
                name:"required"
            },
            messages: {
                category_id:"资产类别不能为空",
                name:"资产名称不能为空"
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
                    url:"{{url('other_asset/'.$info->id)}}",
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
    //查看是否还有子部门
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
                }
            }
        })
    }
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
