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

    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>维修列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="@if (request()->active=='new' || !request()->active) active  @endif">
                                    <a href="{{url('repair/repair_list?app_groups=repair&active=new')}}">待服务工单</a></li>
                                <li class="@if (request()->active=='wait') active  @endif">
                                    <a href="{{url('repair/repair_list?app_groups=repair&active=wait')}}" >待评价</a></li>
                                <li class="@if (request()->active=='all') active  @endif">
                                    <a href="{{url('repair/repair_list?app_groups=repair&active=all')}}" >所有工单</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane @if (request()->active=='new' || !request()->active) active  @endif" id="tab-1">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>状态</th>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                {{--<th>报修分类</th>--}}
                                                <th>报修照片</th>
                                                {{--<th>报修原因</th>--}}
                                                <th>维修单详情</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list1 as $v)
                                                <tr>
                                                    <td>
                                                        @if($v->status=='1' || $v->status=='7' || $v->status=='4')
                                                            <span class="label label-info">待分派</span>
                                                        @elseif($v->status=='2')
                                                            <span class="label label-primary">待服务</span>
                                                        @endif
                                                    </td>
                                                    <td>{{@get_area($v->area_id)}}</td>

                                                    @if($v->classify && (!$v->asset_id))
                                                        <td>{{$v->classify->name}}</td>
                                                    @else
                                                        <td>{{@$v->asset->name}}</td>
                                                    @endif

                                                    {{--@if($v->classify)--}}
                                                        {{--<td>{{$v->classify?$v->classify->name:""}}</td>--}}
                                                    {{--@else--}}
                                                        {{--<td>等待派分</td>--}}
                                                    {{--@endif--}}

                                                    <td>
                                                        @if(!collect($v->img)->isEmpty())
                                                            <span class="cursor_pointer"
                                                                  onclick="showImg('{{url('repair/repair_list/showImg')}}/{{$v->id}}')"
                                                                  data-toggle="modal" data-target=".bs-example-modal-md"
                                                                  title="详情">详情</span>
                                                        @endif
                                                    </td>
{{--                                                    <td>{{$v->remarks}}</td>--}}

                                                    <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-md"
                                                              title="详情">点击查看详情</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{ url('repair/create_repair/create?app_groups=repair') }}" class="btn btn-primary btn-sm">我要报修</a>
                                    </div>
                                    <div class="page-header">{{ $list1->appends(['active' => 'new'])->links() }}</div>
                                </div>
                                <div class="tab-pane @if (request()->active=='wait') active  @endif" id="tab-2">
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>报修场地</th>
                                                <th>报修项目</th>
                                                {{--<th>报修分类</th>--}}
                                                <th>报修照片</th>
                                                {{--<th>报修原因</th>--}}
                                                <th>维修单详情</th>
                                                <th>填写评价</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list2 as $v)
                                                <tr>
                                                    <td>{{@get_area($v->area_id)}}</td>
                                                    @if($v->classify && (!$v->asset_id))
                                                        <td>{{$v->classify->name}}</td>
                                                    @else
                                                        <td>{{$v->asset->name}}</td>
                                                    @endif
                                                    {{--<td>--}}
                                                        {{--@if($v->classify)--}}
                                                            {{--{{$v->classify?$v->classify->name:""}}--}}
                                                        {{--@else--}}
                                                            {{--等待派分--}}
                                                        {{--@endif--}}
                                                    {{--</td>--}}
                                                    <td>
                                                        @if(!collect($v->img)->isEmpty())
                                                            <span class="cursor_pointer"
                                                                  onclick="showImg('{{url('repair/repair_list/showImg')}}/{{$v->id}}')"
                                                                  data-toggle="modal" data-target=".bs-example-modal-md"
                                                                  title="详情">详情</span>
                                                        @endif
                                                    </td>
{{--                                                    <td>{{$v->remarks}}</td>--}}

                                                    <td>
                                                        <span class="cursor_pointer"
                                                              onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                              data-toggle="modal" data-target=".bs-example-modal-md"
                                                              title="详情">点击查看详情</span>
                                                    </td>

                                                    <td>
                                                        @if($v->status=="5")
                                                            <button class="btn btn-primary"
                                                                    onclick="edit('{{$v->id}}')"
                                                                    data-toggle="modal"
                                                                    data-target=".bs-example-modal-md">
                                                                评价
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="page-header">{{ $list2->appends(['active' => 'wait'])->links() }}</div>
                                </div>
                                <div class="tab-pane @if (request()->active=='all') active  @endif" id="tab-3">
                                    <div class="tab-pane" id="tab-1">
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>报修状态</th>
                                                    <th>报修项目</th>
                                                    <th>报修场地</th>
                                                    {{--<th>报修分类</th>--}}
                                                    <th>报修照片</th>
                                                    {{--<th>报修原因</th>--}}
                                                    <th width="18%">维修单详情</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list3 as $v)
                                                    <tr>
                                                        <td>
                                                            @if($v->status=='1' || $v->status=='7' || $v->status=='4')
                                                                <span class="label label-info">待分派</span>
                                                            @elseif($v->status=='2')
                                                                <span class="label label-primary">待服务</span>
                                                            @elseif($v->status=='5')
                                                                <span class="label label-primary">待评价</span>
                                                            @elseif($v->status=='6')
                                                                <span class="label label-primary">已完成</span>
                                                            @endif
                                                        </td>
                                                        @if($v->classify && (!$v->asset_id))
                                                            <td>{{$v->classify->name}}</td>
                                                        @else
                                                            <td>{{$v->asset->name}}</td>
                                                        @endif
                                                        
                                                        <td>{{@get_area($v->area_id)}}</td>

                                                        {{--@if($v->classify)--}}
                                                            {{--<td>{{$v->classify?$v->classify->name:""}}</td>--}}
                                                        {{--@else--}}
                                                            {{--<td>等待派分</td>--}}
                                                        {{--@endif--}}

                                                        <td>
                                                            @if(!collect($v->img)->isEmpty())
                                                                <span class="cursor_pointer"
                                                                      onclick="showImg('{{url('repair/repair_list/showImg')}}/{{$v->id}}')"
                                                                      data-toggle="modal"
                                                                      data-target=".bs-example-modal-md"
                                                                      title="详情">详情</span>
                                                            @endif
                                                        </td>
{{--                                                        <td>{{$v->remarks}}</td>--}}
                                                        <td>
                                                            <span class="cursor_pointer"
                                                                  onclick="show('{{url('repair/repair_list')}}/{{$v->id}}')"
                                                                  data-toggle="modal" data-target=".bs-example-modal-md"
                                                                  title="详情">点击查看详情</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="page-header">{{ $list3->appends(['active' => 'all'])->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script type="text/javascript">

        $("document").ready(function () {
        });

        function show(url) {
            $.ajax({
                "url": url,
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function showImg(url) {
            $.ajax({
                "url": url,
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
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