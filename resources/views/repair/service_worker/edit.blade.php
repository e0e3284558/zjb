<meta charset="UTF-8">
<div class="ibox">
    <div class="ibox-title">
        <h5>修改维修人员信息</h5>
    </div>
    <div class="ibox-content">
        <div class="dd" id="nestable2">
            <form class="form-horizontal" action="{{url('repair/service_worker/'.$data->id)}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>帐号<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->username}}" name="username"
                               placeholder="维修人员帐号">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>密码<i>*</i></label>
                        <input type="password" class="form-control" value="" name="password"
                               placeholder="如果不更改密码，则不需填写">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修人员姓名<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->name}}" name="name"
                               placeholder="维修人员姓名">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修人员电话<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->tel}}" name="tel"
                               placeholder="维修人员电话号码">
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <img id="thumb_img" src="{{ get_img_path($data->upload_id) }}" alt="" class="img-lg">
                        <input type="hidden" id="upload_id" name="upload_id" value="{{$data->upload_id}}">
                        <div id="single-upload" class="btn-upload m-t-xs">
                            <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 更新图片</div>
                            <div id="single-upload-file-list"></div>
                        </div>
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>擅长维修项目</label>
                        @foreach($classifies as $k=>$v)
                            @if(!$v->deleted_at)
                                <label class="checkbox-inline i-checkbox">
                                    <input type="checkbox" name="classify[]"
                                           @if(@in_array($v->id ,$ids)) checked @endif
                                           @if(!$v->enabled)  disabled @endif
                                           value="{{$v->id}}"/> {{$v->name}}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>所属服务商</label>
                        <div>

                            <select name="serviceProvider" id="type_id" class="form-control select2 ">
                                @if(!$service_provider_id)
                                    <option selected value="0">请选择服务商</option>
                                @endif
                                @foreach($serviceProvider as $v)
                                    @if($service_provider_id == $v->id)
                                        <option selected value="{{$v->id}}">{{$v->name}}</option>
                                    @else
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </li>
                <li>
                    <button type="submit" class="btn btn-success">编辑</button>
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
                    username: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    password: {
                        required: false,
                        minlength: 6,
                        maxlength: 20
                    },
                    name: {
                        required: true
                    },
                    tel: {
                        required: true,
                        maxlength: 20
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
                            if(xhr.status == 422 && textStatus =='error'){
                                _$error = xhr.responseJSON.errors;
                                $.each(_$error,function(i,v){
                                    toastr.error(v[0],'警告');
                                });
                            }else{
                                toastr.error('请求出错，稍后重试','警告');
                            }
                        }
                    });
                    return false;
                }
            }
        );
    });


</script>