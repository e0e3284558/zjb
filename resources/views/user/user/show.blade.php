<div class="wrapper wrapper-content animated fadeInRight" id="userList">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>用户列表 </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5 m-b-xs">
                            <select class="form-control  inline" onchange="change(this.value)">
                                <option value="*">所有部门</option>
                                @if(isset($id))
                                    {!! department_select($id) !!}
                                @else
                                    {!! department_select('',1) !!}
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4 m-b-xs">
                            <div data-toggle="buttons" class="btn-group">
                                <label class="btn btn-sm btn-white"
                                       onclick="add('添加用户','{{route('users.create')}}')"
                                       data-toggle="modal" data-target=".bs-example-modal-lg">
                                    添加用户
                                </label>
                                <label class="btn btn-sm btn-white ">
                                    批量导入
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group"><input type="text" placeholder="搜索"
                                                            class="input-sm form-control"
                                id="search"> <span
                                        class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="search()"> 搜索</button> </span></div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 240px;">用户名</th>
                                <th style="width: 240px;">邮箱</th>
                                <th style="width: 200px;">手机号</th>
                                <th style="width: 280px;">所属部门</th>
                                <th style="width: 240px;">创建时间</th>
                                <th style="width: 180px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->email}}</td>
                                    <td>{{$v->tel}}</td>
                                    <td>{{$v->department->name}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>
                                        <button class="btn btn-primary"
                                                onclick="edit('编辑用户信息','{{url("users/default/$v->id/edit")}}')"
                                                data-toggle="modal" data-target=".bs-example-modal-lg">编辑
                                        </button>
                                        <button class="btn btn-danger" onclick="del('{{$v->id}}')">删除</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>