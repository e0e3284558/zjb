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
	                <strong>用户列表</strong>
	            </li>
	        </ol>
	    </div>
	    <div class="col-lg-2">
	    </div>
	</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title">
	                <h5>用户列表</h5>
	                <div class="ibox-tools">
	                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                        <i class="fa fa-wrench"></i>
	                    </a>
	                    <ul class="dropdown-menu dropdown-user">
	                        <li><a href="#">Config option 1</a>
	                        </li>
	                        <li><a href="#">Config option 2</a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	            <div class="ibox-content">
					 
	            </div>
	        </div>
		</div>
	</div>	
</div>
<script type="text/javascript">
	$(document).ready(function() {
		
		$('body').removeClass('full-height-layout');

	} );
</script>

@endsection