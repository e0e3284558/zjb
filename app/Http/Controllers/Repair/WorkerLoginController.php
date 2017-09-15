<?php

namespace App\Http\Controllers\Repair;

use App\Models\Repair\ServiceWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class WorkerLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("repair.login.login");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info = ServiceWorker::where('username',$request->username)->first();
        if($info){
            if(Hash::check($request->password, $info->password)){
                session(['worker'=>$info]);
                return redirect("repair/process");
            }else{
                return back();
            }
        }else{
            return back();
        }
    }
}
