<?php
/**
 * 自定义帮助函数
 * User: Guess
 * Date: 2017/8/23
 * Time: 上午11:57
 */

/**
 *  对象装换成数组
 * @param unknown $cgi
 * @param number $type
 * @return Ambigous <multitype:, multitype:multitype: unknown >
 */
if (!function_exists('object2array')) {
    function object2array(&$cgi, $type = 0)
    {
        if (is_object($cgi)) {
            $cgi = get_object_vars($cgi);
        }
        if (!is_array($cgi)) {
            $cgi = array();
        }
        foreach ($cgi as $kk => $vv) {
            if (is_object($vv)) {
                $cgi[$kk] = get_object_vars($vv);

                object2array($cgi[$kk], $type);
                //utf8_gbk($vv);
            } else if (is_array($vv)) {
                object2array($cgi[$kk], $type);
            } else {
                $v = $vv;
                $k = $kk;
                $cgi["$k"] = $v;
            }
        }
        return $cgi;
    }
}
/**
 * 循环创建目录
 */
if (!function_exists('createDir')) {
    function createDir($path)
    {
        if (!file_exists($path)) {
            createDir(dirname($path));
            mkdir($path, 0777);
        }
    }
}
/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str 要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
if (!function_exists('str2arr')) {
    function str2arr($str, $glue = ',')
    {
        return explode($glue, $str);
    }
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array $arr 要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
if (!function_exists('arr2str')) {
    function arr2str($arr, $glue = ',')
    {
        if (is_array($arr)) {
            return implode($glue, $arr);
        } else {
            return '';
        }
    }
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
if (!function_exists('list_to_tree')) {
    function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}
/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree 原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array $list 过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
if (!function_exists('tree_to_list')) {
    function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array())
    {
        if (is_array($tree)) {
            $refer = array();
            foreach ($tree as $key => $value) {
                $reffer = $value;
                if (isset($reffer[$child])) {
                    unset($reffer[$child]);
                    tree_to_list($value[$child], $child, $order, $list);
                }
                $list[] = $reffer;
            }
            $list = list_sort_by($list, $order, $sortby = 'asc');
        }
        return $list;
    }
}
/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
if (!function_exists('list_sort_by')) {
    function list_sort_by($list, $field, $sortby = 'asc')
    {
        if (is_array($list)) {
            $refer = $resultSet = array();
            foreach ($list as $i => $data)
                $refer[$i] = &$data[$field];
            switch ($sortby) {
                case 'asc': // 正向排序
                    asort($refer);
                    break;
                case 'desc':// 逆向排序
                    arsort($refer);
                    break;
                case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
            }
            foreach ($refer as $key => $val)
                $resultSet[] = &$list[$key];
            return $resultSet;
        }
        return false;
    }
}
if (!function_exists('formatTreeData')) {
    function formatTreeData($data, $id = "id", $parent_id = "parent_id", $root = 0, $space = '&nbsp;&nbsp;|--&nbsp;', $level = 0)
    {
        $arr = array();
        if ($data) {
            foreach ($data as $v) {
                if ($v[$parent_id] == $root) {
                    $v['level'] = $level + 1;
                    $v['space'] = $root != 0 ? str_repeat($space, $level) : '' . str_repeat($space, $level);
                    $arr[] = $v;
                    $arr = array_merge($arr, formatTreeData($data, $id, $parent_id, $v[$id], $space, $level + 1));
                }
            }
        }
        return $arr;
    }
}
if (!function_exists('department_select')) {
    function department_select($selected = 0, $type = 0)
    {
        $list = \App\Models\User\Department::getSpaceTreeData();
        if ($type == 1) {
            $str = '<option value="">请选择部门</option>';
        } else {
            $str = '<option value="0">顶级部门</option>';
        }

        if ($list) {
            foreach ($list as $key => $val) {
                $str .= '<option value="' . $val['id'] . '" '
                    . ($selected == $val['id'] ? 'selected="selected"' : '') . '>'
                    . $val['space'] . $val['name'] . '</option>';
            }
        }
        return $str;
    }
}

/**
 * 随机返回一个Class样式
 */

if (!function_exists('randomClass')) {
    function randomClass()
    {
        $arr = ['btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger'];
        $a = array_random($arr);
        return $a;
    }

}
if (!function_exists('random_color')) {
    function random_color()
    {
        $arr = ['default', 'blue', 'blue-madison', 'red', 'yellow', 'grey', 'green'];
        $a = array_random($arr);
        return $a;
    }
}
/**
 * 获取图片路径
 * @param $id
 * @return string
 */

if (!function_exists('get_img_path')) {
    function get_img_path($id)
    {
        $path = App\Models\File\File::find($id);
        if (!empty($path)) {
            return url("$path->path");
        } else {
            return asset('img/nopicture.jpg');
        }
    }
}

/**
 * 公司img返回缩略图或文字图标
 */
function img_circle($id, $name)
{
    if ($id != null) {
        return '<img class="img-circle img-md" src="' . get_img_path($id) . '">';
    } else {
        return '<button class="btn blue img-circle img-md" type="button"> ' . mb_substr($name, 2, 2) . ' </button>';
    }
}


function id_to_imgs($id)
{
    if ($id != null) {
        return '<img class="img-md" src="' . get_img_path($id) . '">';
    } else {
        return '<img class="img-md" src="img/noavatar.png">';
    }
}

/**
 * 头像返回缩略图或文字图标
 */
function avatar_circle($img_path, $name)
{
    if ($img_path !== null) {
        return '<img class="img-circle img-md" src="' . get_img_path($img_path) . '">';
    } else {

        return '<span class="bg-' . random_color() . ' font-white img-circle img-sm btn-circle-sm inline-block" >' . mb_substr($name, 0, 1) . '</span>';
    }
}

/**
 * @param $id
 */
function id_to_img($id)
{
    if ($id) {
        return \App\Models\File\File::find($id)->path;
    } else {
        return url('img/noavatar.png');
    }

}

/**
 * 获取当前登录用户信息
 */
if (!function_exists('get_current_login_user_info')) {
    function get_current_login_user_info($field = 'id', $guard = 'web')
    {
        if ($field === true) {
            return auth($guard)->user();
        }
        return auth($guard)->user()->$field;
    }
}
/**
 * 获取当前登录用户所属单位id
 */
if (!function_exists('get_current_login_user_org_id')) {
    function get_current_login_user_org_id($guard = 'web')
    {
        return get_current_login_user_info('org_id', $guard);
    }
}
/**
 * 获取当前登录用户所属单位信息
 */
if (!function_exists('get_current_login_user_org_info')) {
    function get_current_login_user_org_info($field = true, $guard = 'web')
    {
        $data = auth($guard)->user()->org; //get_current_login_user_info('org', $guard)
        if ($field == true) {
            return $data;
        }
        return isset($data[$field]) ? $data[$field] : null;
    }
}
/**
 * 获取客户端ip地址
 */
if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        return request()->ip();
    }
}

/**
 * 循环输出下拉框并分类
 */
if (!function_exists('loop_Arr')) {
    function loop_Arr($arr)
    {
        foreach ($arr as $v) {
            if (is_array($v)) {
                loopArr($v);
            } else {
                echo $v . "";
            }
        }
    }
}
/**
 * 根据id获取场地信息
 */
if (!function_exists('get_area')) {
    function get_area($id)
    {
        $data = '';
        $res = \App\Models\Asset\Area::find($id);
        $area = $res->path;
        $area = substr($area, 0, strlen($area) - 1);
        if ($area) {
            $address = explode(",", $area);
            foreach ($address as $v) {
                if ($v != '') {
                    $data .= \App\Models\Asset\Area::find($v)->name . '/';
                }
            }
            $data .= $res->name;
        } else {
            $data = \App\Models\Asset\Area::find($id)->name;
        }
        return $data;
    }
}


/**
 * 根据用户ID获取用户名
 */
if (!function_exists('get_username')) {
    function get_username($id)
    {
        return \App\Models\User\User::find($id)->name;
    }
}

/**
 * 根据服务商ID获取服务商
 */
if (!function_exists('get_org')) {
    function get_org($id)
    {

        return \App\Models\User\Org::find($id)->name;
    }
}

/**
 * 根据用户获取其头像如果为空，则返回首字母
 */
if (!function_exists('get_avatar')) {
    function get_avatar($id)
    {
        $avatar = \App\Models\User\User::find($id)->avatar;
        return id_to_img(intval($avatar));
    }
}

