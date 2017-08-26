<meta charset="UTF-8">
<div class="ibox" >
    <div class="ibox-title">
        <h5>分类操作</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
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
                <form class="form-horizontal" action="{{url('repair/classify')}}" method="post">
                    {{csrf_field()}}
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>分类名称<i>*</i></label>
                            <input type="text" required maxlength="20" class="form-control" value=""
                                   name="name" placeholder="分类名称">
                        </div>
                    </li>

                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>分类备注</label>
                            <input type="text" class="form-control" value="" name="comment"
                                   placeholder="分类备注">
                        </div>
                    </li>

                    <li class="dd-item  hide">
                        <div class="dd-handle ">
                            <label>分类图标</label>
                            <input type="text" class="form-control" value="fa fa-cogs"
                                   name="icon" placeholder="分类图标">
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>分类排序</label>
                            <input type="number" class="form-control" value="0" name="sorting"
                                   placeholder="分类排序">
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