<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class ServiceWorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:service_workers']);
    }

    public function index(){
        return redirect("repair/process");
    }
}
