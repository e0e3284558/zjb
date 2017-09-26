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
                    <a href="javascript:;">报修管理</a>
                </li>

                <li class="active">
                    <strong>我要报修</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>报修单填写 </h5>
                    </div>
                    <div class="ibox-content" >
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active" ><a href="#tab-2" data-toggle="tab">场地报修</a></li>
                                <li class="" onclick="newImg()"><a href="#tab-1" data-toggle="tab">资产报修</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane " id="tab-1">
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal"
                                              id="asset_repair"
                                              action="{{url('repair/create_repair')}}">
                                        {{csrf_field()}}
                                        <!-- 根据位置 -->
                                            <div class="form-group slt">
                                                <label class="col-sm-2 control-label">资产位置</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control m-b" name="area_id[]"
                                                            onchange="select_asset(this)">
                                                        <option value="0">请选择</option>
                                                        @foreach($area as $v)
                                                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">报修资产</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control m-b" name="asset_id" id="asset">
                                                        <option value="">请选择</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group"><label class="col-sm-2 control-label">报修故障</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="remarks" style="resize: none" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="other" value="0">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">图片上传</label>
                                                <div class="col-sm-10">
                                                    <div id="image-upload-instance"
                                                         class="clearfix multi-image-upload multi-image-upload-lg">
                                                        <div id="image-upload-instance-file-list"
                                                             class="pull-left"></div>
                                                        <div id="image-upload-instance-picker"
                                                             class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker"
                                                             data-toggle="tooltip" data-placement="top"
                                                             data-original-title="文件大小10M以内">
                                                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i>
                                                            </p>
                                                            选择图片
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2">
                                                    <button class="btn btn-white" type="button">取消</button>
                                                    <button class="btn btn-primary" id="btn1" type="button">确认
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane active" id="tab-2">
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" id="general_repair">
                                        {{csrf_field()}}
                                        <!-- 根据位置 -->
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">报修位置</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control m-b" name="area_id[]"
                                                            onchange="select_asset2(this)">
                                                        <option value="">请选择</option>
                                                        @foreach($area as $v)
                                                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">报修项目</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control m-b" name="classify_id" id="asset">
                                                        <option value="">请选择</option>
                                                        @foreach($classify as $v)
                                                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" name="other" value="1">
                                            <div class="form-group"><label class="col-sm-2 control-label">报修故障</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="remarks" style="resize: none" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">图片上传</label>
                                                <div class="col-sm-10">
                                                    <div id="image-upload-instance2"
                                                         class="clearfix multi-image-upload multi-image-upload-lg">
                                                        <div id="image-upload-instance2-file-list"
                                                             class="pull-left"></div>
                                                        <div id="image-upload-instance2-picker"
                                                             class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker"
                                                             data-toggle="tooltip" data-placement="top"
                                                             data-original-title="文件大小10M以内">
                                                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i>
                                                            </p>
                                                            选择图片
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2">
                                                    <button class="btn btn-white" type="button">取消</button>
                                                    <button class="btn btn-primary" id="btn2" type="button">确认
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        function select_asset(obj) {
            o = $(obj);
            //清除
            ids = o.val();
            o.parent("div").nextAll("div").remove();
            if (ids == "0") {
                id = o.parent("div").prev('div').find('select').val();
            } else {
                id = ids;
            }
            url = '{{url('repair/create_repair/select_asset')}}/' + id;
            jQuery("#asset").empty();
            $.ajax({
                "url": url,
                "type": 'get',
                'dataType': 'json',
                success: function (data) {
                    $("#asset").append(data.asset);
                    if (ids != "0") {

                        //创建select
                        select1 = $("<div class='col-sm-2'></div>");
                        select = $("<select name='area_id[]' class='form-control m-b' onchange='select_asset(this)' ></select>");
                        select1.append(select);
                        if (data.area != '') {
                            if (data.area.length > 0) {
                                //遍历
                                ini = '<option value="0">请选择 </option>';
                                select.append(ini);
                                for (var i = 0; i < data.area.length; i++) {
                                    //把遍历出来数据添加到option
                                    info = '<option value="' + data.area[i].id + '">' + data.area[i].name + '</option>';
                                    //把当前info数据添加到创建的select
                                    select.append(info);
                                }
                                //把带有数据的select 追加
                                o.parent("div").after(select1);

                            }
                        }
                    }
                }
            })
        }

        //通用报修
        function select_asset2(obj) {
            o = $(obj);
            //清除
            ids = o.val();
            o.parent("div").nextAll("div").remove();
            if (ids == "0") {
                id = o.parent("div").prev('div').find('select').val();
            } else {
                id = ids;
            }
            url = '{{url('repair/create_repair/select_asset')}}/' + id;
            $.ajax({
                "url": url,
                "type": 'get',
                'dataType': 'json',
                success: function (data) {
                    if (ids != "0") {
                        //创建select
                        select1 = $("<div class='col-sm-2'></div>");
                        select = $("<select name='area_id[]' class='form-control m-b' onchange='select_asset2(this)' ></select>");
                        select1.append(select);
                        if (data.area != '') {
                            if (data.area.length > 0) {
                                //遍历
                                ini = '<option value="">请选择 </option>';
                                select.append(ini);
                                for (var i = 0; i < data.area.length; i++) {
                                    //把遍历出来数据添加到option
                                    info = '<option value="' + data.area[i].id + '">' + data.area[i].name + '</option>';
                                    //把当前info数据添加到创建的select
                                    select.append(info);
                                }
                                //把带有数据的select 追加
                                o.parent("div").after(select1);

                            }
                        }
                    }
                }
            })
        }

        $(document).ready(function () {
            zjb.initAjax();
            var lz = $("#btn1").ladda();
            var forms = $("#asset_repair");
            $('#btn1').click(function () {
                forms.submit();
            });
            /*字段验证*/
            forms.validate(
                {
                    rules: {
                        asset_id: {
                            required: true,
                            digits: true,
                            min: 1
                        },
                        remarks: {
                            maxlength: 191
                        }
                    },
                    messages: {
                        asset_id: {
                            required: "必须选择一个资产，如果没有资产请检查资产位置中的资产是否存在",
                            digits: "检查浏览器是否正常",
                            min: "检查浏览器是否正常"
                        },
                        classify_id: {
                            required: "必须选择一个分类",
                            digits: "检查浏览器是否正常",
                            min: "检查浏览器是否正常"
                        },
                        remarks: {
                            maxlength: "问题描述不可超过191字符"
                        }
                    },
                    /*ajax提交*/
                    submitHandler: function (form) {
                        jQuery.ajax({
                            url: '{{url('repair/create_repair')}}',
                            type: 'POST',
                            dataType: 'json',
                            data: forms.serialize(),
                            beforeSend: function () {
                                lz.ladda('start');
                            },
                            complete: function (xhr, textStatus) {
                                lz.ladda('stop');
                            },
                            success: function (data, textStatus, xhr) {
                                if (data.status) {
                                    toastr.success(data.message);
                                    zjb.backUrl('{{url('repair/repair_list')}}', 1000);
                                } else {
                                    toastr.error(data.message, '警告');
                                }
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                if (xhr.status == 422 && textStatus == 'error') {
                                    $.each(xhr.responseJSON, function (i, v) {
                                        toastr.error(v[0], '警告');
                                    });
                                } else {
                                    toastr.error('请求出错，稍后重试', '警告');
                                }
                            }
                        });
                        return false;
                    }
                }
            );


            var l = $("#btn2").ladda();
            var forms2 = $("#general_repair");
            $('#btn2').click(function () {
                forms2.submit();
            });
            /*字段验证*/
            forms2.validate(
                {
                    rules: {
                        "area_id[]": {
                            required: true,
                            digits: true,
                            min: 1
                        },
                        classify_id: {
                            required: true,
                            digits: true,
                            min: 1
                        },
                        remarks: {
                            maxlength: 191
                        }
                    },
                    messages: {
                        "area_id[]": {
                            required: "必须选择一个报修位置",
                            digits: "必须选择一个正确报修位置",
                            min: "必须选择一个正确报修位置"
                        },
                        classify_id: {
                            required: "必须选择一个报修项目",
                            digits: "必须选择一个正确报修项目",
                            min: "必须选择一个正确报修项目"
                        },

                        remarks: {
                            maxlength: "问题描述不可超过191字符"
                        }

                    },

                    /*ajax提交*/
                    submitHandler: function (form) {
                        jQuery.ajax({
                            url: '{{url('repair/create_repair')}}',
                            type: 'POST',
                            dataType: 'json',
                            data: forms2.serialize(),
                            beforeSend: function () {
                                l.ladda('start');
                            },
                            complete: function (xhr, textStatus) {
                                l.ladda('stop');
                            },
                            success: function (data, textStatus, xhr) {
                                if (data.status) {
                                    toastr.success(data.message);
                                    zjb.backUrl('{{url('repair/repair_list')}}', 1000);
                                } else {
                                    toastr.error(data.message, '警告');
                                }
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                if (xhr.status == 422 && textStatus == 'error') {
                                    $.each(xhr.responseJSON, function (i, v) {
                                        toastr.error(v[0], '警告');
                                    });
                                } else {
                                    toastr.error('请求出错，稍后重试', '警告');
                                }
                            }
                        });
                        return false;
                    }
                }
            )
            ;

            //资产报修图片上传
            zjb.imageUpload({
                uploader: 'imageUploadInstance2',
                picker: 'image-upload-instance2',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                isAutoInsertInput: true,//上传成功是否自动创建input存储区域
                storageInputName: 'images',//上传成功后input存储区域的name
                formData: {
                    '_token': '{{ csrf_token() }}'
                },
                fileNumLimit: 5,
                uploadComplete: function (file, uploader) {
                },
                uploadError: function (file, uploader) {
                },
                uploadSuccess: function (file, response, uploader) {
                },
                fileCannel: function (fileId, uploader) {
                },
                fileDelete: function (fileId, uploader) {
                }
            });
        })
        ;
        //通用报修图片上传
        var isset = 0;

        function newImg() {
            if (isset !== 1) {
                isset = 1;
                zjb.imageUpload({
                    uploader: 'imageUploadInstance',
                    picker: 'image-upload-instance',
                    swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                    server: '{{ route("image.upload") }}',
                    isAutoInsertInput: true,//上传成功是否自动创建input存储区域
                    storageInputName: 'images',//上传成功后input存储区域的name
                    formData: {
                        '_token': '{{ csrf_token() }}'
                    },
                    fileNumLimit: 5,
                    uploadComplete: function (file, uploader) {
                    },
                    uploadError: function (file, uploader) {
                    },
                    uploadSuccess: function (file, response, uploader) {
                    },
                    fileCannel: function (fileId, uploader) {
                    },
                    fileDelete: function (fileId, uploader) {
                    }
                });
            }
        }
    </script>
@endsection
