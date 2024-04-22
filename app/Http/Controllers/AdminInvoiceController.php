<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\DeliveryTerm;
use App\Models\ExpenseName;
use App\Models\Invoice;
use App\Models\PaymentType;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminInvoiceController extends Controller
{
    public function allInvoice(){

        $pageTitle = 'Admin All Invoice';
        $search = request('search');
        $dateFrom = request('date-form');
        $dateTo = request('date-to');
        $user = request('user');
        $status = request('status');

        Session::put([
            'search' => $search,
            'date_form' => $dateFrom,
            'date_to' => $dateTo,
            'by_user' => $user,
            'by_status' => $status
        ]);

        $invoices = Invoice::with('customers', 'users', 'payments')
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('customers', function ($query) use ($search) {
                        $query->where('email', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    })
                    ->orWhere(function ($query) use ($search) {
                        $query->whereRaw("json_unquote(json_extract(products, '$**.product_name')) like ?", ["%{$search}%"]);
                    });
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when($user, function ($query) use ($user) {
                $query->where('user_id', $user);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();


        if (auth()->check()) {
            $user = auth()->user();
            $notifications = $user->notifications;
        } else {
            $notifications = null;
        }

        $totalInvoiceValue = 0;
        foreach ($invoices as $invoice) {
            $products = json_decode($invoice->products, true);

            foreach ($products as $product) {
                $unitPrice = $product['unit_price'];
                $priceWithVat = 0; // Initialize $priceWithVat

                if (!empty($notSent->vat_tax)) {
                    if ($notSent->vat_tax == 10.5) {
                        $priceWithAit = $unitPrice + floatval($unitPrice) * 3 / 100;
                        $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    } else {
                        $priceWithVat = $unitPrice + floatval($unitPrice) * floatval($notSent->vat_tax) / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    }
                } else {
                    $subTotal = floatval($unitPrice) * $product['quantity'];
                    $priceWithVat = $unitPrice;
                }

                // Accumulate the subTotal to the totalQuotationNotSentValue
                $totalInvoiceValue += $subTotal;
            }
        }

        $totalPayment = $invoices->flatMap(function ($invoice) {
            return $invoice->payments;
        })->sum('amount');

        $totalDue = $totalInvoiceValue-$totalPayment;

        $totalInvoice = $invoices->total();

        $accounts = Accounts::all();

        $unites = Unit::all();
        $paymentTypes = PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();
        $users = User::all();

        $expenseNames = ExpenseName::all();
        $accounts = Accounts::all();


//        dd($invoices);
        return view('adminAllInvoice',
            compact('invoices','totalInvoice','notifications','accounts',
                'totalInvoiceValue',
                'unites',
                'paymentTypes',
                'totalPayment',
                'deliveryTerms',
                'totalDue',
                'users',
                'expenseNames',
                'pageTitle'
            ));


    }
}
