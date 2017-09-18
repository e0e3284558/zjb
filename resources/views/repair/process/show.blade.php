<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">报修详情信息</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
        <tr role="row">
            <td><label class="control-label">报修项名称</label></td>
            @if($info->other=="0")
                <td>{{$info->asset->name}}</td>
            @else
                <td>{{$info->otherAsset->name}}</td>
            @endif
        </tr>
        <tr role="row">
            <td><label class="control-label">所在场地</label></td>
            <td>{{$info->area_id?get_area($info->area_id):""}}</td>

        </tr>
        <tr>
            <td><label class="control-label">报修原因</label></td>
            <td>{{$info->remarks}}</td>
        </tr>
        <tr>
            <td><label class="control-label">报修人</label></td>
            <td>{{$info->user_id?$info->user->name:""}}</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>