<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestCustomer;
use App\Models\conquest\ConquestInvoice;
use App\Models\conquest\ConquestPayment;
use App\Models\conquest\ConquestProduct;
use Illuminate\Http\Request;

class ConquestDashboardController extends Controller
{
    public function index(){

        $products = ConquestProduct::with('stocks')->orderByDesc('created_at')->paginate(10);
        $invoices = ConquestInvoice::with('customers','payments')->orderByDesc('created_at')->get()->all();
        $customers = ConquestCustomer::with('invoices')->get()->sortByDesc(function ($customer) {
            return $customer->invoices->sum('all_total_price');
        });

        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $customers = new \Illuminate\Pagination\LengthAwarePaginator(
            $customers->slice($offset, $perPage),
            $customers->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        $totalInvoiceValue = 0;
        foreach ($invoices as $invoice){

            $totalInvoiceValue  += $invoice->all_total_price;

        }

        $payments = ConquestPayment::all();

        $totalPayment = 0;

        foreach ($payments as $payment){

            $totalPayment += $payment->pay_amount;

        }


//        dd($totalPayment);

        return view('conquest.dashboard',
            compact('products','invoices','customers','totalInvoiceValue','totalPayment'));
    }
}
