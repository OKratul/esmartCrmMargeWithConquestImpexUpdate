<?php

namespace App\Http\Controllers;

use App\Mail\UserVerificatonEmail;
use App\Models\User;
use App\Models\UserVerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function registerUser(){
          $date =  $this->validate(\request(),[
                'username' => 'required',
                'password'=>'required',
                'email' => 'required',
            ]);

         $user = User::create([
                'name'=> \request('username'),
                'email' => \request('email'),
                'password' => bcrypt(\request('password'),)
          ]);

        $code = sha1(rand(1000,9999));

        UserVerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'email'=>$user->email,
        ]);

        $url = route('user-verification',[$user->email,$code]);

            Mail::to(\request('email'))->send(new UserVerificatonEmail($url));
//          dd($code);

          return redirect()->back()->with('success','user Successfully Registered');
    }

    public function userVerification($email,$code){
        $user = User::where('email',$email)->with('code')->first();

//        dd($user);

        if ($user){
            $userCode = $user->code->code;
            if ($userCode == $code && $user->email == $email){
                User::where('email',$email)->update([
                    'user_verify' => 'verified',
                ]);
                UserVerificationCode::where('email',$email)->delete();
            }else{
                return "Unauthorized user";
            }

        }else{
            return "Unauthorized user";
        }
        return to_route('user-dashboard');
    }
}
