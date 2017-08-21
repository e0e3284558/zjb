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
<div class="fh-breadcrumb">

    <div class="full-height">
        <div class="full-height-scroll white-bg">

            <div class="element-detail-box">

                a

            </div>

        </div>
    </div>

</div>

@endsection