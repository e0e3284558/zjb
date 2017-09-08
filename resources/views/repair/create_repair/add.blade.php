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
                        <h5>创建一个报修 </h5>
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
                        <form method="get" class="form-horizontal">
                            <div class="form-group"><label class="col-sm-2 control-label">选择资产类型</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="account" onchange="select_asset(this.value)">
                                        @foreach($classifies as $v)
                                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">选择资产</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="account" id="asset">
                                        <option value="">请选择资产类别</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">问题描述</label>
                                <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">图片上传</label>
                                <div id="multi-image2-upload" class="clearfix multi-image-upload multi-image-upload-lg">
                                    <div id="multi-image2-upload-file-list" class="pull-left">


                                    </div>
                                    <div id="multi-image2-upload-picker" class="pull-left m-b-sm p-xxs b-r-sm tooltips uploader-picker" data-toggle="tooltip" data-placement="top" data-original-title="文件大小10M以内">
                                        <p><i class="fa fa-plus-circle font-blue fa-2x fa-fw"></i></p>
                                        选择图片
                                    </div>

                                </div>


                            </div>


                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-white" type="submit">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function select_asset(id) {
            url='{{url('repair/create_repair/select_asset')}}/'+id;
            jQuery("#asset").empty();
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#asset").append(data);
                }
            })
        }

        $(document).ready(function(){
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
        });
    </script>
@endsection
