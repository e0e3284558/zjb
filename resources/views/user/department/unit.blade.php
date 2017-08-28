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
<div class="fh-breadcrumb fh-breadcrumb-m full-height-layout-on">
	<div class="wrapper wrapper-content2 full-height">
      <div class="row full-height">
      	<div class="col-md-6 full-height">
      		<div class="ibox full-height-ibox">
			    <div class="ibox-title">
			        <h5>部门编辑</h5>
			    </div>
			    <div class="ibox-content margin-padding-0">
			    	<div class="ibox-content-wrapper">
				    	<div class="scroller">
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    		s <br><br><br><br><br><br><br><br><br>
				    	</div>
			    	</div>
			    	<div class="form-actions border-top ">
		                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left"><span class="ladda-label">保存</span></button>
		                <button type="button" class="btn btn-danger ladda-button" id="delete" data-style="expand-left">删除</button>
		                <button type="button" class="btn btn-default" id="cannel">取消</button>
		            </div>
			    </div>
		  	</div>
      	</div>
      	<div class="col-md-6 full-height">
      		<div class="ibox full-height-ibox">
			    <div class="ibox-title">
			        <h5>部门编辑</h5>
			    </div>
			    <div class="ibox-content margin-padding-0">
			    	<div class="scroller">
			    		<div class="full-height-wrapper">
			    			asdfasd
			    		</div>
			    	</div>
			    </div>
		  	</div>
      	</div>
      </div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
	});
</script>
@endsection