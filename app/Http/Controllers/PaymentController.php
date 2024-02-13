<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class PaymentController extends Controller
{
    public function allPayment(){

        $from = \request('date_from');
        $to = \request('date_to');

        if ($from){
            $payments = Payment::whereBetween('created_at',[$from, $to])->paginate(1000);
            $paymentAmount = Payment::whereBetween('created_at',[$from, $to])->pluck('amount');
        }else{

            $currentMonth = now()->startOfMonth();
            $payments = Payment::with('invoices','users','customers')
                ->orderByDesc('created_at')
                ->paginate(10);

            $paymentAmount = Payment::whereBetween('created_at',[$currentMonth,now()])->pluck('amount');
        }


        $invoices = Invoice::all();


        $totalPayment = $paymentAmount->sum();
//        dd($totalPayment);

        return view('user.userAllPayments', compact('payments','totalPayment','invoices'));

    }

    public function showPayment($invoice_id){

        $invoice = Invoice::where('id',$invoice_id)->with('customers','users')->first();

        $accounts = Accounts::all();

        $customer_id = $invoice['customer_id'];

        if (\request()->routeIs('admin-show-add-payment-from-all-invoice')){
            return view('adminPaymentFromAllInvoice',compact('invoice_id','customer_id','accounts','invoice'));
        }else{
            return view('user.addPaymentFromAllInvoice',compact('invoice_id','customer_id','accounts','invoice'));
        }
    }

    public function addPayment($customer_id, $invoice_id) {

        $this->validate(\request(), [
            'pay_with' => 'required',
            'bank_name' => 'required',
            'ref_no' => 'required',
            'cash_in' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
            'payment_note' => 'nullable',
        ]);

        if (\request()->routeIs('admin-add-payment-from-all-invoice')) {

            $admin_id = Auth::guard('admin')->id();

           $payment = Payment::create([
                'user_id' => null,
                'admin_id' => $admin_id,
                'account_id' => \request('cash_in'),
                'customer_id' => $customer_id,
                'invoice_id' => $invoice_id,
                'payment_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'Ref_no' => \request('ref_no'),
                'amount' => \request('amount'),
                'payment_date' => \request('payment_date'),
                'payment_note' => \request('payment_note'),
            ]);

            $account = Accounts::where('id',\request('cash_in'))->first();

            $updateBalance = $account->balance + \request('amount');

            $account->update([
                'balance' => $updateBalance,
            ]);

            Transaction::create([
                'account_id' => \request('cash_in'),
                'payment_id' => $payment->id,
                'expanse_id' => null,
                'table_note' => \request('payment_note'),
                'status' => 'Debit',
                'amount' => \request('amount'),
                'balance' => $updateBalance,
            ]);


            $invoice = Invoice::where('id',$invoice_id)->with('payments')->get();
            $products = json_decode($invoice['products'], true);

            $totalInvoiceValue = 0 ;
            foreach ($products as $key => $product) {

                if($invoice->vat_tax == 10.5){
                    $priceWithAit = floatval($product['unit_price']) + floatval($product['unit_price']) * 3 / 100;
                    $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100 ;
                    $totalInvoiceValue += floatval($priceWithVat )* floatval( $product['quantity']);
                }else{
                    $priceWithVat = floatval($product['unit_price']) + floatval($product['unit_price']) * floatval($invoice->vat_tax / 100);
                    $totalInvoiceValue += floatval($priceWithVat )* floatval( $product['quantity']);
                }
            }

            $totalPayment = 0 ;
            foreach ($invoice->payments as $payment){

                $totalPayment += $payment->amount;

            }

            if ($totalInvoiceValue <= $totalPayment){

                $invoice->update([
                    'status' => 'Paid',
                ]);

            }else{
                $invoice->update([
                    'status' => 'Due',
                ]);
            }

            return redirect()->back()->with('success', 'Payment Added Successfully');

        } else {
            if (Auth::check()) {
                $user_id = Auth::user()->id;

                $payment = Payment::create([
                    'user_id' => $user_id,
                    'admin_id' => null,
                    'account_id' => \request('cash_in'),
                    'customer_id' => $customer_id,
                    'invoice_id' => $invoice_id,
                    'payment_with' => \request('pay_with'),
                    'bank_name' => \request('bank_name'),
                    'Ref_no' => \request('ref_no'),
                    'amount' => \request('amount'),
                    'payment_date' => \request('payment_date'),
                    'payment_note' => \request('payment_note'),
                ]);

                $account = Accounts::where('id',\request('cash_in'))->first();

                $updateBalance = $account->balance + \request('amount');

                $account->update([
                    'balance' => $updateBalance,
                ]);

                Transaction::create([
                    'account_id' => \request('cash_in'),
                    'payment_id' => $payment->id,
                    'expanse_id' => null,
                    'table_note' => \request('payment_note'),
                    'status' => 'Debit',
                    'amount' => \request('amount'),
                    'balance' => $updateBalance,
                ]);


                $invoice = Invoice::where('id',$invoice_id)->with('payments')->first();
                $products = json_decode($invoice->products, true);

                $totalInvoiceValue = 0 ;
                foreach ($products as $key => $product) {

                    if($invoice->vat_tax == 10.5){
                        $priceWithAit = floatval($product['unit_price']) + floatval($product['unit_price']) * 3 / 100;
                        $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100 ;
                        $totalInvoiceValue += floatval($priceWithVat )* floatval( $product['quantity']);
                    }else{
                        $priceWithVat = floatval($product['unit_price']) + floatval($product['unit_price']) * floatval($invoice->vat_tax / 100);
                        $totalInvoiceValue += floatval($priceWithVat )* floatval( $product['quantity']);
                        }
                    }

                $totalPayment = 0 ;
                foreach ($invoice->payments as $payment){

                    $totalPayment += $payment->amount;

                }

                if ($totalInvoiceValue <= $totalPayment){

                    $invoice->update([
                       'status' => 'Paid',
                    ]);

                }else{
                    $invoice->update([
                        'status' => 'Due',
                    ]);
                }

//                dd($invoice);
                return redirect()->route('user-all-invoice')->with('success', 'Payment Added Successfully');
            }
        }
    }

    public function moneyRec($id){

        $payment = Payment::where('id',$id)->with('customers','invoices')->first();


        $pdf = new Mpdf([
            'format' => 'A4',
        ]);
        $challanNumb = rand(111111,999999);
        $challanName = 'Challan'.rand(111111,999999).'.pdf';

//        dd($payments);

        $pdf->WriteHTML(view('pdf.moneyReciept', compact('payment'))->render());

        // Output the PDF as a string
        $pdfContent = $pdf->Output($challanName, 'S');

        // Return the response with PDF content and headers
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }


}
