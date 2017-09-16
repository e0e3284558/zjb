<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">查看原因</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">状态</label></td>
                <td>
                    @if($info->status=='4')
                        <span style="color: red" >维修人员已拒绝</span>
                    @elseif($info->status=='7')
                        <span style="color: red;">维修人员未修好</span>
                    @endif
                </td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">原因</label></td>
                <td>{{$info->suggest}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>