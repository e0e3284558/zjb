<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产详情信息</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产类别</label></td>
                <td>{{$info->category_id}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产名称</label></td>
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
            <tr role="row" >
                <td class="td-bg" ><label for="inputEmail3" class="control-label">图片</label></td>
                <td colspan="5" >
                    @if($info->img_path)
                        <img id="image" src="{{$info->img_path}}" style="height: 100px;">
                    @else
                        <img id="image" src="{{url('uploads/imgs/nopicture.jpg')}}" style="height: 100px;" >
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
</div>