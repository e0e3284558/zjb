<style>
    .table-bordered>tbody>tr>td{
        padding: 0;
        line-height: 37px;
    }
    label{
        font-weight: normal;
    }
    .td-bg {
        background: #eee;
        text-align: center;
        vertical-align: inherit;
    }
    .form-control{
        border: none;
        background-color: #fff;
        margin: 0;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: rgb(255, 2555, 255);
        opacity: 1;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产详情信息</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产条码</label></td>
                <td><input type="text" value="{{$info->asset_code}}" name="asset_code" disabled class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产类别</label></td>
                <td><input type="text" value="{{$info->type_id}}" disabled name="type_id" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">资产名称</label></td>
                <td><input type="text" value="{{$info->name}}" disabled name="name" class="form-control" id="inputEmail3"></td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">规格型号</label></td>
                <td><input type="text" value="{{$info->spec}}" disabled name="spec" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">SN号</label></td>
                <td><input type="text" value="{{$info->SN_code}}" disabled name="SN_code" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">计量单位</label></td>
                <td><input type="text" value="{{$info->calculate}}" disabled name="calculate" class="form-control" id="inputEmail3"></td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">金额</label></td>
                <td><input type="text" value="{{$info->money}}" disabled name="money" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用公司</label></td>
                <td><input type="text" value="{{$info->use_org_id}}" disabled name="use_org_id" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用部门</label></td>
                <td><input type="text" value="{{$info->use_department_id}}" disabled name="calculate" class="form-control" id="inputEmail3"></td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">购入时间</label></td>
                <td><input type="text" value="{{$info->buy_time}}" disabled name="buy_time" class="form-control pull-right" id="datepicker"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用人</label></td>
                <td><input type="text" value="{{$info->user_id}}" disabled name="user_id" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">管理员</label></td>
                <td><input type="text" value="{{$info->admin_id}}" disabled name="admin_id" class="form-control" id="inputEmail3"></td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">所属公司</label></td>
                <td><input type="text" value="{{$info->owned_org_id}}" disabled name="owned_org_id" class="form-control pull-right" id="datepicker"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">区域</label></td>
                <td><input type="text" value="{{$info->address_id}}" disabled name="address_id" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">存放地点</label></td>
                <td><input type="text" value="{{$info->deposit_address}}" disabled name="deposit_address" class="form-control" id="inputEmail3"></td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">使用期限</label></td>
                <td><input type="text" value="{{$info->use_time}}" disabled name="use_time" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">供应商</label></td>
                <td><input type="text" value="{{$info->supplier}}" disabled name="supplier" class="form-control" id="inputEmail3"></td>
                <td class="td-bg" ><label for="inputEmail3" class="control-label">来源</label></td>
                <td><input type="text" value="{{$info->source_id}}" disabled name="source_id" class="form-control" id="inputEmail3"></td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label for="inputEmail3" class="control-label">备注</label></td>
                <td colspan="4" ><textarea class="form-control" disabled name="descr" rows="1" style="resize: none;">{{$info->descr}}</textarea></td>
                @if($info->files)
                    <td><a href="{{url('asset/download/'.$info->id)}}" class="btn btn-default"><span class="glyphicon glyphicon-save" ></span>下载查看资产合同文件</a></td>
                @endif
            </tr>
            <tr role="row" >
                <td class="td-bg" ><label for="inputEmail3" class="control-label">图片</label></td>
                <td colspan="5" >
                    @if($info->img)
                        <img id="image" src="{{$info->img}}" style="height: 100px;">
                    @else
                        <img id="image" src="{{url('img/nopicture.jpg')}}" style="height: 100px;" >
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
</div>