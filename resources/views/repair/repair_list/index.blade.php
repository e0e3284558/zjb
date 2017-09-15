@extends("layouts.app")
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>
                <li>
                    <a href="javascript:;">报修管理</a>
                </li>
                <li class="active">
                    <strong>我的报修单</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
    {{--报修列表--}}
    <div class="wrapper wrapper-content ">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table style="min-width: 1000px" class="table table-striped  table-bordered">
                                <thead>
                                <tr role="row">
                                    <th>报修项</th>
                                    <th>场地位置</th>
                                    <th>报修类别</th>
                                    <th>问题描述</th>
                                    <th>问题图片</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr role="row">
                                        @if($value->other=="0")
                                            <td><span class="cursor_pointer"
                                                      onclick="shows('{{$value->name}}','{{url('repair/repair_list')}}/{{$value->id}}')"
                                                      data-toggle="modal" data-target=".bs-example-modal-lg"
                                                      title="详情">{{$value->asset->name}}</span></td>
                                        @else
                                            <td><span class="cursor_pointer"
                                                      onclick="shows('{{$value->name}}','{{url('repair/repair_list')}}/{{$value->id}}')"
                                                      data-toggle="modal" data-target=".bs-example-modal-lg"
                                                      title="详情">{{$value->otherAsset->name}}</span></td>
                                        @endif

                                        <td>{{$value->area->name}}</td>
                                        <td>{{$value->classify->name}}</td>
                                        <td>{{$value->remarks}}</td>
                                            @if(collect($value->img)->isEmpty())
                                                <td>用户未上传图片</td>
                                            @else
                                                <td>
                                                    @foreach($value->img as $k=>$img)
                                                        <?php
                                                        if ($k > 3) break;
                                                        ?>
                                                        <img src='{{url("$img->path")}}' alt=""
                                                             class="img-circle-b">
                                                    @endforeach
                                                </td>
                                            @endif
                                        <td>
                                            @if($value->status=='1')
                                                <span class="label label-info">待分派</span>
                                            @elseif($value->status=='2')
                                                <span class="label label-info">待服务</span>
                                            @elseif($value->status=='3')
                                                <span class="label label-info">维修中</span>
                                            @elseif($value->status=='4')
                                                <span class="label label-info">已拒绝</span>
                                            @elseif($value->status=='5')
                                                <button class="label label-success" onclick="edit('{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-md">待评价</button>
                                            @else
                                                <span class="label label-info">已完成</span>
                                            @endif


                                            {{--@if($value->status=='1'||$value->status=='2'||$value->status=='3')--}}
                                                {{--<span class="label label-info">待分派</span>--}}
                                            {{--@elseif($value->status=='4')--}}
                                                {{--<span class="label label-success">已派工</span>--}}
                                            {{--@elseif($value->status=='10' && $value->score)--}}
                                                {{--<span class="label label-default" >评价完毕</span>--}}

                                            {{--@elseif($value->status=='10' || !$value->score)--}}
                                                {{--<button class="btn btn-primary btn-sm" onclick="edit('{{$value->id}}')"--}}
                                                        {{--data-toggle="modal" data-target=".bs-example-modal-md">点击评价--}}
                                                {{--</button>--}}
                                            {{--@elseif($value->status=='0')--}}
                                                {{--<span class="label label-danger">不可再修</span>--}}
                                            {{--@elseif($value->status=='20')--}}
                                                {{--<span class="label label-success">已派工</span>--}}
                                            {{--@endif--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $("document").ready(function () {
            $('.i-checks,#all').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });
            $('#all').on('ifChecked ifUnchecked', function (event) {
                if (event.type == 'ifChecked') {
                    $('.i-checks').iCheck('check');
                } else {
                    $('.i-checks').iCheck('uncheck');
                }
            });
        });

        function shows(title, url) {
            $.ajax({
                "url": url,
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: "{{url('repair/repair_list')}}/" + id + '/edit',
                type: "get",
                dataType: "html",
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            });
        }

    </script>

@endsection