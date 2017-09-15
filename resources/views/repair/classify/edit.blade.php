<meta charset="UTF-8">

<div class="ibox ">
    <div class="ibox-title">
        <h5>分类操作-修改分类</h5>
    </div>
    <div class="ibox-content">

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
                <li class="dd-item">
                    <div class="dd-handle ">
                        <div class="pull-left">
                            <label>是否启用</label>
                        </div>
                        <div class=" icheck pull-left" style="margin-right: 10px"><label>
                                <input type="radio" value="1" name="enabled" @if($data->enabled) checked="" @endif>
                                <i></i> 启用
                            </label>
                        </div>
                        <div class="icheck"><label> <input type="radio" name="enabled" value="0"
                                                           @if(!$data->enabled) checked="" @endif> <i></i>禁用
                            </label>
                        </div>

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

<script>
    $(document).ready(function () {
        zjb.initAjax();
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
                    comment: {
                        maxlength: 191
                    },
                    sorting: {
                        number: true,
                        digits: true,
                        range: [0, 100000]
                    },
                    enabled: {
                        number: true,
                        digits: true,
                        range: [0, 9]
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
                                zjb.backUrl('{{url('repair/classify')}}', 1000);
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
    })
</script>