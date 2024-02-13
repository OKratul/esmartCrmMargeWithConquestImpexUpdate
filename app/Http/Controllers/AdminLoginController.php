<?php

namespace App\Http\Controllers;

use App\Models\CrmAdmin;
use App\Models\DeviceInfo;
use App\Models\UserActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class AdminLoginController extends Controller
{
    public function index(){
        $pageTitle = 'Admin Login';
        return view('adminLogin',compact('pageTitle'));
    }

    public function login(){

        $ip = \request()->ip();
        $macAddress = shell_exec("arp -a $ip");
        $browser = \request()->header('User-Agent');

        $agent = new Agent();
        $deviceInfo = [
            'device'=> $agent->device(),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'is_mobile' => $agent->isMobile(),
            'is_desktop' => $agent->isDesktop(),
            'is_tablet' => $agent->isTablet(),
        ];


        $data = $this->validate(\request(),[
            'username' => 'required',
            'password' => 'required',
        ]);

       if (Auth::guard('admin')->attempt([

            'username'=>\request('username'),
            'password'=>\request('password'),

       ])){

            $admin_id = Auth::guard('admin')->id();

            UserActivityLog::create([
               'admin_id' => $admin_id,
                'login_time' => Carbon::now(),
                'status' => 'Present',
            ]);

            if (\request('username') == ''){
                DeviceInfo::create([
                    'user_name' => \request('username'),
                    'device_name' => $deviceInfo['device'],
                    'device_header' => $browser,
                    'platform' => $deviceInfo['platform'],
                    'browser' => $deviceInfo['browser'],
                    'device' => $deviceInfo['device'],
                    'login_time' => Carbon::now(),
                    'ip' => $ip,
                ]);

            }
            return to_route('dashboard');
        }
        else{
            return redirect()->back()->withErrors(['msg'=>'wrong Credential']);
        }

    }

    public function logout(){

        UserActivityLog::where('user_id',Auth::guard('admin')->id())
            ->whereDate('login_time',Carbon::now()->format('Y-m-d'))
            ->update([
                'logout_time'=> Carbon::now(),
            ]);
       Auth::guard('admin')->logout();

       return to_route('show-login');
    }
}
