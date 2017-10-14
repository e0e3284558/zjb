@extends('layouts.app')


@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <!-- <h2></h2> -->
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">控制面板</a>
                </li>

                <li>
                    <a href="javascript:;">耗材管理</a>
                </li>

                <li class="active">
                    <strong>物品分类</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection

@section('content')
    <div class="fh-breadcrumb full-height-layout-on">
        <div class="fh-column fh-column-w">
            <div class="full-height-scroll" id="ztree-warpper">
                <div class="search-tools-top padding-20 border-bottom">
                    <div class="input-group">
                        <input type="text" placeholder="请输入关键字" name="name" id="search-name"
                               class="form-control border-radius-none">
                        <span class="input-group-btn">
                        <button type="button" id="search-dep" class="btn btn-primary blue border-radius-none"><i
                                    class="fa fa-search"></i> 查询</button>
                        <a class="btn default border-radius-none" href="{{ url("users/departments/create") }}"
                           data-target="#dep-form-wrapper" data-toggle="relaodHtml" data-loading="true"><i
                                    class="fa fa-plus"></i> 新增</a>
                    </span>
                    </div>
                </div>
                <div class="full-height-wrapper">
                    <ul id="departments-tree" class="ztree">

                    </ul>
                </div>
            </div>
        </div>
        <div class="full-height">
            <div class="full-height-scroll  border-left ">
                <div class="full-height-wrapper">
                    <div class="row">
                        <div class="col-lg-12" id="dep-form-wrapper">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            var depTreeBeforeAsync = function (treeId, treeNode) {
                zjb.blockUI("#ztree-warpper");
                return true;
            };
            var depTreeOnAsyncSuccess = function (event, treeId, treeNode, msg) {
                $.fn.zTree.getZTreeObj(treeId).expandAll(true);
                zjb.unblockUI("#ztree-warpper");
            };
            var depTreeOnClick = function (event, treeId, treeNode, clickFlag) {
                // console.log(treeNode);
                if (treeNode.href != undefined && treeNode.href != '') {
                    zjb.ajaxGetHtml('#dep-form-wrapper', treeNode.href, {}, true);
                }
            };
            var setting = {
                async: {
                    enable: true,
                    url: "{!! url('users/departments?tree=1') !!}",
                    autoParam: ["id", "level=lv"],
                    otherParam: {
                        'name': function () {
                            return $('#search-name').val()
                        }
                    },
                    dataFilter: null,
                    type: 'get'
                },
                data: {
                    simpleData: {
                        enable: true,
                        idKey: "id",
                        pIdKey: "parent_id"
                    }
                },
                check: {
                    enable: false
                },
                view: {
                    showIcon: true,
                    dblClickExpand: false,
                    showLine: false
                },
                callback: {
                    beforeAsync: depTreeBeforeAsync,
                    onAsyncSuccess: depTreeOnAsyncSuccess,
                    onClick: depTreeOnClick
                }
            };
            $.fn.zTree.init($("#departments-tree"), setting);

            zjb.ajaxGetHtml('#dep-form-wrapper', '{{ url("users/departments/create") }}');

            $("#search-dep").click(function () {
                var treeObj = $.fn.zTree.getZTreeObj("departments-tree");
                treeObj.reAsyncChildNodes(null, "refresh");
            });
        });
    </script>
@endsection
