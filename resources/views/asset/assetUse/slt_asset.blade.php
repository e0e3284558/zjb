<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">选择资产</h4>
</div>
<div class="modal-body">
    <form id="signupForm2" class="form-horizontal " method="post" enctype="multipart/form-data" >

        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="row" >

            <table class="layui-table" id="asset-use-add" lay-filter="data-asset-use-add" lay-data="">
                <thead>
                <tr>
                </tr>
                </thead>
            </table>
            <script type="text/html" id="categoryTpl">
            @{{# if(d.category){  }}
                @{{d.category.name}}
                @{{# } }}
            </script>
            <script type="text/html" id="areaTpl">
            @{{# if(d.area){  }}
                @{{d.area.name}}
                @{{# } }}
            </script>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="submitAssetsForm2" data-dismiss="modal">选择</button>
</div>
<script type="text/javascript">

    $( document ).ready( function () {


        layui.use('table', function () {
            var table = layui.table;

            //执行渲染
            table.render({
                elem: '#asset-use-add' //指定原始表格元素选择器（推荐id选择器）
                , height: 410 //容器高度
                , url: '{{ url("asset_use/slt_asset?type=2") }}'
                , cols: [[
                    {fixed: 'left', checkbox: true},
//                    {title:'ID',field:'id', width:80, sort: true},
                    {title: '资产编号', field: 'code', width: 150, sort: true},
                    {title: '资产名称', field: 'name', width: 150, sort: true},
                    {title: '资产类别', field: 'category', templet: '#categoryTpl', width: 180, sort: true},
                    {title: '规格型号', field: 'spec', width: 140, sort: true},
                    {title: '计量单位', field: 'calculate', width: 80, sort: true},
                    {title: '金额(元)', field: 'money', width: 80, sort: true},
                    {title: '所在场地', field: 'area', templet: '#areaTpl', width: 180, sort: true}
                ]] //设置表头
                , id: 'dataAssetUseAdd'
                , page: true
                , limit: 20
                , even: true
                , response: {countName: 'total'}
                //,…… //更多参数参考右侧目录：基本参数选项
            });
        });

        $('#submitAssetsForm2').click(function () {

            var checkStatus = table.checkStatus('dataAssetUseAdd');
            var ids  = [];
            var tbody = $("#asset-use-asset tbody");
            $.each(checkStatus.data,function(i,v){

                console.log(v);

                var str = "<tr>" +
                    "<td><input type='checkbox' name='asset_id[]' value='"+v.id+"' ></td>" +
                    "<td>"+v.code+"</td>" +
                    "<td>"+v.name+"</td>" +
                    "<td>"+v.category.name+"</td>" +
                    "<td>"+v.spec+"</td>" +
                    "<td>"+v.money+"</td>" +
                    "<td>"+v.area.name+"</td>" +
                    "<input type='hidden' name='asset_ids[]' value='"+v.id+"' >"+
                    "</tr>";
                if($('#asset-use-asset input[value="'+v.id+'"]').length < 1){
                    tbody.append(str);
                }
            });
        });
    });
</script>
