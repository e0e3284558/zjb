<li class="{{ active_class(if_route('home')) }}">
    <a href="{{ url('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span></a>
</li>

<li>
    <a href="javascript:;"><i class="fa fa-group"></i> <span class="nav-label">用户管理</span> <span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_route('users.unit')) }}"><a href="{{ url('users/unit') }}"><i class="fa fa-angle-right"></i> 单位信息</a></li>
        <li class="{{ active_class(if_route('users.orgs')) }}"><a href="{{ url('users/orgs') }}"><i class="fa fa-angle-right"></i> 组织机构</a></li>
        <li class="{{ active_class(if_route('users.groups')) }}"><a href="{{ url('users/groups') }}"><i class="fa fa-angle-right"></i> 用户组管理</a></li>
        <li class="{{ active_class(if_route('users.index')) }}"><a href="{{ url('users/index') }}"><i class="fa fa-angle-right"></i> 用户列表</a></li>
    </ul>
</li>