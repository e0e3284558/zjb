<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Yajra\DataTables\Facades\DataTables;

class GroupsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()){
            $user = User::paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view('user.group.index');
    }
}
