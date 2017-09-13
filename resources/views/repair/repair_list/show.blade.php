<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">报修详情信息</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td><label class="control-label">报修项名称</label></td>
                @if($info->asset_id)
                    <td>{{$info->asset->name}}</td>
                @else
                    <td>{{$info->other_asset->name}}</td>
                @endif
                <td ><label class="control-label">维修服务商</label></td>
                <td>{{$info->serviceProvider->name}}</td>
                <td><label class="control-label">维修工</label></td>
                <td>{{$info->serviceWorker->name}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">报修原因</label></td>
                <td colspan="5" >{{$info->remarks}}</td>
            </tr>
            <tr>
                <td><label class="control-label">所属公司</label></td>
                <td>{{$info->org->name}}</td>
                <td><label class="control-label">用户评分</label></td>
                <td>{{$info->score}}</td>
                <td><label class="control-label">用户评价</label></td>
                <td>{{$info->appraisal}}</td>
            </tr>

        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>