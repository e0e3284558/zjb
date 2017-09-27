<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">资产详情信息</h4>
</div>
<div class="modal-body">
<div class="table-responsive">
    <table  class="table table-striped  table-bordered"  lay-filter="asset-table">
        <thead>
            <tr role="row">
                <th><input type="checkbox" class="i-checks" name="checkAll" id="all" ></th>
                <th>资产编号</th>
                <th>图片</th>
                <th>资产名称</th>
                <th>资产类别</th>
                <th>规格型号</th>
                <th>计量单位</th>
                <th>金额(元)</th>
                <th>所在场地</th>
                <th>购入时间</th>

            </tr>
        </thead>
        <tbody>
            @if(count($list)>0)
                @foreach($list as $value)
                    <tr role="row">
                        <td role="gridcell">
                            <input type="checkbox" class="i-checks" name="id" value="{{$value->id}}">
                        </td>
                        <td>{{$value->code}}</td>
                        <td>
                            @if($value->img_path)
                                <a href="{{url("$value->img_path")}}" data-lightbox="roadtrip">
                                    <img class="cursor_pointer img-md" id="image" src="{{asset($value->img_path)}}" style="height: 50px;">
                                </a>
                                {{--<img class="cursor_pointer img-md" onclick="show_img(this,'{{url('asset/show_img/'.$value->file_id)}}')" src="{{asset($value->img_path)}}"data-toggle="modal" data-target=".bs-example-modal-md">--}}
                            @endif
                        </td>
                        <td><span class="cursor_pointer" onclick="shows('{{$value->name}}','{{url('asset')}}/{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-lg" >{{$value->name}}</span></td>
                        <td>{{$value->category_id?$value->category->name:""}}</td>
                        <td>{{$value->spec}}</td>
                        <td>{{$value->calculate}}</td>
                        <td>{{$value->money}}</td>
                        <td>{{$value->area_id?get_area($value->area_id):""}}</td>
                        <td>{{$value->buy_time}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="text-align: center" >暂无数据</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>