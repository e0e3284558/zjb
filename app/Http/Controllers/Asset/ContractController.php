<?php

namespace App\Http\Controllers\Asset;

use App\Jobs\MyJob;
use App\Models\Asset\AssetCategory;
use App\Models\Asset\Bill;
use App\Models\Asset\Contract;
use App\Models\Asset\Supplier;
use App\Models\User\Org;
use QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('contract.index')){
            return $res;
        }
        if ($request->ajax()) {
            $search = $request->get('search');
            $map = [
                ['org_id', '=', get_current_login_user_org_id()]
            ];

            $data = Contract::where($map)
                ->where(function ($query) use ($search) {
                    $query->when($search, function ($querys) use ($search) {
                        $querys->where('name', 'like', "%{$search}%");
                    });
                })->with("org","file")->where($map)->orderBy('id', 'desc')->paginate(request('limit'));

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.contract.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('contract.add')){
            return $res;
        }
        $org_name = Org::where("id",get_current_login_user_org_id())->value("name");
        return response()->view("asset.contract.add",compact('org_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($res = is_permission('contract.add')){
            return $res;
        }
        $arrs = [
            'name' => $request->name,
            'first_party' => Org::where("id",get_current_login_user_org_id())->value("name"),
            'second_party' => $request->second_party,
            'third_party' => $request->third_party,
            'remarks' => $request->remarks,
            'file_id' => $request->file_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'org_id' => get_current_login_user_org_id(),
            'sign_date' => $request->sign_date
        ];
        $contract_id = Contract::insertGetId($arrs);

        $info=null;
        foreach ($request->names as $k=>$v){
            if($request->names[$k]==null){
                continue;
            }
            $arr['contract_id'] = $contract_id;
            $arr['asset_name'] = $request->names[$k];
            $arr['category_id'] = $request->category_id[$k];
            $arr['spec'] = $request->spec[$k];
            $arr['num'] = $request->num[$k];
            $arr['calculate'] = $request->calculate[$k];
            $arr['money'] = $request->money[$k];
            $arr['supplier_id'] = $request->second_party;
            $arr['org_id'] = get_current_login_user_org_id();
            $arr['status'] = "1";
            $arr['production_date'] = $request->production_date[$k];
            $arr['created_at'] = date("Y-m-d H:i:s");
            $info = Bill::insert($arr);
        }

        if($info){
            $message = [
                'status'=>1,
                'message'=>"添加成功"
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '添加失败'
            ];
        }
        return response()->json($message);
    }


    /**
     * @param $contract_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_bill($contract_id){
        $list1 = AssetCategory::where("org_id",get_current_login_user_org_id())->get();
        return view("asset.contract.add_bill",compact("contract_id","list1"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bill_store(Request $request)
    {
        $info=null;
        foreach ($request->name as $k=>$v){
            if($request->name[$k]==null){
                continue;
            }
            $arr['contract_id'] = $request->contract_id;
            $arr['asset_name'] = $request->name[$k];
            $arr['category_id'] = $request->category_id[$k];
            $arr['spec'] = $request->spec[$k];
            $arr['num'] = $request->num[$k];
            $arr['calculate'] = $request->calculate[$k];
            $arr['money'] = $request->money[$k];
            $arr['supplier_id'] = $request->supplier_id[$k];
            $arr['status'] = "1";
            $arr['production_date'] = $request->production_date[$k];
            $arr['org_id'] = get_current_login_user_org_id();
            $arr['created_at'] = date("Y-m-d H:i:s");
            $info = Bill::insert($arr);
        }

        if($info){
            $message = [
                'status'=>1,
                'message'=>"添加成功"
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '添加失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bill_del(Request $request){
        foreach ($request->ids as $k=>$v){
            $info = Bill::where("id",$v)->first();
            if($info->status=="2"){
                return response()->json([
                    'status' => 0,
                    'message' => '不能删除'
                ]);
            }
        }

        foreach ($request->ids as $k=>$v){
            Bill::where("id",$v)->delete();
        }
        return response()->json([
            'status' => '1',
            'message' => '清单删除成功'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($res = is_permission('contract.index')){
            return $res;
        }
        $list = Bill::with("category","supplier")->where("contract_id",$id)->get();
        return view("asset.contract.show",compact("list"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('contract.edit')){
            return $res;
        }
        $info = Contract::find($id);
        $supplier_list = Supplier::where("org_id",get_current_login_user_org_id())->get();
        return view("asset.contract.edit",compact("info","supplier_list"));
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
        if ($res = is_permission('contract.edit')){
            return $res;
        }
        if($request->file_id){
            $arr = $request->except("_token","_method","file");
        }else{
            $arr = $request->except("_token","_method","file","file_id");
        }
        $info = Contract::where("id",$id)->update($arr);
        if($info){
            $message = [
                'status' => '1',
                'message' => '修改成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '修改失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = Bill::where("contract_id",$id)->get();
        foreach ($list as $k=>$v){
            if($v->status=="2"){
                return response()->json([
                    'status' => 0,
                    'message' => '此合同不能删除'
                ]);
            }
        }
        foreach ($list as $k=>$v){
            Bill::where("id",$v->id)->delete();
        }
        return response()->json([
            'status' => "1",
            'message' => '合同删除成功'
        ]);
    }

    public function test(){
        $queueId = $this->dispatch(new MyJob('key_'.str_random(4), str_random(10)));
        dd($queueId);
    }
}
