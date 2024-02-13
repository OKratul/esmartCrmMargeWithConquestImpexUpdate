<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Mail\QuotationMail;
use App\Models\Accounts;
use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\ExpenseName;
use App\Models\Invoice;
use App\Models\PaymentType;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    public function allInvoice(){

        $pageTitle = 'All Invoice';
        $search = \request('search');
        $dateFrom = \request('date_from');
        $dateTo = \request('date_to');
        $user = \request('user');
        $status = \request('status');


        $invoices = Invoice::with('customers', 'users', 'payments')
                    ->when($search, function ($query) use ($search) {
                        $query->where('invoice_no', 'like', "%{$search}%")
                            ->orWhereHas('customers', function ($query) use ($search) {
                                $query->where('email', 'like', "%{$search}%")
                                    ->orWhere('phone_number', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%");
                            })->orWhere(function ($query) use ($search) {
                                $query->whereRaw("json_unquote(json_extract(products, '$**.product_name')) like ?", ["%{$search}%"]);
                            });
                    })
                    ->when($dateFrom, function ($query) use ($dateFrom, $dateTo) {
                        $query->whereBetween('delivery_date', [$dateFrom, $dateTo]);
                    })
                    ->when($user, function ($query) use ($user) {
                        $query->where('user_id', $user);
                    })
                    ->when($status, function ($query) use ($status) {
                        $query->where('status', $status);
                    })
                    ->orderByDesc('created_at')
                    ;


        $totalPaymentValue =0;
        $totalInvoiceValue = 0;

        foreach ($invoices as $invoice) {
            $products = json_decode($invoice->products, true);
            $totalInvoiceValue = 0;

            foreach ($products as $product) {
                $unitPrice = $product['unit_price'];
                $priceWithVat = 0; // Initialize $priceWithVat

                if (!empty($invoice->vat_tax)) {
                    if ($invoice->vat_tax == 10.5) {
                        $priceWithAit = $unitPrice + floatval($unitPrice) * 3 / 100;
                        $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    } else {
                        $priceWithVat = $unitPrice + floatval($unitPrice) * floatval($invoice->vat_tax) / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    }
                } else {
                    $subTotal = $unitPrice * $product['quantity'];
                    $priceWithVat = $unitPrice;
                }

                // Accumulate the subTotal to the totalInvoiceValue
                $totalInvoiceValue += $subTotal;
            }

            if ($invoice->paymments){
                $payments = $invoice->payments;

                $totalPaymentValue += $payments->sum('amount');
            }


        }




        $paginationLimit = 10; // Adjust the pagination limit as needed
        $invoices = $invoices->paginate($paginationLimit)->withQueryString();


        $user = Auth::user();
        $notifications = $user->notifications;

        $totalInvoice = $invoices->total();
        $accounts = Accounts::all();

        $totalInvoice = $invoices->total();

        $accounts = Accounts::all();

        $unites = Unit::all();
        $paymentTypes = PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();
        $users = User::all();

        $expenseNames = ExpenseName::all();
        $accounts = Accounts::all();
        $querySources = QuerySource::all();
        $statuses = QueryStatus::all();
        $customers = CustomerModel::all();
        $warranties = Warranty::all();


//        dd($invoices);
        return view('user.userAllInvoice',
            compact('invoices','totalInvoice','notifications','accounts',
                'totalInvoice',
                'unites',
                'paymentTypes',
                'deliveryTerms',
                'users',
                'expenseNames',
                'totalInvoice',
                'totalInvoiceValue',
                'querySources',
                'statuses',
                'customers',
                'warranties',
                'totalPaymentValue',
                'accounts',
                'pageTitle'
            ));
    }


    public function viewInvoiceGenerator(){

        $users = User::all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        return view('user.userGenerateNewInvoice', compact('users',
            'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
    }


//    ====== generate new invoice ======
    public function newInvoice(){

        $this->validate(\request(),[
            'type' => 'required',
            'submitted_by' => 'required',
            'logo' => 'required',
            'name' => 'required',
            'email' => 'nullable|email|unique:customer_models,email',
            'phone' => 'required',
            'contact_name' => 'required',
            'delivery_address' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'postal_code' => 'nullable',
            'product_name'=> 'required',
            'product_code'=> 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'unit'=>'required',
            'product_description' => 'nullable',
            'costing' => 'nullable',
            'product_discount' => 'nullable',
            'product_source' => 'nullable',
            'warranty' => 'required',
            'payment_type' => 'required',
            'vat_tax' => 'nullable',
            'delivery_term' => 'nullable',
            'other_condition' => 'nullable',
            'delivery_date' => 'nullable',
            'delivery_charge' => 'nullable',
            'discount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
        ]);

        $customer = CustomerModel::where('phone_number', request('phone_number'))
            ->where('email', request('email'))
            ->first();
        if (!empty($customer)){
            $customer_id = $customer->id;

        }else{
            CustomerModel::create([
                'customer_type' => \request('type'),
                'name' => \request('name'),
                'contact_name' => \request('contact_name'),
                'email' => \request('email'),
                'phone_number' => \request('phone'),
                'address' => \request('address'),
                'city' => \request('city'),
                'country' => \request('country'),
                'postal_code' => \request('postal_code'),
            ]);

            $customer = CustomerModel::get()->last();

            $customer_id = $customer->id;
        }


        $data = \request()->all();
        $products = [];

        foreach ($data['product_name'] as $index => $productName) {
            $product = [
                'product_name' => $productName,
                'product_code' => $data['product_code'][$index],
                'quantity' => $data['quantity'][$index],
                'unit_price' => $data['unit_price'][$index],
                'description' => $data['product_description'][$index],
                'unit' => $data['unit'][$index],
                'our_coasting' => $data['costing'][$index],
                'product_source' => $data['product_source'][$index],
                'product_discount' => $data['product_discount'][$index],
                // Add more fields as needed
            ];

            $products[] = $product;
        }

        $created_by = User::where('id', \request('submitted_by'))->first();

        Invoice::create([
            'user_id' => \request('submitted_by'),
            'customer_id' => $customer_id,
            'logo' => \request('logo'),
            'invoice_no' => rand(111111,999999),
            'products' => json_encode($products),
            'delivery_charge' => \request('delivery_charge'),
            'delivery_address' => \request('delivery_address'),
            'discount_amount' => \request('discount_amount'),
            'extra_charge_name' => \request('extra_charge_name'),
            'extra_amount' => \request('extra_amount'),
            'offer_validity' => \request('offer_validity'),
            'vat_tax' => \request('vat_tax'),
            'delivery_term' => \request('delivery_term'),
            'warranty' => \request('warranty'),
            'delivery_date' => \request('delivery_date'),
            'payment_type' => \request('payment_type'),
            'other_condition' => \request('other_condition'),
            'created_by' => $created_by['name'],
            'phone_number' => \request('phone')
        ]);

        $invoice= Invoice::where('customer_id',$customer_id)->get()->last();

        $invoice_id = $invoice['id'];

        if (\request()->routeIs('admin-new-generator')){
            return to_route('admin-make-payment',[$customer_id,$invoice_id]);
        }else{
            return redirect()->back()->with('success','Invoice Created Successfully');
//            return to_route('make-payment',[$customer_id,$invoice_id]);
        }

    }



    public function invoiceMail($invoice_id){

        $invoice = Invoice::where('id',$invoice_id)->with('users','customers','payments')->first();

       $customerEmail = $invoice['customers']['email'];
//        dd($customerEmail);
        Mail::to($customerEmail)->send(new InvoiceMail($invoice));

        return redirect()->back()->with('success','Mail Sent to invoice email');
    }

    public function challan($invoice_id){
        $invoice = Invoice::where('id',$invoice_id)->with('users','customers','payments')->first();

        $pdf = new Mpdf([
            'format' => 'A4',
        ]);
        $challanNumb = rand(111111,999999);
        $challanName = 'Challan'.rand(111111,999999).'.pdf';

        $pdf->WriteHTML(view('pdf.challanPdf', compact('invoice','challanNumb'))->render());

        // Output the PDF as a string
        $pdfContent = $pdf->Output($challanName, 'S');

        // Return the response with PDF content and headers
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function moneyReceipt($invoice_id){
        $invoices = Invoice::where('id',$invoice_id)->with('users','customers','payments')->first();

        $payments = $invoices['payments'];
        $invoiceNo = $invoices['invoice_no'];

//        dd($payments);

        $pdf = new Mpdf([
            'format' => 'A4',
        ]);
        $challanNumb = rand(111111,999999);
        $challanName = 'Challan'.rand(111111,999999).'.pdf';

        $pdf->WriteHTML(view('pdf.moneyReciept', compact('payments','invoices'))->render());

        // Output the PDF as a string
        $pdfContent = $pdf->Output($challanName, 'S');

        // Return the response with PDF content and headers
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>'inline; filename= "invoiceNo.pdf"',
        ]);
    }


}
