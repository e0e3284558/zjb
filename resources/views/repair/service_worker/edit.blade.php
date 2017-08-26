<meta charset="UTF-8">
<div class="ibox">
    <div class="ibox-title">
        <h5>修改维修工信息</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
            修改维修工的基本信息，并且设置维修工登录该系统的帐号及密码。
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
                <form action="{{url('repair/service_worker/'.$data->id)}}" method="post">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>帐号<i>*</i></label>
                            <input type="text"  required minlength="6" maxlength="20"  class="form-control" value="{{$data->username}}" name="username"
                                   placeholder="维修工帐号">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>密码<i>*</i></label>
                            <input type="password"  minlength="6"  maxlength="20"  class="form-control" value="" name="password"
                                   placeholder="如果不更改密码，则不需填写">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工姓名<i>*</i></label>
                            <input type="text" class="form-control"  required minlength="2" maxlength="10"  value="{{$data->name}}" name="name"
                                   placeholder="维修工姓名">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工电话<i>*</i></label>
                            <input type="text" class="form-control" required minlength="11" maxlength="11"  value="{{$data->tel}}" name="tel"
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
<script>
    $(document).ready(function () {
        $('.i-checkbox').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
    })
</script>