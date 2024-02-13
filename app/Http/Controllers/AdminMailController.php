<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\AdminMail;
use App\Models\MailAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Webklex\IMAP\Facades\Client;
use Illuminate\Http\Request;

class AdminMailController extends Controller
{

    public function index(){

        $admin_id = Auth::guard('admin')->id();

        $adminMails = AdminMail::where('admin_id',$admin_id)->get()->all();

        return view('adminMailAccounts',compact('adminMails'));

    }

    public function addAccount(){

        $admin_id = Auth::guard('admin')->id();

        $this->validate(\request(),[
            'host' => 'required',
            'port' => 'required',
            'smtp_port' => 'required',
            'encryption' => 'required',
            'username' => 'required',
            'password' => 'required',
            'protocol' => 'required',
        ]);

        AdminMail::create([
                'admin_id' => $admin_id,
                'host' => \request('host'),
                'port' => \request('port'),
                'encryption' => \request('encryption'),
                'username' => \request('username'),
                'password' => \request('password'),
                'protocol' => \request('protocol'),
        ]);

        return redirect()->back()->with('success','Mail Account Added');

    }

    public function showEditMailAcc($mail_id){

        $mail = AdminMail::where('id',$mail_id)->first();

        return view('adminShowEditMail',compact('mail'));

    }

    public function updateMailAcc($mail_id){

        $admin_id =Auth::guard('admin')->id();

        $this->validate(\request(),[
            'host' => 'required',
            'port' => 'required',
            'smtp_port' => 'required',
            'encryption' => 'required',
            'username' => 'required',
            'password' => 'required',
            'protocol' => 'required',
        ]);

        AdminMail::where('id',$mail_id)->update([

            'admin_id' => $admin_id,
            'host' => \request('host'),
            'port' => \request('port'),
            'encryption' => \request('encryption'),
            'username' => \request('username'),
            'password' => \request('password'),
            'protocol' => \request('protocol'),

        ]);

        return redirect()->back()->with('success','mail account updated');

    }

    public function deleteMailAcc($mail_id){

        AdminMail::where('id',$mail_id)->delete();

        return redirect()->back()->with('success', 'Account Deleted from CRM');
    }

    public function mailFolders($mail_id){

        $config = AdminMail::where('id',$mail_id)->first();


        try {
            $connect = Client::make([
                'host' => $config['host'],
                'port' => 993,
                'protocol' => 'imap',
                'encryption' => 'ssl',
                'validate_cert' => true,
                'username' => $config['username'],
                'password' => $config['password'],
                'authentication' => null,
            ]);

            $folders = $connect->getFolders();

            $messages = [];

            foreach ($folders as $folder) {
                $folderMessages = $folder->messages()->all()->get();
                $messages = array_merge($messages, $folderMessages->toArray());
            }

            $totalMessage = count($messages);

            return view('adminMailFolders', compact('messages', 'folders', 'totalMessage','mail_id'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->view('errorConnection', compact('error'));
        }


    }

    public function viewSingleMail($mail_id,$mid){

        $mailFolders = $this->mailFolders($mail_id);
        $folders = $mailFolders->folders;

        $totalMessage = $this->mailFolders($mail_id)->totalMessage;

        $messages =[] ;

        foreach ($folders as $folder) {
            $messages[] = $folder->query()->getMessage($mid);

        }

        $subject =[];
        $body = [];
        $attachments=[];

        foreach ($messages as $message ){
            $subject[] = $message->getSubject();
            $from = $message->getFrom()[0]->mail;
            $body[] = $message->getHtmlBody();
            $attachments[] = $message->getAttachments();
        }
//        $fileName = [ ];
//        foreach ($attachments as $attachment){
//            $fileName[] = $attachment;
//        }

        return view('adminSingleMail',compact('mail_id','folders','from','subject','body','attachments','totalMessage'));
//
//        dd($fileName);

    }

    public function mailRepaly($mail_id,$uid){

        $singleMail = $this->viewSingleMail($mail_id,$uid);
        $totalMessage = $singleMail->totalMessage;
        $to = $singleMail->from;


//        Mail::to($to)->send();

        return view('adminComposeMail',compact('mail_id','uid','totalMessage','to'));

    }

    public function sendReplay($mail_id,$uid){

        $config = MailAccount::where('id',$mail_id)->get()->first();

//        Config::set('mail.driver', 'smtp');
//        Config::set('mail.host', $config['host']);
//        Config::set('mail.port', $config['smtp_port']);
//        Config::set('mail.username', $config['username']);
//        Config::set('mail.password', $config['password']);
//        Config::set('mail.encryption', 'ssl');

        $message_body = \request('message_body');
        $to = \request('mail_to');

//        dd($message_body);
//
        Mail::to($to)->send(new SendMail($message_body));

        return redirect()->back()->with('success','Mail Sent');

    }

}
