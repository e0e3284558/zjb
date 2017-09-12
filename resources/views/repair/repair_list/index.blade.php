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
                    <strong>我的维修单</strong>
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
    <div class="row" >
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                </div>
                <div class="ibox-content">

                        <div class="table-responsive">
                            <table style="min-width: 1000px" class="table table-striped  table-bordered">
                                <thead>
                                <tr role="row">
                                    <th>状态</th>
                                    <th>详情</th>
                                    <th>资产名称</th>
                                    <th>维修服务商</th>
                                    <th>已派出维修工</th>
                                    <th>所属公司</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr role="row">
                                        <td>
                                            @if($value->status=='1'||$value->status=='2'||$value->status=='3')
                                                <span class="label label-info" >待分派</span>
                                            @elseif($value->status=='4')
                                                <span class="label label-success" >已派工</span>
                                            @elseif($value->status=='10' && $value->score)
                                                <span class="label label-primary" >评价完毕</span>
                                            @elseif($value->status=='10' || !$value->score)
                                                <button class="btn btn-primary btn-sm" onclick="edit('{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-md" >点击评价</button>
                                            @elseif($value->status=='0')
                                                <span class="label label-danger" >不可再修</span>
                                            @elseif($value->status=='20')
                                                <span>已派工</span>
                                            @endif
                                        </td>
                                        <td><span class="cursor_pointer" onclick="shows('{{$value->name}}','{{url('repair/repair_list')}}/{{$value->id}}')" data-toggle="modal" data-target=".bs-example-modal-lg" title="详情">{{$value->asset->name}}</span></td>
                                        <td>{{$value->asset->name}}</td>
                                        <td>{{$value->serviceProvider->name}}</td>
                                        <td>{{$value->serviceWorker->name}}</td>
                                        <td>{{$value->org->name}}</td>
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

        function str(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" +
                message +
                "</div><div class='modal-footer'> <button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> </div>"
            return messages;
        }

        function confirms(message) {
            var messages = "<div class='modal-header'>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button> </div> " +
                "<div class='modal-body'>" + message + "</div><div class='modal-footer'> " +
                "<button type='button' class='btn btn-primary' data-dismiss='modal'>确定</button> " +
                "<button type='submit' class='btn btn-primary'>保存</button></div>"
            return messages;
        }

        function edit(id) {
            {{--swal({--}}
            {{--title: "确认要接单吗？",--}}
            {{--text: "",--}}
            {{--type: "warning",--}}
            {{--showCancelButton: true,--}}
            {{--confirmButtonColor: "#DD6B55",--}}
            {{--cancelButtonText: "取消",--}}
            {{--confirmButtonText: "确认",--}}
            {{--closeOnConfirm: false--}}
            {{--},--}}
            {{--function(){--}}
            {{--//发异步删除数据--}}
            {{--$.ajax({--}}
            {{--type: "get",--}}
            {{--url: '{{url('repair/process')}}/'+id+'/edit',--}}
            {{--dataType:"json",--}}
            {{--success: function (data) {--}}
            {{--if(data.code==1){--}}
            {{--swal({--}}
            {{--title: "",--}}
            {{--text: data.message,--}}
            {{--type: "success",--}}
            {{--timer: 1000,--}}
            {{--},function () {--}}
            {{--window.location.reload();--}}
            {{--});--}}
            {{--}else{--}}
            {{--swal("", data.message, "error");--}}
            {{--}--}}
            {{--}--}}
            {{--});--}}
            {{--});--}}


            $.ajax({
                url: '{{url('repair/repair_list')}}/' + id + "/edit",
                type: "get",
                data: {},
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })


        }

        function add(id) {
            $.ajax({
                url: '{{url('repair/process/create')}}/' + id,
                type: "post",
                data: {},
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function show_img(object, url) {
            $.ajax({
                url: url,
                success: function (data) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            })
        }

        function shows(title, url) {
            $.ajax({
                "url": url,
                success: function (data) {
                    $(".bs-example-modal-lg .modal-content").html(data);
                }
            })
        }

    </script>

@endsection