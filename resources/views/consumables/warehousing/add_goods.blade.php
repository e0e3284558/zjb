<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">选择物品</h4>
</div>
<div class="modal-body">

    <div class="row">

        <div class="col-sm-3 shadow table-bordered min-height ">
            <ul id="treeDemo" class="ztree"></ul>
        </div>
        <SCRIPT LANGUAGE="JavaScript">
            var id = 0;

            function zTreeOnClick(event, treeId, treeNode) {
                id = treeNode.id;
                sTable('{{ url("consumables/goods?id=")}}' + id);
            }

            var zTreeObj;
            // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
            var setting = {
                callback: {
                    onClick: zTreeOnClick
                },
                data: {
                    simpleData: {
                        enable: true,
                        idKey: "id",
                        pIdKey: "parent_id",
                        rootPId: 0
                    }
                }
            };
            var treeNodes = {!! $data !!};
            $(document).ready(function () {
                $.fn.zTree.init($("#treeDemo"), setting, treeNodes);
            });
        </SCRIPT>
        <div class="col-sm-9">
            <table class="layui-table" id="addGoods" lay-filter="data-goods-add" lay-data="">
                <thead>
                <tr>
                </tr>
                </thead>
            </table>
        </div>

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

            var str = "<tr>" +
                "<td><input type='checkbox' name='goods_ids[]' value='" + v.id + "' ></td>" +
                "<td>" + v.coding + "</td>" +
                "<td>" + v.name + "</td>" +
                "<td>" + v.barcode + "</td>" +
                "<td>" + v.norm + "</td>" +
                "<td>" + v.unit + "</td>" +
                "<td><input type='number' name='goods_num[]'></td>" +
                "<td></td>" +
                "<td><input type='number' name='goods_total_price[]'></td>" +
                "<td><input type='text' name='comment[]'></td>" +
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