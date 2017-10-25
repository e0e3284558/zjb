<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">入库单详情</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
        <tr role="row">
            <td class="td-bg" ><label class="control-label">入库单号</label></td>
            <td>{{$warehousing->receipt_number}}</td>
            <td class="td-bg" ><label class="control-label">入库仓库</label></td>
            <td>{{$warehousing->depot->name}}</td>
            <td class="td-bg" ><label class="control-label">经办人</label></td>
            <td>{{$warehousing->user->username}}</td>
        </tr>
        <tr role="row">
            <td class="td-bg" ><label class="control-label">入库日期</label></td>
            <td>{{$warehousing->receipt_date}}</td>
            <td class="td-bg" ><label class="control-label">经办日期</label></td>
            <td>{{$warehousing->handle_date}}</td>
            <td  colspan="2" class="td-bg" ><label class="control-label"></label></td>
        </tr>
        <tr role="row">
            <td class="td-bg" ><label class="control-label">备注</label></td>
            <td colspan="5" >{{$warehousing->comment}}</td>
        </tr>
        </tbody>
    </table>

    <div class="col-sm-12" style="overflow:auto;height:195px;margin-top:10px;">
        <table class="table table-striped table-bordered table-hove">
            <thead>
            <tr>
                <td class="dialogtableth td-min">物品名称</td>
                <td class="dialogtableth td-min">物品编码</td>
                <td class="dialogtableth td-min">物品条码</td>
                <td class="dialogtableth td-min">物品规格型号</td>
                <td class="dialogtableth td-min">物品单位</td>
                <td class="dialogtableth td-min">物品批次</td>
                <td class="dialogtableth td-min">入库数量</td>
                <td class="dialogtableth td-min">入库单价</td>
                <td class="dialogtableth td-min">入库总价</td>
                <td class="dialogtableth td-min">备注</td>
            </tr>
            </thead>
            <tbody data-bind="foreach: selectedAssetList">
            @foreach($details as $value)
                <tr>
                    <td>{{$value->goods_name}}</td>
                    <td>{{$value->goods_coding}}</td>
                    <td>{{$value->goods_barcode}}</td>
                    <td>{{$value->goods_norm}}</td>
                    <td>{{$value->goods_unit}}</td>
                    <td>{{$value->goods_batch}}</td>
                    <td>{{$value->goods_num}}</td>
                    <td>{{$value->goods_unit_price}}</td>
                    <td>{{$value->goods_total_price}}</td>
                    <td>{{$value->comment}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>