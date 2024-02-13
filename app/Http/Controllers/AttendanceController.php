<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance(){

        $pageTitle = 'Admin User Attendance';

        $today = Carbon::now()->format('Y-m-d');

        $users = User::with(['attendances' => function ($query) use ($today) {
            $query->whereDate('login_time', $today)
                ->orderBy('login_time', 'asc');;
        }])
            ->get();

        $attendances = UserActivityLog::with('users')->get()->all();

//        dd($attendances);
        return view('adminUsersAttendance',compact('users', 'attendances','pageTitle'));

    }
}
