<?php

namespace App\Http\Controllers\Consumables;

use App\Models\Consumables\Sort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SortController extends Controller
{
    /**
     * 读取分类信息
     * @return mixed
     */
    public static function getSort()
    {
        //读取分类
        $classifies = Sort::select(DB::raw('*,concat(parent_path,",",id) as paths'))
            ->where('org_id', get_current_login_user_org_id())
            ->orderBy('paths')->get();
        //遍历数组 调整分类名称  laravel  ==》------laravel
        foreach ($classifies as $key => $value) {
            //判断当前的分类是几级分类
            $tmp = count(explode(',', $value->parent_path)) - 1;
            $prefix = str_repeat('|------', $tmp);
            $classifies[$key]->name = $prefix . $value->name;
        }
        return $classifies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取所有部门信息
        if (request('tree') == 1) {
            $select = $request->select;
            $name = $request->name;
            $where = [];
            if ($name) {
                $where[] = ['name', 'like', "%{$name}%"];
            }
            $list = Sort::where('org_id',get_current_login_user_org_id())->where($where)->get()->toArray();
            $org = get_current_login_user_org_info('name')->name;
            $tempData = [
                [
                    'id' => 0,
                    'parent_id' => -1,
                    'text' => $org,
                    'name' => $org,
                    'href' => '',//编辑地址
                    'icon' => asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/global.gif')
                ]
            ];
            if ($list) {
                foreach ($list as $key => $val) {
                    $val['href'] = url('consumables/sort/' . $val['id'] . '/edit');
                    $val['icon'] = asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/sub.gif');
                    $tempData[] = $val;
                }
            }
            return response()->json($tempData);
        }
//        $list = Department::getSpaceTreeData();
        return view('consumables.sort.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sort = self::getSort();
        return response()->view('consumables.sort.add', compact('sort'));
    }


    /**
     * 创建子类
     * @param $id
     */
    public function createSub($id)
    {
        $sort= Sort::where('id', $id)->first();
        return view('consumables.sort.add', compact('sort', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
//        dd($data);
        //如果要添加的是顶级分类  pid 和 path 都是0
        if ($data['parent_id'] == 0) {
            $data['parent_path'] = '0';
        } else {
            //如果不是顶级分类,读取父级分类信息
            $info = Sort::find($data['parent_id']);
            $data['parent_path'] = $info->parent_path . ',' . $info->id;
        }
        //创建模型
        $sort = new Sort;
        $sort->name = $data['name'];
        $sort->parent_id = $data['parent_id'];
        $sort->parent_path = $data['parent_path'];
        $sort->org_id = get_current_login_user_org_id();
        if ($sort->save()) {
            return response()->json([
                'status' => 1, 'message' => '创建成功',
                'data' => '创建成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '创建失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取所有记录
        $sort = self::getSort();
        //获取单条记录
        $only = Sort::find($id);
        //获取其父类
        foreach ($sort as $v) {
            if ($v->id === $only->parent_id) {
                $parent = $v;
            }
        }
        return view('consumables.sort.edit', compact('sort', 'only', 'parent'));
    }

    /**
     * 仅修改此分类名称
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editName($id)
    {
        $only = Sort::find($id);
        return view('consumables.sort.editName', compact('only'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res = Sort::where('id', $id)->update($request->except('_token', '_method', 'id'));
        if ($res) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => '编辑成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '编辑失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //获取id删除该条数据
        $info = Sort::find($id);
        //删除子集分类
        $path = $info->parent_path;
        $path = $path . ',' . $id;
        $info = Sort::where('parent_path', 'like', $path . "%")
            ->orWhere('id', $id)->delete();
        if ($info) {
            return response()->json([
                'status' => 1, 'message' => '删除成功',
                'data' => '删除成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '删除失败',
                'data' => null, 'url' => ''
            ]);
        }
    }
}
