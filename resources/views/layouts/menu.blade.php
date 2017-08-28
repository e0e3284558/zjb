<li class="{{ active_class(if_route('home') || if_query('app_groups',null)) }}">
    <a href="{{ url('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span></a>
</li>
<li class="{{ active_class(if_query('app_groups','repair')) }}">
    <a href="javascript:;"><i class="fa fa-wrench"></i> <span class="nav-label">报修管理</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_route('classify.index'))}}"><a
                    href="{{ url('repair/classify?app_groups=repair') }}"><i class="fa fa-angle-right"></i> 报修分类</a>
        </li>
        <li class="{{ active_class(if_route('service_worker.index'))}}"><a
                    href="{{ url('repair/service_worker?app_groups=repair') }}"><i class="fa fa-angle-right"></i> 维修工管理</a>
        </li>
    </ul>
</li>
<li class="{{ active_class(if_query('app_groups','users')) }}">
    <a href="javascript:;"><i class="fa fa-sitemap"></i> <span class="nav-label">用户管理</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_route('users.unit')) }}"><a
                    href="{{ route('users.unit',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 单位信息</a>
        </li>
        <li class="{{ active_class(if_route('users.departments')) }}"><a
                    href="{{ route('users.departments',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i>
                组织机构</a></li>
        <li class="{{ active_class(if_route('users.groups')) }}"><a
                    href="{{ route('users.groups',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i>
                角色管理</a></li>
        <li class="{{ active_class(if_route('users.index')) }}"><a
                    href="{{ route('users.index',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 用户列表</a>
        </li>
    </ul>
</li>

<li class="{{ active_class(if_query('app_groups','asset')) }}">
    <a href="javascript:;"><i class="fa fa-credit-card"></i> <span class="nav-label">资产管理</span> <span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_route('asset_category.index') && if_query('app_groups','asset')) }}"><a href="{{ route('asset_category.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 资产类别</a></li>
        <li class="{{ active_class(if_route('area.index') && if_query('app_groups','asset')) }}"><a href="{{ route('area.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 场地管理</a></li>
        <li class="{{ active_class(if_route('other_asset.index') && if_query('app_groups','asset')) }}"><a href="{{ route('other_asset.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 其他报修项</a></li>
        <li class="{{ active_class(if_route('asset.index') && if_query('app_groups','asset')) }}"><a href="{{ route('asset.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 资产管理</a></li>
    </ul>
</li>