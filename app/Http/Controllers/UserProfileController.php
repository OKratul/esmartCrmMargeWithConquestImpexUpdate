<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function addProfile($id){
//        dd($id);
        return view('addUserProfile',compact('id'));

    }

    public function profile($id){

        $this->validate(\request(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'designation'=> 'nullable',
            'email' => 'required',
            'phone' => 'required',
            'joining_date' => 'required',
            'date_of_birth' => 'required',
            'nid_img' => 'required',
            'pro_img' => 'nullable',
        ]);

        $nidExtension = \request()->file('nid_img')->extension();
        $nidImgName = \request('first_name').'_'.\request('last_name').'_'.'NID'.'.'.$nidExtension;

        \request()->file('nid_img')->move('nids',$nidImgName);

        $proImgExt = \request()->file('pro_img')->extension();
        $proImgName = \request('first_name').'_'.\request('last_name').'_'.'PRO_IMG'.'.'.$proImgExt;
        \request()->file('pro_img')->move('profiles',$proImgName);

        UserProfile::create([
            'user_id' => $id ,
            'first_name' => \request('first_name'),
            'last_name' => \request('last_name'),
            'email' => \request('email'),
            'designation' => \request('email'),
            'date_of_birth' => \request('date_of_birth'),
            'phone' => \request('phone'),
            'joining_date' => \request('joining_date'),
            'nids' => $nidImgName,
            'pro_img' => $proImgName,
        ]);

        return redirect()->back()->with('success','Profile Info Added');

    }

    public function viewProfile(){
        $id = Auth::user()->id;

        $user = Auth::user();
        $notifications = $user->notifications;

        $user_info = UserProfile::where('user_id',$id)->first();
//        dd($users);
        return view('user.userProfile', compact('user_info','id','notifications'));
    }

    public function editProfile($id){
        return view('user.editUserProfile');
    }
}
