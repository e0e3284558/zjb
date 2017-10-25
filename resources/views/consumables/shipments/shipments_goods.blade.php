<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">选择物品</h4>
</div>
<div class="modal-body">

    <div class="row">
        <table class="layui-table" id="addGoods" lay-filter="data-goods-add" lay-data="">
            <thead>
            <tr>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" data-dismiss="modal" id="submitGoodsForm">保存</button>
</div>
<script>

    $(document).ready(function () {
        layui.use('table', function () {
            table1 = layui.table;
            //执行渲染
            table1.render({
                elem: '#addGoods' //指定原始表格元素选择器（推荐id选择器）
                , height: 410 //容器高度
                , cols: [[
                    {fixed: 'left', checkbox: true},
//                    {title:'ID',field:'id', width:80, sort: true},
                    {title: '物品编码', field: 'coding', width: 150, sort: true},
                    {title: '物品名称', field: 'name', width: 150, sort: true},
                    {title: '商品条码', field: 'barcode', templet: '#categoryTpl', width: 180, sort: true},
                    {title: '规格型号', field: 'norm', width: 140, sort: true},
                    {title: '单位', field: 'unit', width: 80, sort: true},
                    {title: '安全库存下限', field: 'inventory_cap', width: 80, sort: true},
                    {title: '安全库存上限', field: 'inventory_lower', templet: '#areaTpl', width: 180, sort: true}
                ]] //设置表头
                , id: 'addGoods'
                , page: true
                , limit: 20
                , even: true
                , response: {countName: 'total'}
                //,…… //更多参数参考右侧目录：基本参数选项
            });
        });
        var depot_id =$("#depotId").val();
        sTable('{{ url("consumables/depot")}}/' + depot_id);
    });

    function sTable(url) {
        console.log(url);
        table1.reload('addGoods', {
            url: url
        });
    }

    $('#submitGoodsForm').click(function () {

        var checkStatus = table1.checkStatus('addGoods');
        var ids = [];
        var tbody = $("#add-goods tbody");
        $.each(checkStatus.data, function (i, v) {
            console.log(v);
            var price_num=v.pivot.goods_price/ v.pivot.goods_number;
            price_num=price_num.toFixed(2);
            var str = "<tr>" +
                "<td><input type='checkbox' name='goods_ids[]' class='form-control icheck' value='" + v.id + "' ></td>" +
                "<td><input type='hidden' name='goods_price[]' value='"+price_num+"' > " + v.coding + "</td>" +
                "<td>" + v.name + "</td>" +
                "<td>" + v.barcode + "</td>" +
                "<td>" + v.norm + "</td>" +
                "<td>" + v.unit + "</td>" +
                "<td>" + v.pivot.goods_number+ "</td>" +
                "<td><input type='number' class='form-control' name='goods_num[]' onchange='count_price(this)'></td>" +
                "<td>" + price_num+ "</td>" +
                "<td>0</td>" +
                "<td><input type='text' class='form-control' name='comment[]'></td>" +
                "<td>" + v.inventory_cap + "</td>" +
                "<td>" + v.inventory_lower + "</td>" +
                "<input type='hidden' name='goods_ids[]' value='" + v.id + "' >" +
                "</tr>";
            if ($('#add-goods input[value="' + v.id + '"]').length < 1) {
                tbody.append(str);
            }
        });
    });
</script>