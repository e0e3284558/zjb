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
            <td>
                @if($info->other=="0")
                    {{$info->asset->name}}
                @else
                    {{$info->otherAsset->name}}
                @endif
            </td>
            <td><label class="control-label">所在场地</label></td>
            <td>{{$info->area_id?get_area($info->area_id):""}}</td>

        </tr>

        <tr role="row">
            <td><label class="control-label">报修项类别</label></td>
            <td>{{$info->asset_classify_id?$info->category->name:""}}</td>
            <td><label class="control-label">报修故障</label></td>
            <td>{{$info->remarks}}</td>
        </tr>
        <tr>
            <td><label class="control-label">报修图片</label></td>
            <td colspan="3" >
                @if(!collect($info->img)->isEmpty())
                    @foreach($list as $k=>$img)
                        <?php
                        if ($k > 4) break;
                        ?>
                            <a href="{{url("$img->path")}}" data-lightbox="roadtrip">
                                <img src="{{url("$img->path")}}" style="max-width: 50px;max-height: 50px;margin: 5px;">
                            </a>
                    @endforeach
                @endif
            </td>
        </tr>
        <tr role="row">
            <td><label class="control-label">维修服务商</label></td>
            <td>
                @if($info->serviceProvider)
                    {{$info->serviceProvider->name}}
                @else
                    待分派
                @endif
            </td>
            <td><label class="control-label">维修人员</label></td>
            <td>
                @if($info->serviceWorker)
                    {{$info->serviceWorker->name}}
                @else
                    待分派
                @endif
            </td>
        </tr>
        <tr>
            <td><label class="control-label">用户评分</label></td>
            <td>
                @for($i=0;$i<$info->score;$i++)
                    <i class="fa fa-star" style="color:#e8bd0d;"></i>
                @endfor
            </td>
            <td><label class="control-label">用户评价</label></td>
            <td>{{$info->appraisal}}</td>
        </tr>

        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>

<script type="text/javascript" >
    function showImg(url) {
        $.ajax({
            "url": url,
            success: function (data) {
                $(".bs-example-modal-lg .modal-content").html(data);
            }
        })
    }
</script>