<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产详情信息</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal " >
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">资产编号</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->code}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">资产类别</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->category_id?$info->category->name:""}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">资产名称</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->name}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">规格型号</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->spec}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">计量单位</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->calculate}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">区域</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->area_id?$info->area->name:""}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">金额(元)</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->money}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">购入时间</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->buy_time}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">供应商</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->supplier_id?$info->supplier->name:""}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-4" >
            <div class="form-group">
                <label class="col-md-4 control-label">生产日期</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->production_date}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" >
            <div class="form-group">
                <label class="col-md-4 control-label">维保日期</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->contract ? $info->contract->start_date : '暂无'}} 至 {{$info->contract ? $info->contract->end_date : '暂无'}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">备注</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->supplier_id?$info->supplier->name:""}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">图片</label>
                <div class="col-md-8">
                    <p class="padding-top-7">
                        @if($info->img_path)
                            <a href="{{url("$info->img_path")}}" data-lightbox="roadtrip">
                                <img id="image" src="{{$info->img_path}}" style="height: 50px;">
                            </a>
                        @else
                            <span>暂无图片</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-4 control-label">所属合同</label>
                <div class="col-md-8">
                    <p class="padding-top-7">{{$info->contract ? $info->contract->name : '暂无'}}</p>
                </div>
            </div>
        </div>
    </div>
    </form>

    {{--<table id="example1" class="table table-bordered" role="grid" aria-describedby="example1_info">
        <tbody>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">资产条码</label></td>
                <td>{{$info->code}}</td>
                <td class="td-bg" ><label class="control-label">资产类别</label></td>
                <td>{{$info->category_id?$info->category->name:""}}</td>
                <td class="td-bg" ><label class="control-label">资产名称</label></td>
                <td>{{$info->name}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">规格型号</label></td>
                <td>{{$info->spec}}</td>
                <td class="td-bg" ><label class="control-label">计量单位</label></td>
                <td>{{$info->calculate}}</td>
                <td class="td-bg" ><label class="control-label">区域</label></td>
                <td>{{$info->area_id?$info->area->name:""}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">金额(元)</label></td>
                <td>{{$info->money}}</td>
                <td class="td-bg" ><label class="control-label">购入时间</label></td>
                <td></td>
                <td class="td-bg" ><label class="control-label">供应商</label></td>
                <td>{{$info->supplier_id?$info->supplier->name:""}}</td>
            </tr>
            <tr role="row">
                <td class="td-bg" ><label class="control-label">备注</label></td>
                <td colspan="2" >{{$info->remarks}}</td>
                <td class="td-bg" ><label class="control-label">图片</label></td>
                <td colspan="2" >
                    @if($info->img_path)
                        <a href="{{url("$info->img_path")}}" data-lightbox="roadtrip">
                            <img id="image" src="{{$info->img_path}}" style="height: 50px;">
                        </a>
                    @else
                        <span>暂无图片</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="td-bg" ><label class="control-label">所属合同</label></td>
                <td colspan="5" >{{$info->contract->name}}</td>
            </tr>
        </tbody>
    </table>--}}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>