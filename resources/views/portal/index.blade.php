@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">详情</span>
                    <h5>用户</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$user_count}}</h1>
                    <small>用户数量</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Annual</span>
                    <h5>报修</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$process_count}}</h1>
                    <small>累计报修数</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Today</span>
                    <h5>服务商</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$provider_count}}</h1>
                    <small>服务商数量</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Low value</span>
                    <h5>维修人员</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$worker_count}}</h1>
                    <small>维修人员</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Low value</span>
                    <h5>等待维修</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$wait}}</h1>
                    <small>正在维修中</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Low value</span>
                    <h5>维修中</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$progress}}</h1>
                    <small>正在维修中</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Low value</span>
                    <h5>维修完成</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$end}}</h1>
                    <small>已完成维修</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection