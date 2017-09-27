<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Bill;
use App\Models\Asset\Contract;
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
        if ($request->ajax()) {
            $org_id = Auth::user()->org_id;
            $map = [
                ['org_id', '=', $org_id]
            ];
//            if ($request->category_id) {
//                $map[] = ['category_id', '=', $request->category_id];
//            }
//            if ($request->search) {
//                $map[] = ['name', 'like', '%' . $request->search . '%'];
//            }
            $data = Contract::with("org","file")->where($map)->orderBy("id", "desc")->paginate(request('limit'));

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
//            foreach ($data as $k=>$v){
//                $data[$k]['download'] = '<a href="{{url($data[$k]["file"][])}}" >'.$data[$k]['file']['old_name'].'</a>';
//            }
//            dd($data);
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
        return response()->view("asset.contract.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr = $request->except("_token","file");
        $arr['org_id'] = Auth::user()->org_id;

        $info = Contract::insert($arr);
        $message = [];
        if($info){
            $message = [
                'status' => '1',
                'message' => '添加成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '添加失败'
            ];
        }
        return response()->json($message);
    }


    public function add_bill($contract_id){
        return view("asset.contract.add_bill",compact("contract_id"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bill_store(Request $request)
    {
        $arr = $request->except("_token");
        $arr['org_id'] = Auth::user()->org_id;
        $arr['created_at'] = date("Y-m-d H:i:s");
        $info = Bill::insert($arr);

        if($info){
            $message = [
                'status'=>1,
                'message'=>"添加成功"
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '添加失败'
            ];
        }
        return response()->json($message);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = Bill::where("contract_id",$id)->get();
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
        $info = Contract::find($id);
        return view("asset.contract.edit",compact("info"));
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
        if($request->file_id){
            $arr = $request->except("_token","_method","file");
        }else{
            $arr = $request->except("_token","_method","file","file_id");
        }
        $info = Contract::where("id",$id)->update($arr);
        $message = [];
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
        //
    }
}
