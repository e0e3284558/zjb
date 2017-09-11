<div class="ibox">
    <div class="ibox-title">
        <h5>分派维修工</h5>
    </div>
    <div class="ibox-content">
        <p class="m-b-lg">
            手动分派维修工。
        </p>

        <div class="dd" id="nestable2">
            <form class="form-horizontal" action="{{url('repair/create_repair/confirm_worker')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <li class="dd-item">
                                <div class="dd-handle ">
                                    <label>需要维修的资产类型</label>
                                    <input type="text" class="form-control" disabled
                                           value="{{$process->category->name}}">
                                </div>
                            </li>
                        </div>
                        <div class="col-lg-6">
                            <li class="dd-item">
                                <div class="dd-handle ">
                                    <label>选择服务商</label>
                                    <select name="service_provider_id" id="provider" class="form-control">
                                        <option value="">-----请选择服务商-----</option>
                                        @foreach($serviceProvider as $v)
                                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <li class="dd-item">
                                <div class="dd-handle ">
                                    <label>需要维修的资产</label>
                                    <input type="text" class="form-control" disabled value="{{$process->asset->name}}">
                                </div>
                            </li>
                        </div>
                        <div class="col-lg-6">
                            <li class="dd-item">
                                <div class="dd-handle ">
                                    <label>选择维修工类型</label>
                                    <select name="" id="" class="form-control" onchange="change_classify(this.value)">
                                        <option value="">-----请选择类型-----</option>
                                        @foreach($classify as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <li class="dd-item">
                                <div class="dd-handle ">
                                    <label>被维修人备注</label>
                                    <input type="text" class="form-control" disabled value="{{$process->remarks}}">
                                </div>
                            </li>
                        </div>
                        <div class="col-lg-6">
                            <li class="dd-item">
                                <div class="dd-handle ">
                                    <label>选择维修工</label>
                                    <select name="service_worker_id" class="form-control" id="service_worker">
                                        <option value="">请选择分类信息</option>
                                    </select>
                                    <input type="hidden" name="id" value="{{$process->id}}">
                                </div>
                            </li>
                        </div>
                    </div>
                </div>

                <li>
                    <button type="submit" class="btn btn-success">分配</button>
                </li>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function change_classify(id) {
        jQuery("#service_worker").empty();
        var provider;
        //获取当前选中服务商value
        provider = $('#provider').val();
        if (provider != '') {
            $.post("{{url('repair/create_repair/select_worker')}}", {
                '_token': "{{csrf_token()}}",
                'classify_id': id,
                'provider_id': provider
            }, function (data) {
                $('#service_worker').append(data);
            });
        }else{
            alert('请选择服务商');
        }
    }


    $(document).ready(function () {
        zjb.initAjax();
        var l = $("button[type='submit']").ladda();
        var forms = $(".form-horizontal");
        /*字段验证*/
        forms.validate(
            {
                rules: {
                    service_provider_id: {
                        required: true
                    },
                    classify_id: {
                        required: true
                    },
                    service_worker_id: {
                        required: true
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

    });

</script>