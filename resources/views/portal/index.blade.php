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

                    <div id="single-upload2" class="btn-upload">
                        <div id="single-upload2-picker"><i class="fa fa-upload"></i> 选择图片</div>
                        <div id="single-upload2-file-list"></div>
                    </div>

                    <hr>

                    单、多文件上传

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

                    </div>
                    单、多文件上传实例
                    <div id="multi-upload-instance" class="clearfix multi-file-upload">

                        <div id="multi-upload-instance-file-list" class="pull-left">
                        </div>

                        <div id="multi-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择文件
                        </div>

                    </div>

                    单、多图预览上传

                    <div id="multi-image-upload" class="clearfix multi-image-upload">

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

                    </div>


                    <div id="multi-image2-upload" class="clearfix multi-image-upload multi-image-upload-lg">
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

                    </div>

                    <div id="image-upload-instance" class="clearfix multi-image-upload multi-image-upload-lg">
                        <div id="image-upload-instance-file-list" class="pull-left"></div>
                        <div id="image-upload-instance-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                            <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                            选择图片
                        </div>

                    </div>

                     

     <script type="text/javascript">
         $(document).ready(function(){
            zjb.singleImageUpload({
                uploader:'singleUpload',
                picker:'single-upload',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                errorMsgHiddenTime:2000,
                uploadComplete:function(file){
                    //上传完成触发时间
                },
                uploadError:function(file){
                    //上传出错触发时间
                },
                uploadSuccess:function(file,response){
                    //上传完成触发时间
                    
                }
            });

            zjb.singleImageUpload({
                uploader:'singleUpload2',
                picker:'single-upload2',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                errorMsgHiddenTime:2000,
                uploadComplete:function(file){
                },
                uploadError:function(file){
                },
                uploadSuccess:function(file,response){
                }
            });



            zjb.fileUpload({
                uploader:'multiupload',
                picker:'multi-upload',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("file.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:1,
                uploadComplete:function(file){
                    // alert('com');
                },
                uploadError:function(file){
                    alert('error');
                },
                uploadSuccess:function(file,response){
                    // alert('success');
                    console.log(response);



                },
                fileCannel:function(fileId){
                    alert('cannel');
                },
                fileDelete:function(fileId){
                    alert('fileDelete');
                }
            });
            //文件上传实例
            zjb.fileUpload({
                uploader:'multiUploadInstance',
                picker:'multi-upload-instance',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("file.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:1,
                uploadComplete:function(file,uploader){},
                uploadError:function(file,uploader){},
                uploadSuccess:function(file,response,uploader){
                    // alert('success');
                    console.log(response);
                    console.log(uploader);
                },
                fileCannel:function(fileId,uploader){},
                fileDelete:function(fileId,uploader){}
            });


            zjb.imageUpload({
                uploader:'multiImageUpload',
                picker:'multi-image-upload',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:10,
                uploadComplete:function(file){
                    alert('com');
                },
                uploadError:function(file){
                    alert('error');
                },
                uploadSuccess:function(file,response){
                    alert('success');
                },
                fileCannel:function(fileId){
                    alert('cannel');
                },
                fileDelete:function(fileId){
                    alert('fileDelete');
                }
            });
            zjb.imageUpload({
                uploader:'multiImageUpload2',
                picker:'multi-image2-upload',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    // '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:10,
                uploadComplete:function(file){
                    alert('com');
                },
                uploadError:function(file){
                    alert('error');
                },
                uploadSuccess:function(file,response){
                    alert('success');
                },
                fileCannel:function(fileId){
                    alert('cannel');
                },
                fileDelete:function(fileId){
                    alert('fileDelete');
                }
            });

            //图片上传实例
            zjb.imageUpload({
                uploader:'imageUploadInstance',
                picker:'image-upload-instance',
                swf: '{{ asset("assets/js/plugins/webuploader/Uploader.swf") }}',
                server: '{{ route("image.upload") }}',
                formData: {
                    '_token':'{{ csrf_token() }}'
                },
                fileNumLimit:10,
                uploadComplete:function(file, uploader){},
                uploadError:function(file, uploader){},
                uploadSuccess:function(file,response, uploader){},
                fileCannel:function(fileId, uploader){},
                fileDelete:function(fileId, uploader){}
            });
         });
     </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection