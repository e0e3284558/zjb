<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
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
            $data = Borrow::where($map)->orderBy("id", "desc")->paginate(request('limit'));

//            foreach ($data as $key => $value) {
//                //图片
//                $data[$key]['file'] = Asset::find($value->id)->file()->first();
//                $data[$key]['img_path'] = '<img class="cursor_pointer img-md"  src="'.$data[$key]['file']["path"].'" data-toggle="modal" data-target=".bs-example-modal-md" />';
//                $data[$key]['file_id'] = $data[$key]['file']['id'];
//            }

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.borrow.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
