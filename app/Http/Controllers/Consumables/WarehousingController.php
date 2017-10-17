<?php

namespace App\Http\Controllers\Consumables;

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
            $user = Warehousing::paginate(request('limit'));
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
        return view('consumables.warehousing.add');
    }


    /**
     * @return \Illuminate\Http\Response
     */
    public function addFoods(Request $request)
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
        $details=[];
        foreach ($request->goods_ids as $id) {
            $goods = Goods::find($id);
            $details['goods_id']=$goods->id;
            $details['goods_name']=$goods->goods_name;
            $details['goods_coding']=$goods->goods_coding;
            $details['goods_barcode']=$goods->goods_barcode;
            $details['goods_norm']=$goods->goods_norm;
            $details['goods_unit']=$goods->goods_unit;
            $details['goods_batch']=$goods->goods_batch;
            $details['goods_num']=$goods->goods_num;
            $details['goods_unit_price']=$goods->goods_unit_price;
            $details['goods_total_price']=$goods->goods_total_price;
            $details['comment']=$goods->comment;
            $details['org_id']=get_current_login_user_org_id();
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
        //
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
