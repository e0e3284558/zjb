<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">借用单详情</h4>
</div>
<div class="modal-body">
    <table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">借用单号</label></td>
                <td>{{$info->borrow_code}}</td>
                <td class="td-bg" ><label class="control-label">借用时间</label></td>
                <td>{{$info->borrow_time}}</td>
                <td class="td-bg" ><label class="control-label">借用人</label></td>
                <td>{{$info->borrow_user_name}}</td>
            </tr>
            <tr role="row">
                @if($info->borrow_status=="1")
                    <td class="td-bg" ><label class="control-label">预计归还时间</label></td>
                    <td>{{$info->expect_return_time}}</td>
                    <td class="td-bg" ><label class="control-label">借出处理人</label></td>
                    <td>{{$info->borrow_handle_user->name}}</td>
                @else
                    <td class="td-bg" ><label class="control-label">归还时间</label></td>
                    <td>{{$info->return_time}}</td>
                    <td class="td-bg" ><label class="control-label">归还处理人</label></td>
                    <td>{{$info->return_handle_user->name}}</td>
                @endif
                <td class="td-bg" ><label class="control-label"></label></td>
                <td></td>
            </tr>
            @if($info->borrow_status=="1")
            <tr role="row">
                <td class="td-bg" ><label class="control-label">说明</label></td>
                <td colspan="5" >{{$info->remarks}}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="col-sm-12" style="overflow:auto;height:195px;margin-top:10px;">
        <table class="table table-striped table-bordered table-hove">
            <thead>
            <tr>
                <td class="dialogtableth"><input type="checkbox"></td>
                <td class="dialogtableth">照片</td>
                <td class="dialogtableth">资产条码</td>
                <td class="dialogtableth">资产名称</td>
                <td class="dialogtableth">资产类别</td>
                <td class="dialogtableth">规格型号</td>
            </tr>
            </thead>
            <tbody data-bind="foreach: selectedAssetList">
            @foreach($list as $value)
                <tr>
                    <td><input type="checkbox" name="borrow_asset_ids[]" value="{{$value->id}}"></td>
                    <td>
                        @if($value->img_path)
                            <a href="{{url("$value->img_path")}}" data-lightbox="roadtrip">
                                <img id="image" class="cursor_pointer img-md" src="{{$value->img_path}}">
                            </a>
                        @endif
                    </td>
                    <td>{{$value->code}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->category->name}}</td>
                    <td>{{$value->spec}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>