<div class="ibox">
    <div class="ibox-title">
        <h5>添加维修工</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
            输入维修工的基本信息，并且设置维修工登录该系统的帐号及初始密码。

        </p>

        <div class="dd" id="nestable2">
            <form class="form-horizontal" action="{{url('repair/service_worker')}}" method="post">
                {{csrf_field()}}
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>帐号<i>*</i></label>
                        <input type="text" id="username" class="form-control"
                               value="{{old('username')}}"
                               name="username" placeholder="维修工帐号">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>密码<i>*</i></label>
                        <input type="password" class="form-control"
                               value="{{old('password')}}"
                               name="password" placeholder="维修工密码">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工姓名<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{old('name')}}"
                               name="name" placeholder="维修工姓名">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工电话<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{old('tel')}}" name="tel"
                               placeholder="维修工电话号码">
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工照片</label>
                        <img id="thumb_img" src="{{url('img/noavatar.png')}}" alt="" class="img-lg">
                        <input type="hidden" id="upload_id" name="upload_id" value="">
                        <div id="single-upload" class="btn-upload m-t-xs">
                            <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 选择图片</div>
                            <div id="single-upload-file-list"></div>
                        </div>
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工维修种类</label>
                        @foreach($data as $k=>$v)
                            <label class="checkbox-inline icheck">
                                <input type="checkbox" name="classify[]"
                                       <?php if (old("classify[$k]")) {
                                           echo 'checked';
                                       }
                                       ?> value="{{$v->id}}"> {{$v->name}}
                            </label>
                        @endforeach
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>所属服务商</label>
                        <div>
                            <select name="serviceProvider" class="form-control select2 ">
                                <option value="">请选择服务商</option>
                                @foreach($serviceProvider as $v)
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </li>


                <li>
                    <input type="hidden" name="org_id" value="{{Auth::user()->or}}">
                    <button type="submit" class="btn btn-success">添加</button>
                </li>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        zjb.singleImageUpload({
            uploader: 'singleUpload',
            picker: 'single-upload',
            swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
            server: '{{ route("image.upload") }}',
            formData: {
                '_token': '{{ csrf_token() }}'
            },
            errorMsgHiddenTime: 2000,

            uploadSuccess: function (file, response) {
                //上传完成触发时间
                $('#upload_id').val(response.data.id);
                $('#thumb_img').attr({src: response.data.url});
                window.setTimeout(function () {
                    $('#' + file.id).remove();
                }, 2000);
            }
        });


        zjb.initAjax();
        var l = $("button[type='submit']").ladda();
        var forms = $(".form-horizontal");
        /*字段验证*/
        forms.validate(
            {
                rules: {
                    username: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    name: {
                        required: true
                    },
                    tel: {
                        required: true,
                        phoneUS: true
                    }
                },
                /*ajax提交*/
                submitHandler: function (form) {

                    jQuery.ajax({
                        url: forms.attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: forms.serialize(),
                        beforeSend: function () {
                            l.ladda('start');
                        },
                        complete: function (xhr, textStatus) {
                            l.ladda('stop');
                        },
                        success: function (data, textStatus, xhr) {
                            if (data.status) {
                                toastr.success(data.message);
                                zjb.backUrl('{{url('repair/service_worker')}}', 1000);
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
                    });
                    return false;
                }
            }
        );
    });


</script>