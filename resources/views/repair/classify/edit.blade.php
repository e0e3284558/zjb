<meta charset="UTF-8">

<div class="ibox ">
    <div class="ibox-title">
        <h5>分类操作</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
            @if (count($errors) > 0)
                <script type="text/javascript">
                    $(document).ready(function () {
                        @foreach ($errors->all() as $error)
                        toastr.error('{{$error}}');
                        @endforeach
                    });
                </script>
            @endif

            </p>

            <div class="dd" id="nestable2">
                <form class="form-horizontal" action="{{url('repair/classify/'.$data->id)}}" method="post">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <li class="dd-item">
                        <div class="dd-handle">
                            <label>分类名称<i>*</i></label>
                            <input type="text" class="form-control" name="name" value="{{$data->name}}"
                                   placeholder="分类名称">
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>分类备注</label>
                            <input type="text" class="form-control" name="comment" value="{{$data->comment}}"
                                   placeholder="分类备注">
                        </div>
                    </li>

                    <li class="dd-item hide">
                        <div class="dd-handle">
                            <label>分类图标</label>
                            <input type="text" class="form-control" name="icon" value="{{$data->icon}}"
                                   placeholder="分类图标">
                        </div>
                    </li>
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>分类排序</label>
                            <input type="number" class="form-control" value="0" value="{{$data->sorting}}"
                                   name="sorting"
                                   placeholder="分类排序">
                        </div>
                    </li>
                    <li>
                        <button type="submit" class="btn btn-success">编辑</button>
                        <button type="button" class="btn btn-warning" onclick="add('{{url('repair/classify/create')}}')">
                            取消
                        </button>
                    </li>
                </form>
            </div>
    </div>
</div>
