<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h5>分派维修人员</h5>
</div>
<form class="form-horizontal" action="" method="post">
    <div class="modal-body">
        <div class="dd" id="nestable2">
            {{csrf_field()}}
            <div class="row">
                <div class="col-lg-12">
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>选择服务商</label>
                            <select name="service_provider_id" id="provider" class="form-control"  onchange="change_classify()">
                                <option value="">-----请选择服务商-----</option>
                                @foreach($serviceProvider as $v)
                                    <option value="{{$v['id']}}">{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                </div>
                <div class="col-lg-12">
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>选择维修人员类型</label>
                            <select name="" id="" class="form-control"
                                    onchange="change_classify(this.value)">
                                <option value="0">-----全部维修工-----</option>
                                @foreach($classify as $v)
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                </div>
                <div class="col-lg-12">
                    <li class="dd-item">
                        <div class="dd-handle ">
                            <label>选择维修人员</label>
                            <select name="service_worker_id" class="form-control" id="service_worker">
                                <option value="">请选择分类信息</option>
                            </select>
                            <input type="hidden" name="id" value="{{$process->id}}">
                        </div>
                    </li>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" onclick="del({{$process->id}})" class="btn btn-warning pull-left">取消工单</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-success" id="btn_action">分配</button>
    </div>
</form>
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
        } else {
            alert('请选择服务商');
        }
    }


    $(document).ready(function () {
        zjb.initAjax();
        var l = $("#btn_action").ladda();
        var forms = $(".form-horizontal");
        /*字段验证*/
        forms.validate(
            {
                rules: {
                    service_provider_id: {
                        required: true,
                        number:true,
                        digits:true
                    },
                    classify_id: {
                        required: true,
                    },
                    service_worker_id: {
                        required: true,
                        number:true,
                        digits:true
                    }
                },
                /*ajax提交*/
                submitHandler: function (form) {
                    jQuery.ajax({
                        url: '{{url('repair/create_repair/confirm_worker')}}',
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

    function del(did) {
        swal({
                title: "确认要废弃这条报修记录吗？",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#777700",
                cancelButtonText: "取消",
                confirmButtonText: "确认",
                closeOnConfirm: false
            },
            function () {
                //发异步删除数据
                $.ajax({
                    type: "post",
                    url: '{{url('repair/create_repair/del')}}/' + did,
                    data: {
                        "_token": '{{csrf_token()}}'
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 1) {
                            swal({
                                title: "",
                                text: data.message,
                                type: "success",
                                timer: 1000,
                            }, function () {
                                window.location.reload();
                            });
                        } else {
                            swal("", data.message, "error");
                        }
                    }
                });
            }
        );
    }

</script>