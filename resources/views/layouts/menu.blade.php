@if(isset(Auth::user()->is_org_admin))
    <li class="{{ active_class(if_route('home')) }}">
        <a href="{{ url('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span></a>
    </li>
@endif
<li class="{{ active_class(if_uri_pattern('repair/*')) }}">
    <a href="javascript:;"><i class="fa fa-wrench"></i> <span class="nav-label">报修管理</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        @if(!session('worker'))
            @if(Auth::user()->is_org_admin)
                <li class="{{ active_class(if_route('service_provider.index'))}}"><a
                            href="{{ url('repair/service_provider?app_groups=repair') }}"><i
                                class="fa fa-angle-right"></i>
                        服务商管理</a>
                </li>
                <li class="{{ active_class(if_route('classify.index'))}}"><a
                            href="{{ url('repair/classify?app_groups=repair') }}"><i class="fa fa-angle-right"></i> 报修分类</a>
                </li>
                <li class="{{ active_class(if_route('service_worker.index'))}}"><a
                            href="{{ url('repair/service_worker?app_groups=repair') }}"><i
                                class="fa fa-angle-right"></i>
                        维修工管理</a>
                </li>
                <li class="{{ active_class(if_route('create_repair.index'))}}"><a
                            href="{{ url('repair/create_repair?app_groups=repair') }}"><i
                                class="fa fa-angle-right"></i>
                        报修管理</a>
                </li>
            @endif
            <li class="{{ active_class(if_route('create_repair.create'))}}"><a
                        href="{{ url('repair/create_repair/create?app_groups=repair') }}"><i
                            class="fa fa-angle-right"></i>
                    我要报修</a>
            </li>
            <li class="{{ active_class(if_route('repair_list.index'))}}"><a
                        href="{{ url('repair/repair_list?app_groups=repair') }}"><i class="fa fa-angle-right"></i>
                    我的报修单</a>
            </li>
        @else
            <li class="{{ active_class(if_route('process.index'))}}"><a
                        href="{{ url('repair/process?app_groups=repair') }}"><i class="fa fa-angle-right"></i>
                    维修单列表</a>
            </li>

        @endif

    </ul>
</li>

@if(isset(Auth::user()->is_org_admin))
    <li class="{{ active_class(if_uri_pattern('users/*')) }}">
        <a href="javascript:;"><i class="fa fa-sitemap"></i> <span class="nav-label">用户管理</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ active_class(if_route('users.unit')) }}"><a
                        href="{{ route('users.unit',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 单位信息</a>
            </li>
            <li class="{{ active_class(if_route('users.departments')) }}"><a
                        href="{{ route('users.departments',['app_groups'=>'users']) }}"><i
                            class="fa fa-angle-right"></i>
                    组织机构</a></li>
            <li class="{{ active_class(if_route('users.groups')) }}"><a
                        href="{{ route('users.groups',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i>
                    角色管理</a></li>
            <li class="{{ active_class(if_route('users.index')) }}"><a
                        href="{{ route('users.index',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 用户列表</a>
            </li>
        </ul>
    </li>




    <li class="{{ active_class(if_uri_pattern('asset/*') || if_query('app_groups','asset')) }}">
        <a href="javascript:;"><i class="fa fa-credit-card"></i> <span class="nav-label">资产管理</span> <span
                    class="fa arrow"></span></a>

        <ul class="nav nav-second-level collapse">
            <li class="{{ active_class(if_route('asset_category.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset_category.index',['app_groups'=>'asset']) }}"><i
                            class="fa fa-angle-right"></i>
                    资产类别</a></li>
            <li class="{{ active_class(if_route('area.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('area.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 场地管理</a>
            </li>
            {{--<li class="{{ active_class(if_route('other_asset.index') && if_query('app_groups','asset')) }}"><a--}}
                        {{--href="{{ route('other_asset.index',['app_groups'=>'asset']) }}"><i--}}
                            {{--class="fa fa-angle-right"></i>--}}
                    {{--维修项目</a></li>--}}
            <li class="{{ active_class(if_route('asset.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 资产管理</a>
            </li>
            <li class="{{ active_class(if_route('supplier.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('supplier.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 供应商管理</a>
            </li>
        </ul>
    </li>
@endif