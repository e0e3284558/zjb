<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">领用单详情</h4>
</div>
<div class="modal-body">

    <form class="form-horizontal">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">领用单号</label>
                    <div class="col-md-7">
                        <p class="padding-top-7">{{$info->code}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">领用时间</label>
                    <div class="col-md-7">
                        <p class="padding-top-7">{{$info->use_time}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">领用人</label>
                    <div class="col-md-7">
                        <p class="padding-top-7">{{$info->use_name}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">预计归还时间</label>
                    <div class="col-md-7">
                        <p class="padding-top-7">{{$info->expect_return_time}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">领用处理人</label>
                    <div class="col-md-7">
                        <p class="padding-top-7">{{$info->use_dispose_user->name}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 control-label">说明</label>
                    <div class="col-md-7">
                        <p class="padding-top-7">{{$info->remarks}}</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row" style="overflow:auto;height:195px;margin-top:10px;">
        <table class="table table-striped table-bordered table-hove">
            <thead>
            <tr>
                <td class="dialogtableth"><input type="checkbox"></td>
                <td class="dialogtableth">照片</td>
                <td class="dialogtableth">资产编号</td>
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