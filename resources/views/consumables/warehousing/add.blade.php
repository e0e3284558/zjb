<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">物品归档</h4>
</div>

<div class="modal-body">
    <!-- form start -->
    <form action="" method="post" class="form-horizontal" id="inboundForm">

        {{csrf_field()}}
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">入库单号</label>
                        <div class="col-sm-8">
                            <input type="text" name="receipt_number" class="form-control" placeholder="入库单号" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">入库仓库</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="depot_id">
                                @foreach($depot as $v)
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">业务时间<span class="font-red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="buy_time" value="{{date("Y-m-d")}}"
                                   data-error-container="#error-block" class="form-control datepicker"
                                   data-date-date="0d">
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">供应商</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="supplier" placeholder="供应商">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">经办人</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"
                                   value="{{get_current_login_user_info(true)->username}}" disabled>
                            <input type="hidden" class="form-control" name="user_id"
                                   value="{{get_current_login_user_info()}}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">经办时间</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled name="handle_date"
                                   value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">入库备注</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="enter_comment" placeholder="入库备注">
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <a class="btn btn-info" href="{{url('consumables/warehousing/add_foods')}}"
                   data-toggle="modal" data-target=".bs-example-modal-md">选择物品</a>
                <a href="javascript:;" class="btn btn-info" id="delete-goods">删除</a>
            </div>

            <div class="row" style="overflow:auto;height:195px;margin-top:10px;">
                <table id="add-goods" class="table table-striped table-bordered table-hove">
                    <thead>
                    <tr>
                        <td class="dialogtableth">
                            <input type="checkbox" id="all" >
                        </td>
                        <td class="dialogtableth" style="min-width: 70px">物品编码</td>
                        <td class="dialogtableth" style="min-width: 70px">物品名称</td>
                        <td class="dialogtableth" style="min-width: 70px">商品条码</td>
                        <td class="dialogtableth" style="min-width: 70px">规格型号</td>
                        <td class="dialogtableth" style="min-width: 70px">单位</td>
                        <td class="dialogtableth" style="min-width: 120px">入库数量</td>
                        <td class="dialogtableth" style="min-width: 120px">入库单价</td>
                        <td class="dialogtableth" style="min-width: 200px">备注</td>
                        <td class="dialogtableth" style="min-width: 100px">安全库存下限</td>
                        <td class="dialogtableth" style="min-width: 100px">安全库存上限</td>
                    </tr>
                    </thead>
                    <tbody data-bind="foreach: selectedAssetList">
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<!-- /.box-body -->

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" onclick="storeForm()">保存</button>
</div>

<script>

    $(document).ready(function () {
        zjb.initAjax();
        $('.datepicker').datepicker({
            language: "zh-CN",
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $("#all").click(function () {
            if (this.checked) {
                $("#add-goods :checkbox").prop("checked", true);
            } else {
                $("#add-goods :checkbox").prop("checked", false);
            }
        });

        $("#delete-goods").click(function () {
            $("#add-goods input[type='checkbox']:checked").each(function () {
                //判断
                if ($(this).val() != "on") {
                    $(this).parents('tr').remove();
                }
            });
        });


    });

    function storeForm() {
        $.ajax({
            url: "{{url('consumables/warehousing')}}",
            data: $('#inboundForm').serialize(),
            type: "post",
            dataType: "json",
            beforeSend: function () {
                $('#inboundForm').toggleClass('sk-loading');
            },
            error: function (xhr, textStatus, errorThrown) {
                if (xhr.status == 422 && textStatus == 'error') {
                    _$error = xhr.responseJSON.errors;
                    $.each(_$error, function (i, v) {
                        toastr.error(v[0], '警告');
                    });
                } else {
                    toastr.error('请求出错，稍后重试', '警告');
                }
            },
            complete: function () {
                zjb.unblockUI('.modal-content');
            },
            success: function (data) {
                if (data.status) {
                    toastr.success(data.message);
                    location.reload(true);
                } else {
                    toastr.error(data.message, '警告');
                }
            }
        });
        return false;
    }


</script>