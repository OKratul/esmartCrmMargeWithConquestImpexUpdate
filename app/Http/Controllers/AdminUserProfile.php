<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MailAccount;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserProfile extends Controller
{
    public function userDetails($id){

        $pageTitle = 'User Profile';
        
        $users = User::where('id',$id)->with('quotations','queries','invoices','payments')->get()->all();

        $invoices= Invoice::where('user_id',$id)->get();

        $totalInvo = count($invoices);

//        dd($users);
//
        return view('adminUserProfile', compact('users','invoices','totalInvo','pageTitle'));

    }

    public function viewAddMail($id){

        $mails = MailAccount::where('user_id',$id)->get()->all();

        return view('addMailToUser',compact('id','mails'));
    }

    public function addMailToUser($id){

        $this->validate(\request(),[
            'host' => 'required',
            'port' => 'required',
            'smtp_port'=> 'required',
            'encryption' => 'required',
            'username' => 'required',
            'password' => 'required',
            'protocol' => 'required',
        ]);

        MailAccount::create([
            'user_id' => $id,
            'host' => \request('host'),
            'port' => \request('port'),
            'smtp_port' => \request('smtp_port'),
            'encryption' => \request('encryption'),
            'username' => \request('username'),
            'password' => \request('password'),
            'protocol' => \request('protocol'),
        ]);

        return redirect()->back()->with('success','Account Added Successfully');
    }

    public function viewEditEmail($user_id,$email_id){

        $config = MailAccount::where('id',$email_id)->first();

        return view('adminEditMailAccount',compact('email_id','config','user_id'));

    }

    public function updateEmailAccount($user_id,$email_id){

        $this->validate(\request(),[
            'host' => 'required',
            'port' => 'required',
            'smtp_port' => 'required',
            'encryption' => 'required',
            'username' => 'required',
            'password' => 'required',
            'protocol' => 'required',
        ]);

        MailAccount::where('id',$email_id)->update([
            'user_id' => $user_id,
            'host' => \request('host'),
            'port' => \request('port'),
            'smtp_port' => \request('smtp_port'),
            'encryption' => \request('encryption'),
            'username' => \request('username'),
            'password' => \request('password'),
            'protocol' => \request('protocol'),
        ]);

        return to_route('add-mail-user',[$user_id])->with('success', "Configuration Updated");

    }
}
