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
                                    <div id="tree" class="full-height-wrapper" ></div>
                                </div>
                            </div>
                            <div class="form-actions border-top ">
                                <a class="btn btn-success" onclick="add('添加','{{url('area/create')}}')"  id="create" >
                                    <i class="fa  fa-plus"></i> 新增
                                </a>
                                <a class="btn btn-default" id="import">
                                    <i class="fa fa-sign-in"></i> 导入数据
                                </a>
                                <a href="{{url('asset_category/export')}}" class="btn btn-default" id="export">
                                    <i class="fa fa-sign-out"></i> 导出EXCEL
                                </a>
                                <a class="btn" disabled="">
                                <span class="overlay" id="loading" style="display:none">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </span>
                                </a>
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
            $('#tree').treeview({
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
        })

    </script>


    <script type="text/javascript" >

        function show(title,url) {
            $.ajax({
                "url":url,
                success:function (data) {
                    $(".modal-content").html(data);

                }
            })
        }
        /*加载添加视图*/
        function add(title,url) {
            $.ajax({
                "url":url,
                success:function (data) {
//                    $(".modal-content").html(data);
                    $("#right_content").html(data);
                }
            })
        }

        function edit(title,url) {
            $.ajax({
                "url":url,
                success:function (data) {
                    $(".modal-content").html(data);
                }
            })
        }


        /*删除*/
        function del(obj,id){
            var s = confirm('确认要删除吗？')
            if(s){
                //发异步删除数据
                $.ajax({
                    type:"post",
                    url:'{{url('Address')}}'+'/'+id,
                    data:{
                        "_token":'{{csrf_token()}}',
                        '_method':'delete'
                    },
                    success:
                        function (data) {
                            if(data!=null){
                                alert(data);
                                $(obj).parents("tr").remove();
                            }
                        }
                });
            }
        }


        function lead() {
            $.ajax({
                url:'{{url('Address/import')}}',
                type:"get",
                success:function (data) {
                    $(".modal-content").html(data);
                }
            })
        }

    </script>

@endsection