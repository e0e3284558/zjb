<meta charset="UTF-8">
<div class="ibox">
    <div class="ibox-title">
        <h5>修改维修工信息</h5>
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
                               placeholder="维修工帐号">
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
                        <label>维修工姓名<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->name}}" name="name"
                               placeholder="维修工姓名">
                    </div>
                </li>

                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工电话<i>*</i></label>
                        <input type="text" class="form-control"
                               value="{{$data->tel}}" name="tel"
                               placeholder="维修工电话号码">
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工照片</label>
                        {{--<img src="{{$v->upload_id}}" alt="">--}}
                        <button class="btn">点击上传并更新</button>
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>维修工维修种类</label>
                        @foreach($classifies as $k=>$v)
                            <label class="checkbox-inline i-checkbox">
                                <input type="checkbox" name="classify[]"
                                       @if(in_array($v->id ,$ids)) checked @endif
                                       value="{{$v->id}}"/> {{$v->name}}
                            </label>
                        @endforeach
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle ">
                        <label>所属服务商</label>
                        <div>
                            @foreach($serviceProvider as $v)
                                <label class="radio-inline i-checks">
                                    <input type="radio" name="serviceProvider" class="icheck"
                                           @if($v->id==$service_provider_id) checked @endif
                                           value="{{$v->id}}">{{$v->name}}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </li>
                <li>
                    <input type="hidden" name="org_id" value="{{session('org_id',0)}}">
                    <button type="submit" class="btn btn-success">编辑</button>
                    <button type="button" class="btn btn-warning"
                            onclick="add('{{url('repair/service_worker/')}}')">
                        取消
                    </button>
                </li>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
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