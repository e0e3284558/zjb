<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">合同清单列表</h4>
</div>
<div class="modal-body">
<div class="table-responsive">
    <table  class="table table-striped  table-bordered"  lay-filter="asset-table">
        <thead>
        <tr role="row">
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