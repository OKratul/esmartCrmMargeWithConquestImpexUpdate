<?php

namespace App\Http\Controllers;

use App\Mail\SentOfferAndPromotionMail;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PromotionMialController extends Controller
{

    public function promotionMail()
    {
        set_time_limit(500);
        
        // Retrieve customers with email addresses where the first letter is 'B'
        $customers = CustomerModel::whereRaw('LEFT(email, 1) = ?', ['J'])->get(['email']);

        // Extract the email addresses from the collection
        $recipientEmails = $customers->pluck('email')->toArray();

        if (!empty($recipientEmails)) {
            // Send the email to each recipient
            foreach ($recipientEmails as $email) {
                if (!empty($email)) {
                    Mail::to($email)->send(new SentOfferAndPromotionMail());
                }
            }

            // Assuming the emails are sent successfully, you can redirect back
            return redirect()->back()->with('success', 'Mail Sent Successfully');
            
        }

        // Redirect back if there are no recipients
        return redirect()->back()->with('info', 'No customers with email addresses starting with "B" to send emails to.');
    }



    public function deleteCustomers(){
        $customers = CustomerModel::all();

        foreach ($customers as $customer){
            CustomerModel::where('id',$customer->id)->delete();
            CustomerModel::truncate();
        }

    }

}
