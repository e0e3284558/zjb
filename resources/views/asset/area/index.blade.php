@extends("layouts.app")
@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>

                <li>
                    <a href="javascript:;">资产管理</a>
                </li>

                <li class="active">
                    <strong>场地管理列表</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section("content")
    <div class="fh-breadcrumb fh-breadcrumb-m full-height-layout-on">
        <div class="wrapper wrapper-content2 full-height">
            <div class="row full-height">
                <div class="col-md-6 full-height">
                    <div class="ibox full-height-ibox">
                        <div class="ibox-title">
                            <h5>场地管理</h5>
                        </div>

                        <div class="ibox-content margin-padding-0">

                            <div class="ibox-content-wrapper">
                                <div class="scroller">
                                    <div class="input-group" style="padding: 5px 0px;">
                                        <span class="input-group-addon">
                                            搜索场地：
                                        </span>
                                        <input type="input" class="input-md form-control" id="input-search" placeholder="搜索">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-md btn-success" id="btn-search">查找</button>
                                            <button type="button" class="btn btn-md btn-danger" id="btn-clear-search">清空</button>
                                        </span>
                                    </div>
                                    <div id="tree" class="full-height-wrapper" ></div>
                                </div>
                            </div>
                            <div class="form-actions border-top ">
                                <a class="btn btn-success" onclick="add('添加','{{url('area/create')}}')"  id="create" >
                                    <i class="fa  fa-plus"></i> 新增
                                </a>
                                <div class="dropup inline">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-print"></i>更多操作
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <li><a class="btn btn-default" id="printBarcode download" href="{{url('area/downloadModel')}}"><i class="fa fa-sign-in"></i> 下载模板</a></li>
                                        <li><a class="btn btn-default" id="print download" href="{{url('area/add_import')}}" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-sign-in"></i> 导入场地管理</a></li>
                                        <li><a class="btn btn-default" id="print download" href="{{url('area/export')}}"><i class="fa fa-sign-out"></i> 导出场地数据</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 full-height">
                    <div class="ibox full-height-ibox">
                        <div class="ibox-title">
                            <h5>编辑</h5>
                        </div>
                        <div class="ibox-content margin-padding-0">
                            <div class="scroller">
                                <div id="right_content" class="full-height-wrapper">
                                    <div id="" style="color: #6a6c6f;font-size: 16px;text-align: center;">
                                        点击左侧菜单进行相关操作
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
        $(function () {
            function getTree() {
                var data = {!! json_encode($tree) !!};
                return data;
            }
            var $searchableTree = $('#tree').treeview({
                data: getTree(),         // data is not optional
                levels: 5,
                multiSelect: false,
            });

            $('#tree').treeview('collapseAll', { silent: true });

            $('#tree').on('nodeSelected', function(event,data) {
                // 事件代码...
                $.ajax({
                    url:'{{url('area')}}/'+data.id+"/edit",
                    type:"get",
                    data:{},
                    success:function (data) {
                        $("#right_content").html(data);
                    }
                })
            });

            var search = function(e) {
                var pattern = $('#input-search').val();
                var results = $searchableTree.treeview('search', [ pattern ]);
            };

            $('#btn-search').on('click', search);

            $('#btn-clear-search').on('click', function (e) {
                $searchableTree.treeview('clearSearch');
                $('#input-search').val('');
                $('#search-output').html('');
            });

        });

        /*$("#download").on("click",function () {
            $.ajax({
                url:"",
                type:"get",
                data:{},

            })
        });*/

    </script>


    <script type="text/javascript" >

        /*加载添加视图*/
        function add(title,url) {
            $.ajax({
                "url":url,
                success:function (data) {
                    $("#right_content").html(data);
                }
            })
        }

    </script>

@endsection