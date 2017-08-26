<meta charset="UTF-8">
<div class="ibox">
    <div class="ibox-title">
        <h5>添加维修工</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
            输入维修工的基本信息，并且设置维修工登录该系统的帐号及初始密码。
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            </p>

            <div class="dd" id="nestable2">
                <form class="form-horizontal" action="{{url('repair/service_worker')}}" method="post">
                    {{csrf_field()}}
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>帐号<i>*</i></label>
                            <input type="text" required minlength="6" maxlength="20" class="form-control" value="{{old('username')}}"
                                   name="username" placeholder="维修工帐号">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>密码<i>*</i></label>
                            <input type="password" required minlength="6" maxlength="20" class="form-control" value="{{old('password')}}"
                                   name="password" placeholder="维修工密码">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工姓名<i>*</i></label>
                            <input type="text" required minlength="2" maxlength="10" class="form-control" value="{{old('name')}}"
                                   name="name" placeholder="维修工姓名">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工电话<i>*</i></label>
                            <input type="text" required minlength="11" maxlength="11" class="form-control"
                                   value="{{old('tel')}}" name="tel"
                                   placeholder="维修工电话号码">
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工照片</label>
                            <input type="hidden" name="upload_id" value="">
                            <button class="btn" type="button">点击上传</button>
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工维修种类</label>
                            @foreach($data as $k=>$v)
                                <label class="checkbox-inline i-checkbox">
                                    <input type="checkbox" name="classify[]"
                                           <?php if (old("classify[$k]")) {
                                               echo 'checked';
                                           }
                                           ?> value="{{$v->id}}"> {{$v->name}}
                                </label>
                            @endforeach
                        </div>
                    </li>
                    <li>
                        <input type="hidden" name="org_id" value="{{session('org_id',0)}}">
                        <button type="submit" class="btn btn-success">添加</button>
                    </li>
                </form>
            </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.i-checkbox').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
    });

    /*字段验证*/
    $(document).ready(function () {
        $(".form-horizontal").validate(
            {
                submitHandler: function () {
                    /*ajax提交*/
                    submitHandler: function (form) {
                        jQuery.ajax({
                            url: forms.attr('action'),
                            type: 'POST',
                            dataType: 'json',
                            data: forms.serialize(),
                            beforeSend: function(){
                                l.ladda('start');
                            },
                            complete: function(xhr, textStatus) {
                                l.ladda('stop');
                            },
                            success: function(data, textStatus, xhr) {
                                if(data.status){
                                    toastr.success(data.message);
                                    $.get('{{ url("repair/service_worker/create") }}', {}, function(data){
                                        $('#dep-form-wrapper').html(data);
                                    });
                                }else{
                                    toastr.error(data.message,'警告');
                                }
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                if(xhr.status == 422 && textStatus =='error'){
                                    $.each(xhr.responseJSON,function(i,v){
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
            }
        );
    });


</script>