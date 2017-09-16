@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>自定义样式</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <img src="{{ asset('assets/img/profile.jpg') }}" class="img-circle img-md">
                    <button class="btn blue img-circle img-md">
                        这就办
                    </button>
                    <div class="bg-blue font-white img-circle img-md btn-circle-md">
                        这就办
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>自定义插件</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>上传插件</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    单个图片按钮式上传
                    <div id="single-upload" class="btn-upload">
                        <div id="single-upload-picker" class="pickers"><i class="fa fa-upload"></i> 选择图片</div>
                        <div id="single-upload-file-list"></div>
                    </div>

                    单个图片按钮式上传成功信息自动隐藏
                    <div id="single-upload2" class="btn-upload">
                        <div id="single-upload2-picker"><i class="fa fa-upload"></i> 选择图片</div>
                        <div id="single-upload2-file-list"></div>
                    </div>

                    <hr>

                   <!--  单、多文件上传

                    <div id="multi-upload" class="clearfix multi-file-upload">

                        <div id="multi-upload-file-list" class="pull-left">
                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-item-bg bg-grey-cararra full-height">
                                    <div class="text-right file-delete">
                                        <a href="" class="font-red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center">
                                        <i class="fa fa-check-circle-o font-blue fa-2x fa-fw"></i>
                                    </div>
                                    <div class="file-state text-center">
                                        13.9KB
                                    </div>
                                    <div class="file-info text-center">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>

                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-item-bg bg-grey-cararra full-height">
                                    <div class="text-right file-delete">
                                        <a href="" class="font-red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center">
                                        <i class="fa fa-exclamation-circle font-red fa-2x fa-fw"></i>
                                    </div>
                                    <div class="file-state text-center font-red">
                                        上传失败
                                    </div>
                                    <div class="file-info text-center" title="SDADASDASDSADss">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>

                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-item-bg bg-grey-cararra full-height">
                                    <div class="text-right file-cannel">
                                        <a href="" class="font-red">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center ">
                                        <i class="fa fa-circle-o-notch font-red fa-2x fa-fw font-yellow-crusta"></i>
                                    </div>
                                    <div class="file-state text-center">
                                        等待中...
                                    </div>
                                    <div class="file-info text-center" title="SDADASDASDSADss">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>

                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-item-bg bg-grey-cararra full-height">
                                    <div class="text-right file-cannel">
                                        <a href="" class="font-red">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center">
                                        <i class="fa fa-spinner fa-spin font-blue fa-2x fa-fw"></i>
                                    </div>
                                    <div class="file-state text-center">
                                        98%
                                    </div>
                                    <div class="file-info text-center" title="SDADASDASDSADss">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="multi-upload-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择文件
                        </div>

                    </div> -->
                    单文件上传实例
                    <div id="single-file-upload-instance" class="clearfix multi-file-upload">
                        <div id="single-file-upload-instance-file-list" class="pull-left">
                        </div>
                        <div id="single-file-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p class="m-b-sm"><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择文件
                        </div>
                    </div>
                    多文件上传实例
                    <div id="multi-upload-instance" class="clearfix multi-file-upload">
                        <div id="multi-upload-instance-file-list" class="pull-left">
                        </div>
                        <div id="multi-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p class="m-b-sm"><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择文件
                        </div>
                    </div>

                    

                    <!-- <div id="multi-image-upload" class="clearfix multi-image-upload">

                        <div id="multi-image-upload-file-list" class="pull-left">
                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-preview">
                                    <span class="preview"><img src="{{ asset("assets/img/a1.jpg") }}" alt=""></span>
                                </div>
                                <div class="file-item-bg full-height">
                                    <div class="text-right file-delete">
                                        <a href="javascript:;" class="font-red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center hide">
                                        <i class="fa fa-check-circle-o font-blue fa-2x fa-fw"></i>
                                    </div>
                                    <div class="file-state text-center hide">
                                        13.9KB
                                    </div>
                                    <div class="file-info text-center hide" title="SDADASDASDSADss">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="multi-image-upload-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择图片
                        </div>

                    </div> -->

                    
                    <!-- <div id="multi-image2-upload" class="clearfix multi-image-upload multi-image-upload-lg">
                        <div id="multi-image2-upload-file-list" class="pull-left">
                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-item-bg full-height">
                                    <div class="text-right file-cannel">
                                        <a href="" class="font-red">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center">
                                        <i class="fa fa-spinner fa-spin font-blue fa-2x fa-fw"></i>
                                    </div>
                                    <div class="file-state text-center">
                                        98%
                                    </div>
                                    <div class="file-info text-center" title="SDADASDASDSADss">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>
                            <div class="file-item pull-left m-r-sm m-b-sm b-r-sm border-top-bottom border-left-right p-xxs">
                                <div class="file-preview">
                                    <span class="preview"><img src="{{ asset("assets/img/a1.jpg") }}" alt=""></span>
                                </div>
                                <div class="file-item-bg full-height">
                                    <div class="text-right file-delete">
                                        <a href="javascript:;" class="font-red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="file-progress text-center hide">
                                        <i class="fa fa-check-circle-o font-blue fa-2x fa-fw"></i>
                                    </div>
                                    <div class="file-state text-center hide">
                                        13.9KB
                                    </div>
                                    <div class="file-info text-center hide" title="SDADASDASDSADss">
                                        SDADASDASDSADss.docx
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="multi-image2-upload-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择图片
                        </div>
                    </div> -->
                    单图上传实例
                    <div id="single-image-upload-instance" class="clearfix multi-image-upload">
                        <div id="single-image-upload-instance-file-list" class="pull-left"></div>
                        <div id="single-image-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小2M以内">
                            <p class="m-b-sm"><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择图片
                        </div>
                    </div>

                    多图上传实例（大尺寸）
                    <div id="image-upload-instance" class="clearfix multi-image-upload multi-image-upload-lg">
                        <div id="image-upload-instance-file-list" class="pull-left"></div>
                        <div id="image-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小2M以内">
                            <p class="m-b-sm"><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择图片
                        </div>
                    </div>

                     

     <script type="text/javascript">
         $(document).ready(function(){
            //单按钮上传，不自动创建input存储框，不隐藏上传结果
            zjb.singleImageUpload({
                uploader:'singleUpload',
                picker:'single-upload',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                errorMsgHiddenTime:2000,
                isAutoInsertInput:false,//上传成功是否自动创建input存储区域
                storageInputName:'image',//上传成功后input存储区域的name
                isHiddenResult:false,
                uploadComplete:function(file,uploader){
                    //上传完成触发时间
                },
                uploadError:function(file,uploader){
                    //上传出错触发时间
                },
                uploadSuccess:function(file,response,uploader){
                    //上传完成触发时间
                }
            });
            //单按钮上传，自动创建input存储框，隐藏上传结果
            zjb.singleImageUpload({
                uploader:'singleUpload2',
                picker:'single-upload2',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                errorMsgHiddenTime:2000,
                isAutoInsertInput:true,//上传成功是否自动创建input存储区域
                storageInputName:'image',//上传成功后input存储区域的name
                isHiddenResult:true,
                uploadComplete:function(file,uploader){
                },
                uploadError:function(file,uploader){
                },
                uploadSuccess:function(file,response,uploader){
                }
            });
            //单文件上传实例
            zjb.fileUpload({
                uploader:'singleFileUploadInstance',
                picker:'single-file-upload-instance',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("file.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:1,
                isAutoInsertInput:true,//上传成功是否自动创建input存储区域
                storageInputName:'file',//上传成功后input存储区域的name
                uploadComplete:function(file,uploader){},
                uploadError:function(file,uploader){},
                uploadSuccess:function(file,response,uploader){
                    console.log(response);
                    console.log(uploader);
                },
                fileCannel:function(fileId,uploader){},
                fileDelete:function(fileId,uploader){}
            });
            //多文件上传实例
            zjb.fileUpload({
                uploader:'multiUploadInstance',
                picker:'multi-upload-instance',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("file.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:10,
                isAutoInsertInput:true,//上传成功是否自动创建input存储区域
                storageInputName:'files',//上传成功后input存储区域的name
                uploadComplete:function(file,uploader){},
                uploadError:function(file,uploader){},
                uploadSuccess:function(file,response,uploader){
                    console.log(response);
                    console.log(uploader);
                },
                fileCannel:function(fileId,uploader){},
                fileDelete:function(fileId,uploader){}
            });

            //多图片上传实例
            zjb.imageUpload({
                uploader:'singleImageUploadInstance',
                picker:'single-image-upload-instance',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:1,
                isAutoInsertInput:true,//上传成功是否自动创建input存储区域
                storageInputName:'image',//上传成功后input存储区域的name
                uploadComplete:function(file, uploader){},
                uploadError:function(file, uploader){},
                uploadSuccess:function(file,response, uploader){
                    console.log(response);
                    console.log(uploader);
                },
                fileCannel:function(fileId, uploader){},
                fileDelete:function(fileId, uploader){}
            });

            //多图片上传实例
            zjb.imageUpload({
                uploader:'imageUploadInstance',
                picker:'image-upload-instance',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:10,
                isAutoInsertInput:true,//上传成功是否自动创建input存储区域
                storageInputName:'images',//上传成功后input存储区域的name
                uploadComplete:function(file, uploader){},
                uploadError:function(file, uploader){},
                uploadSuccess:function(file,response, uploader){
                    console.log(response);
                    console.log(uploader);
                },
                fileCannel:function(fileId, uploader){},
                fileDelete:function(fileId, uploader){}
            });
         });
     </script>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>表格带查询视图</h5>
                    <div class="ibox-tools">
                        <a class="fullscreen-link  btn btn-default btn-xs">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-toolbar">
                        <form action="" method="get" class="form-horizontal m-t-sm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 ">姓名：</label>
                                        <div class="col-md-8">
                                            <input type="text" name="name" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 ">性别：</label>
                                        <div class="col-md-8">
                                            <select name="sex" class="form-control select2"></select>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 ">姓名：</label>
                                        <div class="col-md-8">
                                            <input type="text" name="name" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">性别：</label>
                                        <div class="col-md-8">
                                            <select name="sex" class="form-control select2"></select>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 ">姓姓姓名：</label>
                                        <div class="col-md-8">
                                            <input type="text" name="name" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">性别：</label>
                                        <div class="col-md-8">
                                            <select name="sex" class="form-control select2"></select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-8">
                                            <input type="button" name="submit" class="btn blue btn-sm" value="查询">
                                            <input type="reset" name="submit" class="btn btn-default btn-sm" value="清空">
                                        </div>
                                        
                                    </div>
                                </div>   
                            </div>
                        </form>

                        <form action="" method="get" class="form-horizontal m-t-sm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon bg-grey-cararra">姓名：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group  m-b">
                                        <span class="input-group-addon bg-grey-cararra">电话：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon bg-grey-cararra">身份证号：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon bg-grey-cararra">邮箱：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group  m-b">
                                        <span class="input-group-addon bg-grey-cararra">性别：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon bg-grey-cararra">其他：</span>
                                        <select class="select2 form-control">
                                            <option>asd</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon bg-grey-cararra">身份证号：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group  m-b">
                                        <span class="input-group-addon bg-grey-cararra">性别：</span>
                                        <input type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="button" name="submit" class="btn blue " value="查询">
                                    <input type="reset" name="submit" class="btn btn-default " value="清空">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="icheck checkall" data-check=".datalist" name="checkall"></th>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>邮箱</th>
                                <th>电话</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody class="datalist">
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="1" class="icheck checkitems">
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu@ww.com
                                    </td>
                                    <td>
                                        1888888888
                                    </td>
                                    <td>
                                        <a class="btn btn-xs blue"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-xs red"><i class="fa fa-trash"></i> 删除</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="1" class="icheck checkitems">
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu@ww.com
                                    </td>
                                    <td>
                                        1888888888
                                    </td>
                                    <td>
                                        <a class="btn btn-xs blue"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-xs red"><i class="fa fa-trash"></i> 删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="icheck checkall" data-check=".datalist2" name="checkall"></th>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>邮箱</th>
                                <th>电话</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody class="datalist2">
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="1" class="icheck checkitems">
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu@ww.com
                                    </td>
                                    <td>
                                        1888888888
                                    </td>
                                    <td>
                                        <a class="btn btn-xs blue"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-xs red"><i class="fa fa-trash"></i> 删除</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="1" class="icheck checkitems">
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu
                                    </td>
                                    <td>
                                        liu@ww.com
                                    </td>
                                    <td>
                                        1888888888
                                    </td>
                                    <td>
                                        <a class="btn btn-xs blue"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-xs red"><i class="fa fa-trash"></i> 删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-b-sm"></div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>表格带查询视图</h5>
                    <div class="ibox-tools">
                        <a class="fullscreen-link  btn btn-default btn-xs">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="height: 500px;">
                    <table class="layui-table" lay-data="{height: 470, url:'{{ route("users.groups") }}',page:true,response:{countName: 'total'}}">
                      <thead>
                        <tr>
                          <th lay-data="{checkbox:true}"></th>
                          <th lay-data="{field:'id', width:80, sort: true}">ID</th>
                          <th lay-data="{field:'email', width:80}">用户名</th>
                          <th lay-data="{field:'name', width:177}">签名</th>
                        </tr>
                      </thead>
                    </table> 
                    <script>
                    $(document).ready(function(){
                       layui.use('table', function(){
                          var table = layui.table;
                        }); 
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection