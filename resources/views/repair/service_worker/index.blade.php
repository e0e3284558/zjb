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
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>分类列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                <li >
                                    <button class="btn btn-primary" onclick="add('{{url("repair/service_worker/create")}}')">添加维修工</button>
                                </li>
                                @foreach($data as $v)
                                    <li class="dd-item" onclick="serviceWorker('{{$v->id}}')">
                                        <div class="dd-handle" title="{{$v->comment}}">
                                            <span class="label label-info"><i class="{{$v->icon}}"></i></span>
                                            {{$v->name}}
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" id="create">
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

    /*更新所选分类的维修工*/
    function serviceWorker(id) {
        url='{{url('repair/service_worker')}}/'+id;
        $.ajax({
            "url": url,
            "type": 'get',
            success: function (data) {
                $("#create").html(data);
            }
        })
    }
</script>