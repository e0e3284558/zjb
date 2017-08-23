@extends('layouts.app')
@section('content')
    <div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>分类列表</h5>
                    </div>
                    <div class="ibox-content">

                        <p class="m-b-lg">
                            在这就办云平台的系统上，拥有者丰富的可读可选可编辑的分类列表，您可以根据您要的方式进行定制，我们的使命是提供更高效的后勤保障系统。
                        </p>
                        <div class="dd" id="nestable2">
                            <button class="btn btn-success" onclick="add('{{url('repair/classify/create')}}')">创建一个新分类
                            </button>
                        </div>

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

            <div class="col-lg-6" id="edit">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>分类操作</h5>
                    </div>
                    <div class="ibox-content">
                        <p class="m-b-lg">
                            简单、快速的操作将大幅提升您的工作效率，点击左侧分类栏目即可实现快速编辑操作。
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            </p>

                            <div class="dd" id="nestable2">
                                <form action="{{url('repair/classify')}}" method="post">
                                    {{csrf_field()}}
                                    <li class="dd-item">
                                        <div class="dd-handle ">
                                            <label>分类名称<i>*</i></label>
                                            <input type="text" class="form-control" value="" name="name" placeholder="分类名称">
                                        </div>
                                    </li>

                                    <li class="dd-item">
                                        <div class="dd-handle ">
                                            <label>分类备注</label>
                                            <input type="text" class="form-control" value="" name="comment" placeholder="分类备注">
                                        </div>
                                    </li>

                                    <li class="dd-item">
                                        <div class="dd-handle ">
                                            <label>分类图标</label>
                                            <input type="text" class="form-control"value="" name="icon" placeholder="分类图标">
                                        </div>
                                    </li>
                                    <li class="dd-item">
                                        <div class="dd-handle ">
                                            <label>分类排序</label>
                                            <input type="number" class="form-control" value="0" name="sorting"
                                                   placeholder="分类排序">
                                        </div>
                                    </li>
                                    <li>
                                        <input type="hidden" name="org_id" value="{{session('org_id',0)}}">
                                        <button type="submit" class="btn btn-success">添加</button>
                                    </li>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        /*创建*/
        function add(url) {
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#edit").html(data);
                }
            })
        }

        /*修改*/
        function edit(url) {
            $.ajax({
                "url": url,
                "type": 'get',
                success: function (data) {
                    $("#edit").html(data);
                }
            })
        }

        /*删除*/
        function del(id) {
            layer.confirm('确认要删除吗？', function () {
                //发异步删除数据
                $.post("{{url('repair/classify/')}}/" + id, {
                    '_method': 'delete',
                    '_token': "{{csrf_token()}}"
                }, function (data) {
                    if (data.status == 'success') {
                        layer.msg(data.message, {icon: 6});
                        window.location.reload();
                    } else {
                        layer.msg('删除失败', {icon: 5});
                    }
                });
            });
        }
    </script>

@endsection