<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Session;

class UserStaffAddController extends Controller
{
    public function index(){

        $users = User::with('invoices','queries','quotations')->get();
        $userIds = session()->get('user_id');

        $pageTitle = 'Admin Add user';

//        dd($users);

        return view('addUsers',compact('users','userIds','pageTitle'));
//        echo $userIds;
    }
}
