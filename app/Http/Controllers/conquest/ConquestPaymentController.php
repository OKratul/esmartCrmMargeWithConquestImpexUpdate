<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestAccount;
use App\Models\conquest\ConquestCustomer;
use App\Models\conquest\ConquestInvoice;
use App\Models\conquest\ConquestPayment;
use App\Models\conquest\ConquestTransection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConquestPaymentController extends Controller
{
    public function allPayments(){
        $payments = ConquestPayment::with('customers')->orderByDesc('created_at')->paginate(10);
        $customers = ConquestCustomer::all();

        return view('conquest.payments',compact('payments','customers'));
    }

    public function updatePaymentFromOld(){

        $oldPayments = DB::table('wpdf_ism_payment')->get();

        foreach ($oldPayments as $payment) {
            ConquestPayment::where('customer_id', $payment->Customer_ID)
                ->update([
                    'date' => $payment->Date,
                ]);
        }

        return redirect()->back()->with('success', 'Data updated');

    }

    public function updateInvoiceId(){

        $payments = ConquestPayment::all();

        foreach ($payments as $payment){

            $invoice = ConquestInvoice::where('invoice_number',$payment->invoice_no)->first();
            $invoiceId = $invoice['id'];
            ConquestPayment::where('invoice_no',$payment->invoice_no)->update([
                'invoice_id' => $invoiceId,
            ]);

        }

        return redirect()->back()->with('success','Invoice Id Updated');

    }

    public function addPayment(){

        $this->validate(\request(), [
            'date' => 'required',
            'invoice_no' => 'required',
            'paid_amount' => 'required',
            'payment_type' => 'required',
            'customer_id' => 'required',
            'account_no' => 'required',
        ]);

        $invoice = ConquestInvoice::where('invoice_number', \request('invoice_no'))->first();

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        $invoiceId = $invoice->id;

        if (!empty($invoice->paid)) {
            $paid = $invoice->paid + \request('paid_amount');
            $due = $invoice->all_total_price - $paid;
        } else {
            $paid = \request('paid_amount');
            $due = $invoice->all_total_price - $paid;
        }

        $invoice->update([
            'paid' => $paid,
            'due' => $due,
        ]);

        ConquestPayment::create([
            'customer_id' => \request('customer_id'),
            'invoice_id' => $invoiceId,
            'pay_amount' => \request('paid_amount'),
            'pay_type' => \request('payment_type'),
            'invoice_no' => \request('invoice_no'),
            'date' => \request('date'),
        ]);

        $accountId = \request('account_no');
        $payAmount = \request('paid_amount');

        $account = ConquestAccount::where('id',$accountId)->first();

        if ($account['balance']){
            $balance = $account['balance'] + $payAmount;
        }else{
            $balance = \request('paid_amount');
        }

        $account->update([
            'balance' => $balance,
        ]);

        ConquestTransection::create([
            'account_id' => \request('account_no'),
            'invoice_id' => $invoiceId,
            'status' => 'Cash In',
            'amount' => \request('paid_amount'),
        ]);

        return redirect()->back()->with('success', 'Payment Added Successfully');


    }



    public function addPaymentFromInvoice(){

        $this->validate(\request(),[

            'invoice_no' => 'required',
            'pay_amount' => 'required',
            'payment_type' => 'required',
            'date' => 'required',

        ]);

        $invoiceNo = \request('invoice_no');
        $payAmount = \request('pay_amount');

        $invoice = ConquestInvoice::where('invoice_number',$invoiceNo )->first();

        if ($invoice['paid']){

            $totalPaid = $invoice['paid'] + $payAmount;
            $totalDue = $invoice['all_total_price'] - $totalPaid;

        }else{
            $totalPaid = $payAmount;
            $totalDue = $invoice['all_total_price'] - $totalPaid;

        }

        ConquestPayment::create([
            'customer_id' => $invoice['customer_id'],
            'invoice_id' => $invoice['id'],
            'pay_amount' => \request('pay_amount'),
            'pay_type' => \request('payment_type'),
            'invoice_no' => $invoice['invoice_number'],
            'date' => \request('date')
        ]);

        $invoice->update([
            'paid' => $totalPaid,
            'due' => $totalDue,
        ]);

        $account = ConquestAccount::where('id',\request('account_id'))->first();

        $balance = $account['balance'] + \request('pay_amount');

        $account->update([
            'balance' => $balance,
        ]);

        ConquestTransection::create([
            'invoice_id' => $invoice['id'],
            'account_id' => \request('account_id'),
            'status' => 'Cash In',
            'amount' => \request('pay_amount'),

        ]);

        return redirect()->back()->with('success','Payment Added Successfully');

    }
}