if (!function_exists('area_select')) {
    function area_select($selected = 0, $type = 0)
    {
        $list = \App\Models\Asset\Area::getSpaceTreeData();
        if ($type == 1) {
            $str = '<option value="">请选择场地</option>';
        } else {
            $str = '<option value="0">顶级场地</option>';
        }

        if ($list) {
            foreach ($list as $key => $val) {
                $str .= '<option value="' . $val['id'] . '" '
                    . ($selected == $val['id'] ? 'selected="selected"' : '') . '>'
                    . $val['space'] . $val['name'] . '(' . $val['code'] . ')' . '</option>';
            }
        }
        return $str;
    }
}


/**
 * 通过分类id 获取分类名称
 * @param $id
 * @return string
 *
 */
if (!function_exists('getCateNameByCateId')) {
    function getCateNameByCateId($id)
    {
        if ($id == 0) {
            return '顶级分类';
        }
        $cate = \App\Models\Consumables\Sort::find($id);
        if (empty($cate)) {
            return '无分类';
        } else {
            return $cate->name;
        }
    }
}

if (!function_exists('category_select')) {
    function category_select()
    {
        $list = \App\Models\Asset\AssetCategory::get();
        $str = '<option value="">请选择类别</option>';

        if ($list) {
            foreach ($list as $key => $val) {
                $str .= '<option value="' . $val['id'] . '" ' . '>'
                    . $val['name'] . '</option>';
            }
        }
        return $str;
    }
}

if (!function_exists('supplier_select')) {
    function supplier_select()
    {
        $list = \App\Models\Asset\Supplier::get();
        $str = '<option value="">请选择</option>';

        if ($list) {
            foreach ($list as $key => $val) {
                $str .= '<option value="' . $val['id'] . '" ' . '>'
                    . $val['name'] . '</option>';
            }
        }
        return $str;
    }
}

if (!function_exists('supplier_select')) {
    function supplier_select()
    {
        $list = \App\Models\Asset\Supplier::get();
        $str = '<option value="">请选择供应商</option>';

        if ($list) {
            foreach ($list as $key => $val) {
                $str .= '<option value="' . $val['id'] . '" ' . '>'
                    . $val['name'] . '</option>';
            }
        }
        return $str;
    }
}

if (!function_exists('is_permission')) {
    function is_permission($permission)
    {
        $user = get_current_login_user_info(true);
        if ($user->is_org_admin) {
            return false;
        }
        if (!$user->hasAnyPermission($permission)) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 0, 'message' => '权限不足',
                    'data' => null, 'url' => ''
                ]);
            }
            return abort(403);
        }
    }
}

/**
 * 获取当前登录用户的组织部门
 */
if (!function_exists('get_user_department')) {
    function get_user_department()
    {
        $user_department_id=get_current_login_user_info(true)->department_id;
        return App\Models\User\Department::find($user_department_id);
    }
}

/**
 * 获取当前登录用户组织部门的负责维修的场地id
 */
if (!function_exists('get_department_classify')) {
    function get_department_classify()
    {
        $department_id=get_user_department()->id;
        $classify=\Illuminate\Support\Facades\DB::table('classify_department')
                                        ->where('department_id', $department_id)
                                        ->pluck('classify_id')->toArray();
        return $classify;
    }
}

/**
 * 获取当前登录用户组织部门的负责维修的资产分类id
 */
if (!function_exists('get_department_asset_category')) {
    function get_department_asset_category()
    {
        $department_id=get_user_department()->id;
        $asset_category=\Illuminate\Support\Facades\DB::table('asset_category_department')
            ->where('department_id', $department_id)
            ->pluck('asset_category_id')->toArray();
        return $asset_category;
    }
}


/**
 * 获取当前登录用户组织部门的负责维修的场地id
 */
if (!function_exists('get_user_classify')) {
    function get_user_classify()
    {
        $user_id=get_current_login_user_info();
        $classify=\Illuminate\Support\Facades\DB::table('classify_user')
                                        ->where('user_id', $user_id)
                                        ->pluck('classify_id')->toArray();
        return $classify;
    }
}

/**
 * 获取当前登录用户组织部门的负责维修的资产分类id
 */
if (!function_exists('get_user_asset_category')) {
    function get_user_asset_category()
    {
        $user_id=get_current_login_user_info();
        $asset_category=\Illuminate\Support\Facades\DB::table('asset_category_user')
            ->where('user_id', $user_id)
            ->pluck('asset_category_id')->toArray();
        return $asset_category;
    }
}





