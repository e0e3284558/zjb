<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产详情信息</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产条码</label></td>
                <td>{{$info->code}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产类别</label></td>
                <td>{{$info->category_id}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产名称</label></td>
                <td>{{$info->name}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">规格型号</label></td>
                <td>{{$info->spec}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">SN号</label></td>
                <td>{{$info->SN_code}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">计量单位</label></td>
                <td>{{$info->calculate}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">金额</label></td>
                <td>{{$info->money}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用部门</label></td>
                <td>{{$info->use_department_id}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">购入时间</label></td>
                <td>{{$info->buy_time}}</td>
            </tr>
            <tr role="row">

                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用人</label></td>
                <td>{{$info->user_name}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">管理员</label></td>
                <td>{{$info->admin_id}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">区域</label></td>
                <td>{{$info->area_id}}</td>
            </tr>

            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用期限</label></td>
                <td>{{$info->use_time}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">供应商</label></td>
                <td>{{$info->supplier}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">来源</label></td>
                <td>{{$info->source_id}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">所属公司</label></td>
                <td>{{$info->org_id}}</td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">备注</label></td>
                <td colspan="4" >{{$info->remarks}}</td>
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
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>