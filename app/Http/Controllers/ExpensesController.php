<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Expanse;
use App\Models\ExpenseName;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    public function viewAddExpanses() {
//
        $date = \request('date');
        $search = \request('search');

        $query = Expanse::with('invoices','expenseNames')
            ->orderByDesc('date', 'desc');

        if ($search) {
            $expanses = Expanse::where('expanse_name', 'like', "%{$search}%")
                    ->orderByDesc('date')->paginate(1000);
            ;
        }elseif($date){
            $expanses = Expanse::where('date', 'like', "%{$date}%")->orderByDesc('date')->paginate(1000);

        }else{
            $expanses = $query->orderByDesc('date')->paginate(10);
        }


        $accounts = Accounts::all();

        $form = \request('date_from');
        $to = \request('date_to');

        if ($form && $to){
            $expenseNames = ExpenseName::with(['expanses' => function ($query) use ($form, $to) {
                $query->whereBetween('created_at', [$form, $to]);
            }])->get();
        } else {
            $currentMonth = now()->startOfMonth();

            $expenseNames = ExpenseName::with(['expanses' => function ($query) use ($currentMonth) {
                $query->whereBetween('created_at', [$currentMonth, now()]);
            }])->get();
        }

//        dd($expenseNames );
//
        if (\request()->routeIs('admin-view-add-expanses')){

            return view('user.userAddExpansesForm',compact('expanses','accounts','expenseNames'));

        }else{
            $user = Auth::user();
            $notifications = $user->notifications;


            return view('user.userAddExpansesForm',
                compact('expanses','notifications','accounts','expenseNames'));
        }


    }

    public function addExpanses(){

        $this->validate(\request(), [
            'expense_name' => 'required',
            'amount' => 'required',
            'pay_with' => 'required',
            'bank_name' => 'required',
            'sent_to' => 'required',
            'account_id' => 'required',
            'note' => 'nullable',
            'date' => 'required'
        ]);


        $account =  Accounts::where('id', \request('account_id'))->first();

        if (\request()->routeIs('admin-add-expanses')){

            $admin_id = Auth::guard('admin')->id();

          $expanse =  Expanse::create([
                'user_id' => null,
                'admin_id' => $admin_id,
                'account_id' => $account->id,
                'expense_name_id' => \request('expense_name'),
                'expanse_name' => \request('expanse_name'),
                'expanse_amount' => \request('amount'),
                'receive_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'note' =>\request('note'),
                'date' => \request('date'),
            ]);

        }else{

            $user_id = Auth::user()->id;

           $expanse = Expanse::create([
                'user_id' => $user_id,
                'admin_id' => null,
                'account_id' => $account->id,
               'expense_name_id' => \request('expense_name'),
               'receive_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'expanse_name' => \request('expanse_name'),
                'expanse_amount' => \request('amount'),
               'note' =>\request('note'),
               'date' => \request('date'),
            ]);

        }

        $updateBalance = $account['balance'] - \request('amount');

        $account->update([
            'balance' => $updateBalance,
        ]);

        Transaction::create([
            'account_id' => $account->id,
            'payment_id' => null,
            'expanse_id' => $expanse->id,
            'table_note' => \request('note'),
            'status' => 'Credit',
            'amount' => \request('amount'),
            'balance' => $updateBalance,
        ]);


        return redirect()->back()->with('success','Expanses Added');

    }

    public function showEditExpanse($expanse_id){

        $expanses = Expanse::with('invoices')->paginate('10');

         $singleExpanse = Expanse::where('id',$expanse_id)->with('invoices')->first();

         $invoice_id = $singleExpanse['invoice_id'];

        return view('user.userViewEditExpanse', compact('singleExpanse','expanses','invoice_id'));
    }

    public function updateExpanse($expanse_id){

        $this->validate(\request(),[
            'expanse_name' => 'required',
            'amount' => 'required',
            'date' => 'required'
        ]);

        Expanse::where('id',$expanse_id)->update([
            'user_id' => Auth::user()->id,
            'expanse_name' => \request('expanse_name'),
            'expanse_amount' => \request('amount'),
            'date' => \request('date'),
        ]);

        return redirect()->back()->with('success','Expanse Updated');

    }

    public function deleteExpanse($expanse_id){
            Expanse::where('id',$expanse_id)->delete();

            return redirect()->back()->with('success','Expanse Deleted');
    }

    public function viewAddExpanseWithInvoice($invoice_id){

        $expenseNames = ExpenseName::all();

        $expanses = Expanse::with('invoices')->paginate(10);
//        dd($invoice_id);
        $accounts = Accounts::all();
        return view('user.userAddExpansesForm', compact('expanses','invoice_id','accounts','expenseNames'));

    }

    public function addExpanseWithInvoice($invoice_id) {

        $this->validate(\request(), [
            'expense_name' => 'required',
            'amount' => 'required',
            'pay_with' => 'required',
            'bank_name' => 'required',
            'sent_to' => 'required',
            'account_id' => 'required',
            'note' => 'required',
            'date' => 'required'
        ]);


        $account = Accounts::where('id', \request('account_id'))->first();

        if (\request()->routeIs('add-expanse-invoice') || \request()->routeIs('user-add-expanses')) {
            $expanse = Expanse::create([
                'invoice_id' => $invoice_id,
                'user_id' => Auth::user()->id,
                'account_id' => $account->id,
                'expense_name_id' => \request('expense_name'),
                'receive_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'admin_id' => null,
                'expanse_name' => \request('expanse_name'),
                'expanse_amount' => \request('amount'),
                'note' => \request('note'),
                'date' => \request('date'),
            ]);
            $updateBalance = $account->balance - \request('amount');

            $account->update([
                'balance' => $updateBalance
            ]);

            $transaction = Transaction::create([
                'account_id' => $account->id,
                'payment_id' => null,
                'expanse_id' => $expanse->id,
                'table_note' => \request('note'),
                'status' => 'Credit',
                'amount' => \request('amount'),
                'balance' => $updateBalance,
            ]);

            return redirect()->back()->with('success', 'Expenses Added');

        } else {
            $admin_id = Auth::guard('admin')->id();
            $expanse = Expanse::create([
                'invoice_id' => null,
                'user_id' => null,
                'admin_id' => $admin_id,
                'account_id' => \request('account_id'),
                'expense_name_id' => \request('expense_name'),
                'receive_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'expanse_name' => \request('expanse_name'),
                'expanse_amount' => \request('amount'),
                'note' =>\request('note'),
                'date' => \request('date'),
            ]);
        }

        $updateBalance = $account->balance - \request('amount');

        $account->update([
            'balance' => $updateBalance
        ]);

        $transaction = Transaction::create([
            'account_id' => $account->id,
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
