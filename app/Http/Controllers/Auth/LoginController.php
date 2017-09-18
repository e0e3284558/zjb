<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username = 'username';
    protected $guard = 'web';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $request = request();
        if($request->type == 'worker'){
            $request->offsetSet('username',$request->email);
            $this->redirectTo = '/worker';
            $this->username = 'username';
            $this->guard = 'service_workers';
        }

        $this->middleware('guest:'.$this->guard)->except('logout');
    }

    protected function guard()
    {
        return Auth::guard($this->guard);
    }

    public function username()
    {
        return $this->username;
    }

//    public function logout(Request $request)
//    {
//        $this->guard()->logout();
//
//        $request->session()->invalidate();
//
//        return redirect('/');
//    }
}
