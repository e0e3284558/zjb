<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">报修项详情信息</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">报修项名称</label></td>
                <td>{{$info->name}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">所属公司</label></td>
                <td>{{$info->org_id}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">备注</label></td>
                <td colspan="5" >{{$info->remarks}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>