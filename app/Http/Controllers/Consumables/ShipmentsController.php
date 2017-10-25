<?php

namespace App\Http\Controllers\Consumables;

use App\Models\Consumables\Depot;
use App\Models\Consumables\Goods;
use App\Models\Consumables\Shipments;
use App\Models\Consumables\WarehousingInventory;
use App\Models\User\Department;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Shipments::with('depot', 'user')->paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view('consumables.shipments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depot = Depot::get();
        $department = Department::get();
        return view('consumables.shipments.add', compact('depot','department'));
    }

    /**
     * Show the form for creating a new resource.
     * 根据部门条件选择用户 AJAX
     * @return \Illuminate\Http\Response
     */
    public function selectUser($id)
    {
        $arr = [];
        $data['department'] = '';
        if ($id != 0) {
            $department = Department::find($id);
            $user = User::where('department_id', $department->id)->get();
            foreach ($user as $v) {
                $arr[] = '<option value=' . $v->id . '>' . $v->username . '</option>';
            }
            $data['department'] = Department::where("parent_id", $id)->get();
        }
        if ($arr == []) $arr[] = '<option value="">当前部门下无用户，请重新选择</option>';
        $data['user'] = $arr;
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function shipmentsGoods(Request $request)
    {
        $data = Depot::where('org_id', get_current_login_user_org_id())->get()->toJson();
        return response()->view('consumables.shipments.shipments_goods', compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inventor = [];
        $shipments = [];
        $delivery_number = 'CK' . date("Ymd") . '%';
        //设置入库单号
        $old_delivery_number = Shipments::where('org_id', get_current_login_user_org_id())
            ->where('delivery_number', 'like', $delivery_number)
            ->latest()->value('delivery_number');
        if ($old_delivery_number) {
            $delivery_number = mb_substr($old_delivery_number, -3);
            $delivery_number = str_pad(intval($delivery_number) + 1, 3, "0", STR_PAD_LEFT);
            $delivery_number = 'CK' . date("Ymd") . $delivery_number;
        } else {
            $delivery_number = 'CK' . date("Ymd") . '001';
        }
        $shipments['type'] = 2;
        $shipments['delivery_number'] = $delivery_number;
        $shipments['depot_id'] = $request->depot_id;
        $shipments['receipt_date'] = $request->receipt_date;
        $shipments['handle_date'] = date('Y-m-d');
        $shipments['user_id'] = get_current_login_user_info();
        $shipments['comment'] = $request->enter_comment;
        $shipments['org_id'] = get_current_login_user_org_id();
        $shipments_id = Shipments::insertGetId($shipments);
        if ($shipments_id) {
            foreach ($request->goods_ids as $k => $id) {
                $goods = Goods::find($id);
                $inventor['goods_id'] = $goods->id;
                $inventor['goods_name'] = $goods->name;
                $inventor['goods_coding'] = $goods->coding;
                $inventor['goods_barcode'] = $goods->barcode;
                $inventor['goods_norm'] = $goods->norm;
                $inventor['goods_unit'] = $goods->unit;
                $inventor['goods_num'] = $request->goods_num[$k];
                $inventor['goods_unit_price'] = $request->goods_price[$k];
                $inventor['goods_total_price'] = $request->goods_num[$k] * $request->goods_price[$k];
                $inventor['comment'] = $request->comment[$k];
                $inventor['warehousing_id'] = $shipments_id;
                $inventor['org_id'] = get_current_login_user_org_id();
                WarehousingInventory::insert($inventor);

                //获取关联表是否已有该物品对于该仓库的信息，如果有 则更新，没有 则新建关联关系
                $depot_goods = \DB::table('depot_goods')
                    ->where('goods_id', $goods->id)
                    ->where('depot_id', $request->depot_id)
                    ->first();
                if ($depot_goods) {
                    $goods_number = $depot_goods->goods_number - $request->goods_num[$k];
                    $goods_price = $depot_goods->goods_price - $inventor['goods_total_price'];
                    $res = \DB::table('depot_goods')
                        ->where('goods_id', $goods->id)
                        ->where('depot_id', $request->depot_id)
                        ->update(['goods_number' => $goods_number, 'goods_price' => $goods_price]);
                } else {
                    return response()->json([
                        'status' => 0, 'message' => '数据错误，保存失败',
                        'data' => null, 'url' => ''
                    ]);
                }
                if (!$res) {
                    return response()->json([
                        'status' => 0, 'message' => '保存失败',
                        'data' => null, 'url' => ''
                    ]);
                }
            }
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => $inventor
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '保存失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipments= Shipments::with('depot', 'user')->find($id);
        $details = $shipments->details()->get();
        return response()->view('consumables.shipments.show', compact('shipments', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
