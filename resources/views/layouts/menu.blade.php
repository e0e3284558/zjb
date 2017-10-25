@if(Auth::user()->is_org_admin)
    <li class="{{ active_class(if_route('home')) }}">
        <a href="{{ url('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span></a>
    </li>
@endif
    <li class="{{ active_class(if_uri_pattern('repair/*')) }}">
        <a href="javascript:;"><i class="fa fa-wrench"></i> <span class="nav-label">报修管理</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ active_class(if_route('service_provider.index'))}}"><a
                        href="{{ url('repair/service_provider?app_groups=repair') }}"><i
                            class="fa fa-angle-right"></i>
                    服务商管理</a>
            </li>
            <li class="{{ active_class(if_route('classify.index'))}}"><a
                        href="{{ url('repair/classify?app_groups=repair') }}"><i class="fa fa-angle-right"></i> 报修项目</a>
            </li>
            <li class="{{ active_class(if_route('service_worker.index'))}}"><a
                        href="{{ url('repair/service_worker?app_groups=repair') }}"><i
                            class="fa fa-angle-right"></i>
                    维修人员管理</a>
            </li>
            <li class="{{ active_class(if_route('create_repair.index'))}}"><a
                        href="{{ url('repair/create_repair?app_groups=repair') }}"><i
                            class="fa fa-angle-right"></i>
                    报修管理</a>
            </li>
            <li class="{{ active_class(if_route('create_repair.create'))}}"><a
                        href="{{ url('repair/create_repair/create?app_groups=repair') }}"><i
                            class="fa fa-angle-right"></i>
                    我要报修</a>
            </li>
            <li class="{{ active_class(if_route('repair_list.index'))}}"><a
                        href="{{ url('repair/repair_list?app_groups=repair') }}"><i class="fa fa-angle-right"></i>
                    我的报修单</a>
            </li>
        </ul>
    </li>
@if(Auth::user()->is_org_admin=="0")
    <li class="{{ active_class(if_route('repair_list.index'))}}"><a
                href="{{ url('repair/repair_list?app_groups=repair') }}"><i class="fa fa-angle-right"></i>
            报修记录</a>
    </li>
    <li class="{{ active_class(if_route('create_repair.create'))}}"><a
                href="{{ url('repair/create_repair/create?app_groups=repair') }}"><i
                    class="fa fa-angle-right"></i>
            我要报修</a>
    </li>
@endif
@if(auth('service_workers')->user())
    <li class="{{ active_class(if_route('process.index'))}}"><a
                href="{{ url('repair/process?app_groups=repair') }}"><i class="fa fa-angle-right"></i>
            维修单列表</a>
    </li>
@endif
@if(Auth::user()->is_org_admin)
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
            <li class="{{ active_class(if_route('permission')) }}"><a
                        href="{{ route('permission.index',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i>
                    权限管理</a></li>
            <li class="{{ active_class(if_route('users.index')) }}"><a
                        href="{{ route('users.index',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 用户列表</a>
            </li>
        </ul>
    </li>
    <li class="{{ active_class(if_uri_pattern('asset/*') || if_query('app_groups','asset')) }}">
        <a href="javascript:;"><i class="fa fa-credit-card"></i> <span class="nav-label">资产管理</span> <span
                    class="fa arrow"></span></a>

        <ul class="nav nav-second-level collapse">
            <li class="{{ active_class(if_route('asset.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 资产管理</a>
            </li>

            <li class="{{ active_class(if_route('asset_transfer.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset_transfer.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 资产调拨</a>
            </li>

            <li class="{{ active_class(if_route('asset_use.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset_use.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 领用</a>
            </li>

            <li class="{{ active_class(if_route('asset_return.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset_return.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 退库</a>
            </li>

            <li class="{{ active_class(if_route('borrow.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('borrow.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i>
                    借用&归还</a>
            </li>

            <li class="{{ active_class(if_route('asset_clear.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset_clear.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i>
                    清理报废</a>
            </li>

            <li class="{{ active_class(if_route('asset_category.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('asset_category.index',['app_groups'=>'asset']) }}"><i
                            class="fa fa-angle-right"></i> 资产类别</a></li>
            <li class="{{ active_class(if_route('area.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('area.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 场地管理</a>
            </li>
            {{--<li class="{{ active_class(if_route('other_asset.index') && if_query('app_groups','asset')) }}"><a--}}
            {{--href="{{ route('other_asset.index',['app_groups'=>'asset']) }}"><i--}}
            {{--class="fa fa-angle-right"></i>--}}
            {{--维修项目</a></li>--}}
            <li class="{{ active_class(if_route('supplier.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('supplier.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i>
                    供应商管理</a>
            </li>
            <li class="{{ active_class(if_route('contract.index') && if_query('app_groups','asset')) }}"><a
                        href="{{ route('contract.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i>
                    合同管理</a>
            </li>

            {{--<li class="{{ active_class(if_route('bill.index') && if_query('app_groups','asset')) }}"><a--}}
                        {{--href="{{ route('bill.index',['app_groups'=>'asset']) }}"><i class="fa fa-angle-right"></i> 清单管理</a>--}}
            {{--</li>--}}

        </ul>
    </li>

    <li class="{{ active_class(if_uri_pattern('consumables/*')) }}">
        <a href="javascript:;"><i class="fa fa-credit-card"></i> <span class="nav-label">耗材管理</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ active_class(if_route('depot.index')) }}">
                <a href="{{ route('depot.index',['app_groups'=>'consumables']) }}">
                    <i class="fa fa-angle-right"></i>
                    仓库管理
                </a>
            </li>
            <li class="{{ active_class(if_route('sort.index')) }}">
                <a href="{{ route('sort.index',['app_groups'=>'consumables']) }}">
                    <i class="fa fa-angle-right"></i>
                    物品分类
                </a>
            </li>
            <li class="{{ active_class(if_route('archiving.index')) }}">
                <a href="{{ route('archiving.index',['app_groups'=>'consumables']) }}">
                    <i class="fa fa-angle-right"></i>
                    物品管理
                </a>
            </li>

            <li class="{{ active_class(if_route('warehousing.index')) }}">
                <a href="{{ route('warehousing.index',['app_groups'=>'consumables']) }}">
                    <i class="fa fa-angle-right"></i>
                    入库管理
                </a>
            </li>
            <li class="{{ active_class(if_route('shipments.index')) }}">
                <a href="{{ route('shipments.index',['app_groups'=>'consumables']) }}">
                    <i class="fa fa-angle-right"></i>
                    出库管理
                </a>
            </li>

        </ul>
    </li>
@endif