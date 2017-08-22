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
	                <strong>组织机构管理</strong>
	            </li>
	        </ol>
	    </div>
	    <div class="col-lg-2">
	    </div>
	</div>
@endsection

@section('content')
<div class="fh-breadcrumb">
	<!-- <div class="fh-column">
	    <div class="full-height-scroll">
	    	left
	    </div>
    </div> -->
    <div class="full-height">
        <div class="full-height-scroll">
            <div class="full-height-wrapper full-height">
                <div class="row full-height">
                	<div class="col-lg-12 full-height">
		                <div class="ibox float-e-margins full-height-ibox">
		                    <div class="ibox-title">
		                        <div class="pull-left">
		                        	<div class="btn-group">
			                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" aria-expanded="false">Action <span class="caret"></span></button>
			                            <ul class="dropdown-menu">
			                                <li><a href="#">Action</a></li>
			                                <li><a href="#">Another action</a></li>
			                                <li><a href="#">Something else here</a></li>
			                                <li class="divider"></li>
			                                <li><a href="#">Separated link</a></li>
			                            </ul>
			                        </div>
		                        </div>
		                        <div class="ibox-tools pull-right">
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
								 full-ibox-content
		                    </div>
		                </div>
            		</div>
                </div>	
			    <script type="text/javascript">
			    	$(document).ready(function() {
						$('body').addClass('full-height-layout');
					} );
			    </script>
            </div>
        </div>
    </div>

</div>

@endsection