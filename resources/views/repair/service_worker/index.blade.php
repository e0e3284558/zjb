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
                    <strong>维修工管理</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
@endsection
@section('content')
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>分类列表</h5>
                    </div>
                    <div class="ibox-content">

                        <p class="m-b-lg">
                            在这就办云平台的系统上，拥有者丰富的可读可选可编辑的分类列表，您可以根据您要的方式进行定制，我们的使命是提供更高效的后勤保障系统。
                        </p>

                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                @foreach($data as $v)
                                    <li class="dd-item">
                                        <div class="dd-handle" title="{{$v->comment}}">
                                            <span class="label label-info"><i
                                                        class="{{$v->icon}}"></i></span>{{$v->name}}
                                            <span class="span-icon-right">
                                    <i class="fa fa-edit"
                                       onclick="edit('{{url('repair/classify/'.$v->id.'/edit')}}')"></i>
                                    <i class="fa fa-times span-i-icon-right" onclick="del({{$v->id}})"></i></span>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" id="create">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>维修工列表</h5>
                    </div>
                    <div class="ibox-content">
                        <p class="m-b-lg text-center">
                            {{$data[0]->comment}}
                            @if (count($errors) > 0)
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        @foreach ($errors->all() as $error)
                                        toastr.error('{{$error}}');
                                        @endforeach
                                    });
                                </script>
                            @endif

                            @if (session('success'))
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        toastr.success('{{session('success') }}');
                                    });
                                </script>
                            @endif
                            @if (session('error'))
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        toastr.warning('{{session('error') }}');
                                    });
                                </script>
                            @endif
                            <br>
                            <button class="btn btn-primary" onclick="add('{{url("repair/service_worker/create")}}')">添加维修工</button>
                        </p>

                        <div class="dd" id="nestable2">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    /*创建*/
    function add(url) {
        $.ajax({
            "url": url,
            "type": 'get',
            success: function (data) {
                $("#create").html(data);
            }
        })
    }
</script>