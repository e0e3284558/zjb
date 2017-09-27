<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">合同清单列表</h4>
</div>
<div class="modal-body">
<div class="table-responsive">
    <table  class="table table-striped  table-bordered"  lay-filter="asset-table">
        <thead>
            <tr role="row">
                <th>清单名称</th>
                <th>备注说明</th>
            </tr>
        </thead>
        <tbody>
            @if(count($list)>0)
                @foreach($list as $value)
                    <tr role="row">
                        <td>{{$value->name}}</td>
                        <td>{{$value->remarks}}</td>
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