<?php

namespace App\Http\Controllers\Portal;

use App\Models\Repair\Process;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $worker_count = 0;
        $user = Auth::user();
        if ($user->is_org_admin == "0") {
            return redirect('repair/repair_list');
        }
        $user_count = User::where('org_id', $user->org_id)->count();
        $provider = DB::table('org_service_provider')
            ->where('org_id', $user->org_id)->get();
        $process_count = Process::where('org_id', $user->org_id)->count();
        $provider_count = $provider->count();
        foreach ($provider as $v) {
            $worker_count += DB::table('service_provider_service_worker')->where('service_provider_id', $v->service_provider_id)->count();
        }
        $wait = Process::where('org_id', $user->org_id)
            ->where('status', 1)
            ->orWhere('status', 2)
            ->count();
        $progress = Process::where('org_id', $user->org_id)
            ->where('status', 3)
            ->orWhere('status', 4)
            ->orWhere('status', 7)
            ->count();
        $end = Process::where('org_id', $user->org_id)
            ->where('status', 5)
            ->orWhere('status', 6)
            ->count();
        return view('portal.index', compact(
            'user_count', 'provider_count', 'process_count', 'worker_count','wait','progress','end'
        ));
    }
}
