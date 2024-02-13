<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\ExpenseName;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AccountController extends Controller
{
        public function index(){

            $invoices = Invoice::all();

            $expenseNames = ExpenseName::all();

            $accounts = Accounts::with('payments','expanses')
                                    ->get();
            return view('account', compact('accounts','invoices','expenseNames'));

        }

        public function addAccount(){

            $this->validate(\request(),[
                'account_type' => 'required',
                'bank_name' => 'required',
                'account_number' => 'required',
                'note' => 'nullable|max:500',
                'balance' => 'required',
            ]);

            Accounts::create([
                'account_type' => \request('account_type'),
                'bank_name' => \request('bank_name'),
                'account_number' => \request('account_number'),
                'note' => \request('note'),
                'balance' => \request('balance'),
            ]);

            return redirect()->back()->with('success','Account Added Successfully');

        }
}
