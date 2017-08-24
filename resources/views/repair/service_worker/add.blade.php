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
                <form action="{{url('repair/service_worker')}}" method="post">
                    {{csrf_field()}}
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>帐号<i>*</i></label>
                            <input type="text" class="form-control" value="" name="username" placeholder="维修工帐号">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>密码<i>*</i></label>
                            <input type="password" class="form-control" value="" name="password" placeholder="维修工密码">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工姓名<i>*</i></label>
                            <input type="text" class="form-control" value="" name="name" placeholder="维修工姓名">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工电话<i>*</i></label>
                            <input type="text" class="form-control" value="" name="name" placeholder="维修工电话号码">
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工照片</label>
                            <input type="hidden" name="upload_id" value="">
                            <button class="btn">点击上传</button>
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>维修工维修种类</label>
                            @foreach($data as $v)
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="classify[]" value="{{$v->id}}"> {{$v->name}}
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