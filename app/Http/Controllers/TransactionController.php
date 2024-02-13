<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Expanse;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function cashIn($account_id){

        $this->validate(\request(),[
            'pay_with' => 'required',
            'bank_name' => 'required',
            'ref_no' => 'required',
            'amount' => 'required',
            'invoice_id' => 'nullable',
            'note' => 'required',
        ]);

        $admin_id = Auth::guard('admin')->id();

        $account = Accounts::where('id', $account_id)->first();

        if (!empty(\request('invoice_id'))){
            $invoice = Invoice::where('id',\request('invoice_id'))->with('customers')->first();

            $payment = Payment::create([
                'payment_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'Ref_no' => \request('ref_no'),
                'amount' => \request('amount'),
                'user_id' => null,
                'admin_id' => $admin_id,
                'invoice_id' => \request('invoice_id'),
                'customer_id' => $invoice->customers['id'],
                'account_id' => $account_id,
                'payment_date' => Carbon::now()->format('Y-m-d')
            ]);

        }else{
            $payment = Payment::create([
                'payment_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'Ref_no' => \request('ref_no'),
                'amount' => \request('amount'),
                'user_id' => null,
                'admin_id' => $admin_id,
                'invoice_id' => null,
                'customer_id' => null,
                'account_id' => $account_id,
                'payment_date' => Carbon::now()->format('Y-m-d')

            ]);

        }

        $updateBalance = $account['balance'] + $payment['amount'];

        $account->update([
            'balance' => $updateBalance,
        ]);

        Transaction::create([
            'account_id' => $account_id,
            'payment_id' => $payment['id'],
            'expanse_id' => null,
            'table_note' => \request('note'),
            'amount' => \request('amount'),
            'status' => 'Debit',
            'balance' => $updateBalance,
        ]);

        return redirect()->back()->with('success','Cash In Successfully');

    }


    public function showTransaction($account_id){

        $account = Accounts::where('id',$account_id)->first();

        $transactions = Transaction::where('account_id', $account_id)->with('payments','expanses')
            ->orderByDesc('created_at')
            ->get();

        return view('viewTransactions',compact('transactions','account'));

    }


    public function cashOut($account_id) {
        $this->validate(\request(), [
            'expense_id' => 'required',
            'amount' => 'required',
            'account_type' => 'required',
            'bank_name' => 'required',
            'sent_to' => 'required',
            'note' => 'nullable',
            'date' => 'required'
        ]);

        $account = Accounts::where('id', $account_id)->first(); // Changed \request('account_id') to $account_id

        $admin_id = Auth::guard('admin')->id();

        $expanse = Expanse::create([
            'user_id' => null,
            'admin_id' => $admin_id,
            'account_id' => $account_id,
            'expense_name_id' => \request('expense_id'),
            'expanse_amount' => \request('amount'),
            'receive_with' => \request('account_type'),
            'receiver_account' => \request('sent_to'),
            'bank_name' => \request('bank_name'),
            'note' => \request('note'),
            'date' => \request('date'),
        ]);

        $updateBalance = $account->balance - \request('amount'); // Changed $expanse->amount to \request('amount')

        $account->update([
            'balance' => $updateBalance,
        ]);

        Transaction::create([
            'account_id' => $account_id,
            'payment_id' => null,
            'expanse_id' => $expanse->id,
            'table_note' => \request('note'),
            'status' => 'Credit',
            'amount' => \request('amount'),
            'balance' => $updateBalance,
        ]);

        return redirect()->back()->with('success', 'Expenses Added');
    }



}
