<?php

namespace App\Http\Controllers\Consumables;

use App\Models\Consumables\Depot;
use App\Models\Consumables\Goods;
use App\Models\Consumables\Sort;
use App\Models\Consumables\Warehousing;
use App\Models\Consumables\WarehousingDetails;
use App\Models\Repair\Classify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WarehousingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Warehousing::with('depot', 'user')->paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view('consumables.warehousing.index');
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function storageData()
    {
        //
        $arr = Warehousing::where('org_id', get_current_login_user_org_id())->get()->toArray();
        return response()->json($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $depot = Depot::get();
        return view('consumables.warehousing.add', compact('depot'));
    }


    /**
     * @return \Illuminate\Http\Response
     */
    public function addGoods(Request $request)
    {
        $data = Sort::where('org_id', get_current_login_user_org_id())->get()->toJson();
        return response()->view('consumables.warehousing.add_goods', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $details = [];
        $warehousing = [];
        $receipt_number = 'RK' . date("Ymd") . '%';
        //设置入库单号
        $old_receipt_number = Warehousing::where('org_id', get_current_login_user_org_id())
            ->where('receipt_number', 'like', $receipt_number)
            ->latest()->value('receipt_number');
        if ($old_receipt_number) {
            $receipt_number = mb_substr($old_receipt_number, -3);
            $receipt_number = str_pad(intval($receipt_number) + 1, 3, "0", STR_PAD_LEFT);
            $receipt_number = 'RK' . date("Ymd") . $receipt_number;
        } else {
            $receipt_number = 'RK' . date("Ymd") . '001';
        }

        $warehousing['type'] = 1;
        $warehousing['receipt_number'] = $receipt_number;
        $warehousing['depot_id'] = $request->depot_id;
        $warehousing['receipt_date'] = $request->buy_time;
        $warehousing['handle_date'] = date('Y-m-d');
        $warehousing['user_id'] = get_current_login_user_info();
        $warehousing['supplier'] = $request->supplier;
        $warehousing['comment'] = $request->enter_comment;
        $warehousing['org_id'] = get_current_login_user_org_id();
        $warehousing_id = Warehousing::insertGetId($warehousing);
        if ($warehousing_id) {
            foreach ($request->goods_ids as $k => $id) {
                $goods = Goods::find($id);
                $details['goods_id'] = $goods->id;
                $details['goods_name'] = $goods->name;
                $details['goods_coding'] = $goods->coding;
                $details['goods_barcode'] = $goods->barcode;
                $details['goods_norm'] = $goods->norm;
                $details['goods_unit'] = $goods->unit;
                $details['goods_batch'] = $goods->batch;
                $details['goods_num'] = $request->goods_num[$k];
                $details['goods_unit_price'] = $request->goods_unit_price[$k];
                $details['goods_total_price'] = $request->goods_num[$k] * $request->goods_unit_price[$k];
                $details['comment'] = $request->comment[$k];
                $details['warehousing_id'] = $warehousing_id;
                $details['org_id'] = get_current_login_user_org_id();
                WarehousingDetails::insert($details);

                //获取关联表是否已有该物品对于该仓库的信息，如果有 则更新，没有 则新建关联关系
                $depot_goods = \DB::table('depot_goods')
                    ->where('goods_id', $goods->id)
                    ->where('depot_id', $request->depot_id)
                    ->first();
                if ($depot_goods) {
                    $goods_number = $depot_goods->goods_number + $request->goods_num[$k];
                    $goods_price = $depot_goods->goods_price + $details['goods_total_price'];
                    $res = \DB::table('depot_goods')
                        ->where('goods_id', $goods->id)
                        ->where('depot_id', $request->depot_id)
                        ->update(['goods_number' => $goods_number, 'goods_price' => $goods_price]);
                } else {
                    $insert['depot_id'] = $request->depot_id;
                    $insert['goods_id'] = $goods->id;
                    $insert['goods_number'] = $request->goods_num[$k];
                    $insert['goods_price'] = $details['goods_total_price'];
                    $res = \DB::table('depot_goods')->insert($insert);
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
                'data' => $details
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehousing = Warehousing::with('depot', 'user')->find($id);
        $details = $warehousing->details()->get();
        return response()->view('consumables.warehousing.show', compact('warehousing', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
