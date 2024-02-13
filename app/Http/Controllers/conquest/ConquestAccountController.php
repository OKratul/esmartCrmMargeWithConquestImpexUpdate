<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestAccount;
use Illuminate\Http\Request;

class ConquestAccountController extends Controller
{
    public function accounts(){

        $accounts = ConquestAccount::all();

        return view('conquest.accounts', compact('accounts'));

    }

    public function addAccount(){

        $this->validate(\request(),[

            'account_name' => 'required',
            'account_no' => 'required',
            'balance' => 'required',

        ]);

        ConquestAccount::create([
            'account_name' => \request('account_name'),
            'account_number' => \request('account_no'),
            'balance' => \request('balance'),
        ]);

        return redirect()->back()->with('success','Account Added Successfully');

    }
}
