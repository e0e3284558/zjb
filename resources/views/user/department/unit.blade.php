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
	                <a href="javascript:;">用户管理</a>
	            </li>

	            <li class="active">
	                <strong>单位信息</strong>
	            </li>
	        </ol>
	    </div>
	    <div class="col-lg-2">
	    </div>
	</div>
@endsection

@section('content')
<div class="wrapper wrapper-content wrapper-content2">
	<div class="row">
		<div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-title">
	                <h5>单位信息</h5>
	                <div class="ibox-tools">
	                    <a class="fullscreen-link  btn btn-default btn-xs">
	                    	<i class="fa fa-expand"></i>
	                    </a>
	                </div>
	            </div>
	            <div class="ibox-content relative-ibox-content">
					 <form action="{{ route('users.unit_edit') }}" id="unit" method="POST" class="form-horizontal">
					 	
					 	<div class="form-group">
					 		<label class="col-md-3 control-label"></label>
					 		<div class="col-md-7">
					 			<div id="logo-show">
					 			@if ($unit->logo)
							  		<img src="{{ asset($unit->logo) }}" class="img-circle img-md">
								@else
								  	<div class="bg-blue font-white img-circle img-md btn-circle-md text-center">
									{{$unit->short_name}}
									</div>  
								@endif
								</div>
								<p class=""><input type="hidden" name="logo" value="{{ $unit->logo }}"></p>
								<div id="single-upload" class="btn-upload m-t-sm">
			                        <div id="single-upload-picker" class="pickers tooltips" data-toggle="tooltip" data-placement="bottom" data-original-title="logo仅支持 JPG、PNG、GIF 格式，文件最大2 MB。"><i class="fa fa-upload"></i> 更换logo</div>
			                        <div id="single-upload-file-list"></div>
			                    </div> 
					 		</div>
					 	</div>
					 	<div class="hr-line-dashed"></div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">单位全称<span class="required">*</span></label>
					 		<div class="col-md-7">
					 			<input type="text" name="name" value="{{ $unit->name }}" class="form-control">
					 			<span class="help-block">请填写单位全称</span>
					 		</div>
					 	</div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">单位简称<span class="required">*</span></label>
					 		<div class="col-md-7">
					 			<input type="text" name="short_name" value="{{ $unit->short_name }}"  class="form-control">
					 			<span class="help-block">请填写单位简称</span>
					 		</div>
					 	</div>
					 	<div class="hr-line-dashed"></div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">单位简介<span class="required"></span></label>
					 		<div class="col-md-7">
					 			<textarea class="form-control" name="describe" cols="3" >{{ $unit->describe }}</textarea>
					 			<span class="help-block">请填写单位简介</span>
					 		</div>
					 	</div>
					 	<div class="hr-line-dashed"></div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">联系人<span class="required">*</span></label>
					 		<div class="col-md-7">
					 			<input type="text" name="contacts" value="{{ $unit->contacts }}"  class="form-control">
					 			<span class="help-block">请填写单位联系人</span>
					 		</div>
					 	</div>
					 	<div class="hr-line-dashed"></div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">电话<span class="required">*</span></label>
					 		<div class="col-md-7">
					 			<input type="text" name="contacts_tel" value="{{ $unit->contacts_tel }}" class="form-control">
					 			<span class="help-block">请填写单位联系人电话，例: 1811xxxx236 或 010-57xxxx93</span>
					 		</div>
					 	</div>
					 	<div class="hr-line-dashed"></div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">职位</label>
					 		<div class="col-md-7">
					 			<input type="text" name="contacts_postion" value="{{ $unit->contacts_postion }}" class="form-control">
					 			<span class="help-block">请填写单位联系人职位</span>
					 		</div>
					 	</div>
					 	<div class="hr-line-dashed"></div>
					 	<div class="form-group">
					 		<label class="col-md-3 control-label">邮箱</label>
					 		<div class="col-md-7">
					 			<input type="text" name="contacts_email" value="{{ $unit->contacts_email }}" class="form-control">
					 			<span class="help-block">请填写单位联系人邮箱</span>
					 		</div>
					 	</div>
					 	<div class="form-actions border-top">
					 		<label class="col-md-3 control-label"></label>
					 		<div class="col-md-7">
					 			{{ csrf_field() }}
					 			<button type="submit" class="btn btn-success blue" id="submit" data-style="expand-left"><span class="ladda-label">保存</span></button>
					 		</div>
					 	</div>
					 </form>
	            </div>
	        </div>
		</div>
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
                $img = $('#logo-show').find('img');
                if(!$img.length){
                	$img = $('#logo-show').html('<img src="'+response.data.url+'" class="img-circle img-md">');
                }else{
                	$img.attr({'src':response.data.url});
                }
                $('input[name="logo"]').val(response.data.path);
                window.setTimeout(function () {
                	$('#'+file.id).remove();
                }, 2000);
            }
        });
		var forms = $('#unit');
		var l = $('#submit').ladda();
		forms.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                name: {
                    required: true
                },
                short_name: {
                    required: true
                },
                contacts: {
                    required: true
                },
                contacts_tel: {
                    required: true
                }
            },
            messages:{
            	
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.parent(".input-group").length > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').length > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').length > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').length > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').length > 0) { 
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                jQuery.ajax({
                    url: forms.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: forms.serialize(),
                    beforeSend: function(){
                        // zjb.blockUI();
                        l.ladda('start');
                    },
                    complete: function(xhr, textStatus) {
                        // zjb.unblockUI();
                        l.ladda('stop');
                    },
                    success: function(data, textStatus, xhr) {
                        if(data.status){
                            toastr.success(data.message);
                            // zjb.backUrl('{!! url("users/unit?app_groups=users") !!}',1000);
                        }else{
                           toastr.error(data.message,'警告'); 
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        if(xhr.status == 422 && textStatus =='error'){
                            $.each(xhr.responseJSON,function(i,v){
                                toastr.error(v[0],'警告');
                            });
                        }else{
                            toastr.error('请求出错，稍后重试','警告');
                        }
                    }
                });
                return false;
            }
        });
	});
</script>
@endsection