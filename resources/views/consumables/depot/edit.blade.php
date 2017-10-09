<meta charset="UTF-8">
<div class="ibox">
    <div class="ibox-title">
        <h5>仓库管理-添加仓库</h5>
    </div>
    <div class="ibox-content">
        <div class="dd" id="nestable2">
            <form class="form-horizontal" action="{{url('consumables/depot/'.$data->id)}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <li class="dd-item">
                    <div class="dd-handle">
                        <label>仓库名称<i>*</i></label>
                        <input type="text" class="form-control" value="{{$data->name}}"
                               name="name" placeholder="仓库名称">
                    </div>
                </li>
                <li class="dd-item">
                    <div class="dd-handle">
                        <label>仓库编号</label>
                        <input type="text" class="form-control" value="{{$data->coding}}" name="coding"
                               placeholder="仓库编号">
                    </div>
                </li>
                <li>
                    <input type="hidden" name="org_id" value="{{get_current_login_user_org_id()}}">
                    <button type="submit" class="btn btn-success">编辑</button>
                    <button type="button" class="btn btn-warning" onclick="add('{{url('consumables/depot/create')}}')">
                        取消
                    </button>
                </li>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
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
                    coding: {
                        required: true,
                        minlength: 2,
                        maxlength: 191
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
                                zjb.backUrl('{{url('consumables/depot')}}', 1000);
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