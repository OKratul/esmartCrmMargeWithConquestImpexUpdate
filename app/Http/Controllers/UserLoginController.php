<?php

namespace App\Http\Controllers;

use App\Models\UserActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
    public function showLogin(){
        $pageTitle = 'User Login';
        return view('user.userLogin',compact('pageTitle'));
    }

    public function login(){
         $this->validate(request(),[
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'email' => request('email'),
            'password' => request('password')
        ])){
            $userIds = session('user_ids', []);
            $userIds[] = Auth::guard('web')->user()->id;
            session(['user_ids' => $userIds]);

            $loginTime = Carbon::now();




            if ($loginTime->format('H:m a') <= '10:35 am' ){
                UserActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'login_time' => Carbon::now(),
                    'status' => 'Present',
                ]) ;
            }elseif($loginTime->format('H:m a') >= '10:35 am'){
                UserActivityLog::create([
                    'status' => 'Late',
                    'user_id' => Auth::user()->id,
                    'login_time' => Carbon::now(),
                ]) ;
            }else{
                UserActivityLog::create([
                    'status' => 'Absent'
                ]) ;
            }

            return redirect()->route('user-dashboard');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Credential does not match']);
        }
    }

    public function logout(){
//        $this->guard()->logout();
        $user = Auth::guard('web')->user();
        UserActivityLog::where('user_id',Auth::user()->id)
            ->whereDate('login_time',Carbon::now()->format('Y-m-d'))
            ->update([
            'logout_time'=> Carbon::now(),
        ]);
        Auth::guard('web')->logout();
        Session::forget('login_web_'.$user->id);


        return to_route('user-login');
    }

}
