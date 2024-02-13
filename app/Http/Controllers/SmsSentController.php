<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\CrmAdmin;
use App\Models\CustomerModel;
use App\Models\Invoice;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\String\s;

class SmsSentController extends Controller
{
    public function sentSms($invoice_id){

        $account_id = \request('account_id');

        $account = Accounts::where('id',$account_id)->first();

        $accountInfo = $account['account_type'].' '.$account['bank_name'].' '. $account['account_number'];

        $totalBill = \request('total_bill');
        $paymentAmount = \request('payment_amount');
        $bkashCharge = $paymentAmount * 2 / 100 ;
        $deliveryCheck = \request('delivery_check');
        $deliveryCharge = \request('delivery_charge');

        $invoice = Invoice::where('id',$invoice_id)->first();

        if (!empty($invoice['user_id'])){
            $user = User::where('id',$invoice['user_id'])->first();
            $userName = $user['name'];
        }else{
            $admin = CrmAdmin::where('id',$invoice['admin_id'])->first();
            $userName = $admin['username'];
        }

//        $deliveryCharge = $invoice['delivery_charge'];

        if (!empty($deliveryCharge)){
            $deliveryNote = 'A delivery charge of BDT ' . $deliveryCharge . ' will apply';
        }else{
            $deliveryNote = 'A delivery charge not applicable';
        }

        $customer = CustomerModel::where('id',$invoice['customer_id'])->first();

        $customerName = $customer['name'];
        $customerPhoneNumber = $customer['phone_number'];

        $recipient = '+88'.$customerPhoneNumber;
        $senderId = '+8809601003605';
        $message = 'Dear, '. $customerName."\n".
            ' Following our phone discussion, kindly remit a payment of BDT ' . $paymentAmount .
            ', which includes the total bill amount of BDT ' . $totalBill .
            ' and a bKash charge of BDT '. $bkashCharge .
            ', to our ' . $accountInfo .
            ' (personal). Remember to notify us once the payment is made, either at 09617778877 or via WhatsApp (01316448804).'."\n" .
            ' Note:'.$deliveryNote ."\n" .
            'Thank you,'. "\n".
            $userName . "\n".
            'eSmart.com.bd'
            ;


        $url = 'https://login.esms.com.bd/api/v3/sms/send?' .
            'recipient=' .$recipient.
            '&sender_id=' . $senderId.
            '&type=plain' .
            '&message='.$message;
//        dd($url);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer 221|bTmy9ZBpU4z6dq2UaKpBAzquMY4da4IYYORwkFE9',
        ])->post($url);

        if ($response->successful()) {
            // SMS sent successfully
            $responseData = $response->json();
            // Handle the response data as needed
            // For example, you might want to log it or return a success message
            return response()->json(['message' => 'SMS sent successfully', 'data' => $responseData]);
        } else {
            // SMS failed to send
            $errorData = $response->json();
            // Handle the error data as needed
            // For example, you might want to log it or return an error message
            return response()->json(['error' => 'Failed to send SMS', 'data' => $errorData], $response->status());
        }


    }
}
