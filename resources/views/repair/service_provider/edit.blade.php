<div class="ibox">
    <div class="ibox-title">
        <h5>修改服务商</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
            修改服务商的基本信息。
        </p>

        <div class="dd" id="nestable2">
            <form class="form-horizontal" action="{{url('repair/service_provider/'.$data->id)}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>服务商名称<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->name}}"
                               name="name" placeholder="服务商名称">
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>负责人姓名<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->user}}"
                               name="user" placeholder="负责人姓名">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>负责人电话<i>*</i></label>
                        <input type="number" class="form-control"
                               value="{{$data->tel}}" name="tel"
                               placeholder="负责人电话">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>服务商logo</label> <br>
                        @if ($data['logo_id']!==null)
                            <img id="thumb_img" src="{{get_img_path($data['logo_id'])}}" alt="" class="img-lg">
                        @else
                            <img id="thumb_img" src="{{url('img/noavatar.png')}}" alt="" class="img-lg">
                        @endif
                        <input type="hidden" name="upload_id" value="">
                        <br>
                        <input type="hidden" id="upload_id" name="logo_id" value="{{$data['logo_id']}}">
                        <div id="single-upload" class="btn-upload m-t-xs">
                            <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 选择图片</div>
                            <div id="single-upload-file-list"></div>
                        </div>

                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>服务商简介</label>
                        <textarea name="comment"  class="form-control"   rows="3">{!! $data->comment !!}</textarea>
                    </div>
                </li>
                <li>
                    <button type="submit" class="btn btn-success">修改</button>
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


        $('.i-checkbox').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
        var l = $("button[type='submit']").ladda();
        var forms = $(".form-horizontal");
        /*字段验证*/
        forms.validate(
            {
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 40
                    },
                    user: {
                        required: true,
                        minlength: 2,
                        maxlength: 20
                    },
                    tel: {
                        required: true,
                        phoneUS: true
                    },
                    comment: {
                        maxlength: 2000
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
                                zjb.backUrl('{{url('repair/service_provider')}}', 1000);
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