<div class="ibox">
    <div class="ibox-title">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <h5>填写批量维修结果</h5>
    </div>
    <div class="ibox-content">
        <div class="dd" id="nestable2">
            <form class="form-horizontal" action='{{url("repair/create_repair/batch_success_store")}}' method="post">
                {{csrf_field()}}
                <input type="hidden" value="{{$str}}" name="str">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-sm-3">选择维修结果：</div>
                            <div class="col-sm-9">
                                <div class=" icheck pull-left" style="margin-right: 10px"><label>
                                        <input type="radio" value="5" name="status" checked="">
                                        <i></i> 已修好
                                    </label>
                                </div>
                                <div class=" icheck pull-left"><label> <input type="radio" name="status" value="0"> <i></i>取消工单
                                    </label>
                                </div>
                                <div class=" icheck pull-left"><label> <input type="radio" name="status" value="1"> <i></i>重新分派
                                    </label>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">填写维修记录：</div>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="result" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3">
                                <button class="btn btn-success">确认</button>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        zjb.initAjax();
        var l = $("button[type='submit']").ladda();
        var forms = $(".form-horizontal");
        /*字段验证*/
        forms.validate(
            {
                rules: {
                    status: {
                        required: true,
                        number: true,
                        digits: true,
                    },
                    result: {
                        maxlength: 400
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
                                zjb.backUrl('{{url('repair/create_repair')}}', 1000);
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