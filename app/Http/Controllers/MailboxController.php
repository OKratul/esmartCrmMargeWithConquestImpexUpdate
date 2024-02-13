<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\MailAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\IMAP;
use function Symfony\Component\String\s;


class MailboxController extends Controller
{
    public function emails(){
        $user_id = Auth::user()->id;
        $accounts = MailAccount::where('user_id',$user_id)->get()->all();

        $user = Auth::user();
        $notifications = $user->notifications;

        return view('user.userMailList',compact('user_id','accounts','notifications'));
    }


    public function fetchMailFolders($mail_id)
    {
        $config = MailAccount::where('id', $mail_id)->first();


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


            foreach ($folders as $folder) {
                $messages = $folder->messages()->all()->get()->paginate(10);

            }
            $totalMessage = count($messages);


            return view('user.usersMailFolders', compact('messages','folders', 'mail_id','totalMessage'));

        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->view('errorConnection', compact('error'));
        }


    }


    public function viewSingleMail($mail_id,$mid)
    {
        $mailFolders = $this->fetchMailFolders($mail_id);
        $folders = $mailFolders->folders;

        $totalMessage = $this->fetchMailFolders($mail_id)->totalMessage;

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

        return view('user.userSingleMail',compact('mail_id','folders','from','subject','body','attachments','totalMessage'));
//
//        dd($fileName);
    }

    public function mailRepaly($mail_id,$uid){

        $singleMail = $this->viewSingleMail($mail_id,$uid);
        $totalMessage = $singleMail->totalMessage;
        $to = $singleMail->from;


//        Mail::to($to)->send();

        return view('user.userComposeMail',compact('mail_id','uid','totalMessage','to'));

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
