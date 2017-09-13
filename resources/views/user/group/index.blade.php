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
<div class="modal animated bounceInDown" id="testModal" role="dialog" aria-labelledby="testModalLabel">
    <div class="modal-dialog modal-md" aria-hidden="true" role="document">
        <div class="modal-content">
			<div class="progress m-b-none">
			  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			    <span class="sr-only">100% Complete</span>
			  </div>
			</div>         
        </div>
    </div>
</div>
<div class="fh-breadcrumb full-height-layout-on white-bg layui-table-no-border">
 	<div class="table-tools p-sm p-tb-xs border-bottom bg-f2">
    <div class="row">
      <div class="col-md-8">
        <button class="btn blue " id="add-btn">添加</button>
        <a href="{{ route('users.groups') }}"  class="btn default ">修改</a>
        <a href="" class="btn red ">删除</a>
      </div>
      <div class="col-md-4">
        <div class="input-group">
          <input type="text" class="form-control"> 
          <span class="input-group-btn"> 
          <button type="button" class="btn blue-madison ">查询</button> 
          <a href="#testModal" class="btn default" data-toggle="modal" data-target="#testModal">高级查询</a>
          </span>
        </div>
      </div>
    </div>
 	</div>
 	<table class="layui-table" lay-filter="data-user" lay-data="{id:'dataUser',height: 'full-194', url:'{{ route("users.groups") }}',page:true,limit:15,response:{countName: 'total'}}">
      <thead>
        <tr>
          <th lay-data="{fixed:'left',checkbox:true}"></th>
          <th lay-data="{field:'id', width:80, sort: true}">ID</th>
          <th lay-data="{field:'email', width:80}">用户名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{field:'name', width:177}">签名</th>
          <th lay-data="{fixed:'right',width:160, align:'center', toolbar: '#barDemo'}">操作</th>
        </tr>
      </thead>
    </table> 
    <script type="text/html" id="barDemo">
	  <a class="btn blue btn-xs" lay-event="detail">查看</a>
	  <a class="btn blue-madison btn-xs" lay-event="edit">编辑</a>
	  <a class="btn red btn-xs" lay-event="del">删除</a>
	</script>
    <script type="text/javascript">
    $(document).ready(function(){
    	var table;
      	layui.use(['laytpl','table'], function(){
      		table = layui.table;
			table.on('checkbox(data-user)', function(obj){
				console.log(obj);
			});
       	}); 
      	$("#add-btn").click(function(){
      		var checkStatus = table.checkStatus('dataUser'); 
      		console.log(checkStatus.data);
      		$("#testModal").modal('show');
      	})

    });
    </script>
</div>
@endsection
