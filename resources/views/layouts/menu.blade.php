<li class="{{ active_class(if_route('home') || if_query('app_groups',null)) }}">
    <a href="{{ url('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span></a>
</li>
<li class="{{ active_class(if_action('App\Http\Controllers\Repair\ClassifyController@index'))}}">
    <a href="javascript:;"><i class="fa fa-group "></i> <span class="nav-label">报修分类</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_action('App\Http\Controllers\Repair\ClassifyController@index'))}}"><a
                    href="{{ url('repair/classify') }}"><i class="fa fa-angle-right"></i> 分类列表</a>
        </li>
    </ul>
</li>
<li class="{{ active_class(if_query('app_groups','users')) }}">
    <a href="javascript:;"><i class="fa fa-group"></i> <span class="nav-label">用户管理</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_route('users.unit') && if_query('app_groups','users')) }}"><a
                    href="{{ route('users.unit',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 单位信息</a>
        </li>
        <li class="{{ active_class(if_route('users.departments') && if_query('app_groups','users')) }}"><a
                    href="{{ route('users.departments',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i>
                组织机构</a></li>
        <li class="{{ active_class(if_route('users.groups') && if_query('app_groups','users')) }}"><a
                    href="{{ route('users.groups',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i>
                用户组管理</a></li>
        <li class="{{ active_class(if_route('users.index') && if_query('app_groups','users')) }}"><a
                    href="{{ route('users.index',['app_groups'=>'users']) }}"><i class="fa fa-angle-right"></i> 用户列表</a>
        </li>
    </ul>
</li>

<li class="{{ active_class(if_query('app_groups','asset')) }}">
    <a href="javascript:;"><i class="fa fa-group"></i> <span class="nav-label">资产管理</span> <span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ active_class(if_action('App\Http\Controllers\Asset\AssetCategoryController@index'))}}"><a href="{{ url('asset_category?app_groups=asset') }}"><i class="fa fa-angle-right"></i> 资产类别</a></li>
        <li class="{{ active_class(if_action('App\Http\Controllers\Asset\AreaController@index'))}}"><a href="{{ url('area?app_groups=asset') }}"><i class="fa fa-angle-right"></i> 场地管理</a></li>
        <li class="{{ active_class(if_action('App\Http\Controllers\Asset\OtherAssetController@index'))}}"><a href="{{ url('other_asset?app_groups=asset') }}"><i class="fa fa-angle-right"></i> 其他报修项</a></li>
    </ul>
</li>