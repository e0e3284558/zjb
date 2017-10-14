<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">合同清单列表</h4>
</div>
<div class="modal-body">
<div class="table-responsive">
    <button class="btn btn-danger btn-xs" onclick="bill_del()">删除</button>
    <table  class="table table-striped  table-bordered"  lay-filter="asset-table">
        <thead>
        <tr role="row">
            <th><input type="checkbox" class="i-checks" name="checkAll" id="all" ></th>
            <th>资产名称</th>
            <th>数量</th>
            <th style="width: 200px;" >资产类别</th>
            <th>规格型号</th>
            <th>计量单位</th>
            <th>单价(元)</th>
            <th style="width: 150px;">供应商</th>
        </tr>
        </thead>
        <tbody>
            @if(count($list)>0)
                @foreach($list as $value)
                    <tr role="row">
                        <td role="gridcell">
                            <input type="checkbox" class="i-checks" name="id" value="{{$value->id}}">
                        </td>
                        <td>{{$value->asset_name}}</td>
                        <td>{{$value->num}}</td>
                        <td>{{$value->category->name}}</td>
                        <td>{{$value->spec}}</td>
                        <td>{{$value->calculate}}</td>
                        <td>{{$value->money}}</td>
                        <td>{{$value->supplier->name}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="text-align: center" >暂无数据</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>

<script type="text/javascript" >

        $("document").ready(function () {
            $('.i-checks,#all').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });
            $('#all').on('ifChecked ifUnchecked', function(event){
                if(event.type == 'ifChecked'){
                    $('.i-checks').iCheck('check');
                }else{
                    $('.i-checks').iCheck('uncheck');
                }
            });
        });

        function bill_del() {
            if($("tbody input[type='checkbox']:checked").length >= 1){

                var arr = [];
                $("tbody input[type='checkbox']:checked").each(function() {
                    //判断
                    var id = $(this).val();
                    arr.push(id);
                });

                swal({
                        title: "确认要删除这些清单吗？",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: "取消",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },
                    function(){
                        //发异步删除数据
                        $.ajax({
                            type: "post",
                            url: '{{url('contract/bill_del')}}',
                            data: {
                                "_token": '{{csrf_token()}}',
                                'ids':arr
                            },
                            dataType:"json",
                            success: function (data) {
                                if(data.status==1){
                                    swal({
                                        title: "",
                                        text: data.message,
                                        type: "success",
                                        timer: 1000,
                                    },function () {
                                        window.location.reload();
                                    });
                                }else{
                                    swal("", data.message, "error");
                                }
                            }
                        });
                    });
            }else if($("tbody input[type='checkbox']:checked").length == 0){
                $(".modal-content").html(str("请选择清单"));
            }
        }
</script>