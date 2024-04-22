<?php

namespace App\Http\Controllers;

use App\Mail\QuotationMail;
use App\Mail\UserVerificatonEmail;
use App\Models\Accounts;
use App\Models\CustomerModel;
use App\Models\CustomerNotes;
use App\Models\DeliveryTerm;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\PDFsetup;
use App\Models\Query;
use App\Models\QueryNote;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Quotation;
use App\Models\QuotationHistory;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use App\Notifications\QueryNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Providers\mPDFServiceProvider;
use Mpdf\Mpdf;
use Psy\Util\Str;
use function Symfony\Component\String\s;


class CustomerProfileController extends Controller
{
    public function viewCustomers() {

        $pageTitle = 'Customers';
        $search = \request('search');

        if (auth()->check()) {
            $user = auth()->user();
            $notifications = $user->notifications;
        } else {
            $notifications = null;
        }

        if ($search){
            $customers = CustomerModel::with('queries','quotations','invoices')
                ->where('name','like', "%{$search}%")
                ->orWhere('email', 'like',"%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%")
                ->orderByDesc('created_at')
                ->paginate(10);
        }else{
            $customers = CustomerModel::with('queries','quotations','invoices')
                ->orderByDesc('created_at')
                ->paginate(20);
        }

        $users = User::all();


        $pendingQuery = Query::where('user_id',null)->count();
        $processingQuery = Query::where('status','Processing')->count();
        $quotationSent = Query::where('status','Quotation Sent')->count();
        $orderConfirmed = Query::where('status','Order Confirmed')->count();
        $deliveryOnGoing = Query::where('status','Delivery On Going')->count();
        $delivered = Query::where('status','Delivered')->count();
        $closed = Query::where('status','Closed')->count();

        $querySources = QuerySource::all();
        $unites = Unit::all();
        $warranties = Warranty::all();
        $paymentTypes = PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();
        $statuses = QueryStatus::get('query_status');
        $accounts = Accounts::all();
        $queryStatus = QueryStatus::get('query_status');

        if (\request()->routeIs('all-customers')){
            return view('customers',compact('customers','notifications',
                'querySources',
                'unites',
                'warranties',
                'paymentTypes',
                'deliveryTerms',
                'statuses',
                'pendingQuery',
                'processingQuery',
                'quotationSent',
                'orderConfirmed',
                'deliveryOnGoing',
                'delivered',
                'closed',
                'statuses',
                'users',
                'queryStatus',
                'accounts',
                'pageTitle'));
        }else{
            return view('user.allCustomer',
                compact('customers','notifications',
                        'querySources',
                        'unites',
                        'warranties',
                        'paymentTypes',
                        'deliveryTerms',
                        'statuses',
                        'pendingQuery',
                        'processingQuery',
                        'quotationSent',
                        'orderConfirmed',
                        'deliveryOnGoing',
                        'delivered',
                        'closed',
                        'statuses',
                        'users',
                        'queryStatus',
                        'accounts',
                        'pageTitle'
                ));
        }

    }

    public $customer_id ;

    public function customerProfile ($id){

        $pageTitle = 'Customer Profile';
        $customer = CustomerModel::where('id',$id)->first();
        $this->customer_id = $id;

        $allQueries = Query::where('customer_id',$id)->with('users','notes')
            ->orderByDesc('created_at')
            ->get()->all();
        $quotations = Quotation::where('customer_id',$id)
            ->orderByDesc('created_at')
            ->with('users')->get()->all();
        $invoices = Invoice::where('customer_id',$id)
                    ->with('users','payments','customers')
                    ->orderByDesc('created_at')
                    ->get()->all();

        $users = User::all();

        $statuses = QueryStatus::all();
        $unites = Unit::all();

        $querySources = QuerySource::all();
        $queryStatus = QueryStatus::all();
        $allQuotations = Quotation::where('user_id',$id)->get();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();
        $customers = CustomerModel::all();
        $accounts = Accounts::all();


        if (\request()->routeIs('customer-profile')){

//            dd($quotations);

            return view('customerProfile',compact('customer'
                ,'id',
                'users',
                'querySources','queryStatus',
                'allQueries',
                'allQuotations',
                'quotations',
                'invoices',
                'statuses',
                'unites',
                'querySources',
                'deliveryTerms',
                'paymentTypes',
                'warranties',
                'accounts',
                'pageTitle'
            ));

        }else{
            $querySources = QuerySource::all();
            $queryStatus = QueryStatus::all();

            $user = auth()->user();
            $notifications = $user->notifications;

            return view('user.customerProfile',compact('allQueries','id','notifications',
                'users',
                'querySources','queryStatus',
                'allQueries',
                'allQuotations',
                'quotations',
                'invoices',
                'statuses',
                'unites',
                'querySources',
                'deliveryTerms',
                'paymentTypes',
                'warranties',
                'customers',
                'customer',
                'pageTitle'
            ));
        }

    }

    public function updateCustomer($id){

        $this->validate(\request(),[
            'type' => 'required',
            'name'=> 'required',
            'contact_name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'required',
            'address' =>'required',
            'city' => 'nullable',
            'country'=>'nullable',
            'postal_code'=> 'nullable',
        ]);

        CustomerModel::where('id',$id)->update([
            'customer_type' => \request('type'),
            'name' => \request('name'),
            'contact_name' => \request('contact_name'),
            'email' => \request('email'),
            'phone_number'=> \request('phone'),
            'address' => \request('address'),
            'city' => \request('city'),
            'country' => \request('country'),
            'postal_code' => \request('postal_code'),
        ]);



        return redirect()->back()->with('success','customer profile updated');
    }

    public function viewAllQuery($customer_id){

        $customers = CustomerModel::where('id',$customer_id)->with('queries')->get()->all();

        $allQueries = Query::where('customer_id',$customer_id)
            ->with('customers')
            ->orderByDesc('created_at')
            ->get()->all();
//        dd($customers);


        if (\request()->routeIs('user-view-all-query')){
            $user = Auth::user();
            $notifications = $user->unreadNotifications;
            return view('user.userCustomersAllquery',compact('customer_id','customers','allQueries','notifications'));
        }else{
            return view('viewAllqueryFromProfile',compact('customer_id','customers','allQueries'));
        }

    }

    public function viewQueryForm($customer_id){

//        $api = new EsmartApiController();
//        $woocommerce = $api->api();
//
//        $categories = $woocommerce->get('products/categories');

//        dd($categories);

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        if (\request()->routeIs('user-query-add-form-profile')){
                return view('user.userCustomerProfileLead',compact('customer_id','unites','statuses',
                    'querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('customerProfileLeadQuery',compact('customer_id','unites','statuses',
                'querySources','deliveryTerms','paymentTypes','warranties'));
        }
    }


    public function addNote($customer_id,$query_id){

        $this->validate(\request(),[
            'notes' => 'required|max:1000'
        ]);

        if (\request()->routeIs('admin-add-note')){
            $admin = Auth::guard('admin')->user();

            QueryNote::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'notes' => \request('notes'),
                'user_name'=> $admin->username,
                'query_id' => $query_id,
            ]);
            return redirect()->back()->with('success','note added');
        }else{

            if (Auth::check()){
                $username = Auth::user()->name;

                QueryNote::create([
                    'date' => Carbon::now()->format('Y-m-d'),
                    'notes' => \request('notes'),
                    'user_name'=> $username,
                    'query_id' => $query_id,
                ]);
                return redirect()->back()->with('success','note added');
            }

        }

    }

    public function updateNote($note_id){

        $this->validate(\request(),[
           'notes' => 'required',
        ]);

        QueryNote::where('id',$note_id)->update([
            'notes' => \request('notes')
        ]);

        return redirect()->back()->with('success','Note Updated');

    }

    public function deleteNote($note_id){

        QueryNote::where('id',$note_id)->delete();

        return redirect()->back()->with('success','Note deleted');

    }


    public function addQuery($id){

        $customer = CustomerModel::where('id', $id)->first();
        $phone = $customer->phone_number;

//dd($phone);
        $this->validate(\request(),[
            'query_source'=> 'required',
            'status'=> 'required',
            'query_details'=> 'required',
            'product_name' => 'required',
            'product_sku' => 'nullable',
            'product_quantity'=> 'required',
            'product_category'=> 'required',
            'reminder_date' => 'nullable',
            'submit_date' => 'nullable',
        ]);

        Query::create([
            'customer_id' => $id,
            'user_id' => Auth::id(),
            'phone_number' => $phone,
            'query_source' => \request('query_source'),
            'status' => \request('status'),
            'query_details' => \request('query_details'),
            'product_sku' => \request('product_sku'),
            'product_name' => \request('product_name'),
            'product_quantity' => \request('product_quantity'),
            'product_category' => \request('product_category'),
            'reminder_date' => \request('reminder_date'),
            'submit_date' => \request('submit_date'),
        ]);

        $query = Query::first();

//        $query->notify(new QueryNotification($query));

        return redirect()->back()->with('success','query added successfully');
    }

    public function showEditQuery($customer_id,$query_id){

        $query = Query::where('id', $query_id)->first();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        if (\request()->routeIs('admin-customer-show-edit-query')){

            return view('adminCustomerProfileEditQuery',compact('customer_id','query',
                'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }

        return view('user.userCustomerProfileEditeQuery',compact('customer_id','query',
            'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));

    }


    public function viewQuotationForm($customer_id){

        $users = User::all();
        $customers = CustomerModel::where('id',$customer_id)->with('quotations')->get()->all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        if (\request()->routeIs('user-view-add-quotation')){
            return view('user.userViewAddQuotationForm',compact('customer_id','users',
                'customers','unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('quotationFormCustomerProfile',compact('customer_id','users',
                'customers','unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'
            ));
        }

    }

    public function addQuotation($customer_id){

         $this->validate(\request(),[
             'logo' => 'required',
            'phone_number'=> 'nullable',
            'product_name'=> 'nullable',
            'product_code'=> 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'unit'=>'required',
            'product_description' => 'nullable',
            'costing' => 'nullable',
            'product_discount' => 'nullable',
            'product_source' => 'nullable',
            'product_image' => 'nullable',
            'offer_validity' => 'nullable',
            'warranty' => 'required',
            'payment_type' => 'required',
            'vat_tax' => 'nullable',
            'delivery_term' => 'nullable',
            'delivery_date' => 'nullable',
            'other_condition' => 'nullable',
            'delivery_charge' => 'nullable',
            'delivery_check' => 'nullable',
            'discount_amount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
             'submitted_by' => 'required',
             'status' => 'required',
        ]);

//        dd(\request()->all());
        $data = request()->all();
        $products = [];

        // Iterate over the array fields and store them as an array of products
        foreach ($data['product_name'] as $index => $productName) {

            $productImage = request()->file('product_image');
            if ($productImage) {
                $imgExt = $productImage[$index]->extension();
                $proImg = $productName . rand(1111, 9999) . '.' . $imgExt;

                $productImage[$index]->move('images/quotationProduct', $proImg);
            }else{
                $proImg = Null;
            }

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
                'product_image' => $proImg,
                // Add more fields as needed
            ];

            $products[] = $product;
        }

        $customer = CustomerModel::where('id',$customer_id)->first();

        Quotation::create([
            'user_id' => \request('submitted_by'),
            'customer_id'=> $customer_id,
            'products' => json_encode($products),
            'logo' => \request('logo'),
            'delivery_charge' => \request('delivery_charge'),
            'delivery_check' => \request('delivery_check'),
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
            'submitted_by' => \request('submitted_by'),
            'status' => \request('status'),
            'quotation_number' => '#'.rand(1111111,9999999),
            'phone_number' => \request('phone_number'),
        ]);

        return redirect()->back()->with('success','Quotation Added Successfully');
    }


    public function allQuotations($customer_id){

      $quotations =Quotation::where('customer_id',$customer_id)
                                ->with('users')
                              ->orderByDesc('created_at')
                              ->orderByDesc('updated_at')
                              ->get();
      $customers = CustomerModel::where('id',$customer_id)->get()->all();



        if (\request()->routeIs('user-customer-all-quotations')){
            $user = Auth::user();
            $notifications = $user->notifications;
            return view('user.userCustomerProfileQuotation',
                compact('quotations','customers','customer_id','notifications'));
        }else{
            return view('customersAllQuotations',
                compact('quotations','customers','customer_id'));
        }

    }

    public function viewEditQuotation($customer_id,$quotation_id){

        $users = User::all();
        $customers =   CustomerModel::where('id',$customer_id)->with('quotations')->get()->all();
        $quotations =  Quotation::where('id',$quotation_id)->with('customers')->get()->all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        if (\request()->routeIs('user-view-edite-quotation-from-profile')){
            return view('user.editQuotationForm',compact('users','quotations','customers','customer_id',
            'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('editQuotationFromProfile',compact('users','quotations','customers',
                'customer_id','unites','statuses',
                'querySources','deliveryTerms','paymentTypes','warranties'));
        }

    }


    public function editQuotation($customer_id,$quotation_id){


        $this->validate(\request(),[
            'logo'=> 'required',
            'submitted_by' =>'required',
            'product_name'=> 'required',
            'product_code'=> 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'unit'=>'required',
            'product_description' => 'nullable',
            'costing' => 'nullable',
            'product_discount' => 'nullable',
            'product_source' => 'nullable',
            'product_image' => 'nullable',
            'offer_validity' => 'nullable',
            'warranty' => 'required',
            'payment_type' => 'required',
            'vat_tax' => 'nullable',
            'delivery_term' => 'nullable',
            'delivery_date' => 'nullable',
            'other_condition' => 'nullable',
            'delivery_charge' => 'nullable',
            'discount_amount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
            'status' => 'required',
        ]);

//        dd(\request()->all());
        $data = \request()->all();
        $products = [];

        $quotation = Quotation::where('id', $quotation_id)->first();
        $product = json_decode($quotation->products, true);

        foreach ($data['product_name'] as $index => $productName) {
            $productImage = request()->file('product_image');
            $proImg = null; // Default value when no new image is uploaded

            // Check if a new image is uploaded for this product
            if ($productImage && isset($productImage[$index])) {
                $imgExt = $productImage[$index]->extension();
                $proImg = $productName . rand(1111, 9999) . '.' . $imgExt;
                $productImage[$index]->move('images/quotationProduct', $proImg);
            } else {
                // No new image uploaded, keep the existing one
                if (isset($product[$index]['product_image'])) {
                    $proImg = $product[$index]['product_image'];
                }
            }

            // Update the specific product inside the $products array
            $products[$index] = [
                'product_name' => $productName,
                'product_code' => $data['product_code'][$index],
                'quantity' => $data['quantity'][$index],
                'unit_price' => $data['unit_price'][$index],
                'description' => $data['product_description'][$index],
                'unit' => $data['unit'][$index],
                'our_coasting' => $data['costing'][$index],
                'product_source' => $data['product_source'][$index],
                'product_discount' => $data['product_discount'][$index],
                'product_image' => $proImg,
                // Add more fields as needed
            ];
        }

        $customer = CustomerModel::where('id',$customer_id)->first();

        try {
            Quotation::where('id', $quotation_id)->update([
                'logo' => \request('logo'),
                'user_id' => \request('submitted_by'),
                'customer_id' => $customer_id,
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
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
                'status' => \request('status'),
                'phone_number' => $customer->phone_number,
            ]);

            return redirect()->back()->with('success', 'Quotation Updated Successfully');
        } catch (\Exception $e) {
            // If an exception occurs, handle it here.
            // You can log the error, display a user-friendly message, or perform any other necessary actions.
            return redirect()->back()->with('error', 'An error occurred while updating the quotation. Please try again later.');
        }
    }

    public function deleteSingleProductQuotation($customer_id,$quotation_id,$productIndex){

            $quotation = Quotation::where('id',$quotation_id)->first();
            $products = json_decode($quotation->products, true);

            // Remove the product at the specified index
            if (isset($products[$productIndex])) {
                unset($products[$productIndex]);
                $products = array_values($products); // Reindex the array
            }

            // Update the quotation with the modified products array
            $quotation->products = json_encode($products);
            $quotation->save();

            return redirect()->back()->with('success', 'Product deleted successfully');

    }

    public function deleteQuotation($customer_id, $quotation_id){

        QuotationHistory::where('quotation_id',$quotation_id)->delete();
        Quotation::where('id',$quotation_id)->delete();

        return redirect()->back()->with('success', 'Quotation Deleted');

    }

    public function downloadQuotationPdf($customer_id, $quotation_id)
    {
        $quotation = Quotation::where('id', $quotation_id)
            ->with('customers')
            ->first();

        if (!$quotation) {
            // Handle the case when the quotation is not found
            // For example, return an error message or redirect to another page
            return "Quotation not found";
        }

//        dd($quotation);

        $quotationPdf = view('pdf.quotationPdf', compact('quotation'))->render();

        $pdf = new Mpdf([
            'format' => 'A4',
        ]);
        $pdf->WriteHTML($quotationPdf);
        $quotationNumber = 'Quotation'.$quotation->quotation_number.'.pdf';

        return response($pdf->Output($quotationNumber, 'D'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="quotation.pdf"',
        ]);
    }

    public function viewQuotation($customer_id, $quotation_id){
        $quotation = Quotation::where('id', $quotation_id)
            ->with('customers')
            ->first();

//        PDF Option
        $pdfSetup = PDFsetup::where('name',$quotation->logo)->first();

        if (!$quotation) {
            // Handle the case when the quotation is not found
            // For example, return an error message or redirect to another page
            return "Quotation not found";
        }

//        dd($quotation);


        $pdf = new Mpdf([
            'format' => 'A4',
        ]);
        $quotationNumber = 'Quotation'.$quotation->quotation_number.'.pdf';

        $pdf->WriteHTML(view('pdf.quotationPdf', compact('quotation','pdfSetup'))->render());

        // Output the PDF as a string
        $pdfContent = $pdf->Output($quotationNumber, 'S');

        // Return the response with PDF content and headers
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);

//        dd($pdfSetup);
    }


    public function sentQuotationMail($customer_id,$quotation_id){

        $customers = CustomerModel::where('id',$customer_id)->get()->first();

        $quotation = Quotation::where('id',$quotation_id)->with('customers','users')->first();

        $customer_email = $customers['email'];

//        dd($customer_email);
//
//        dd($quotations);
        Mail::to($customer_email)->send(new QuotationMail($customers,$quotation));

      Quotation::where('id',$quotation_id)->update([
        'status' => 'Sent',
      ]);

        return redirect()->back()->with('success','Mail sent successfully');

    }



//    ========= Invoice =======

    public function allInvoice($customer_id){
       $invoices = Invoice::where('customer_id',$customer_id)->with('customers','users')->get()->all();


//       dd($invoices);
        if (\request()->routeIs('admin-customer-all-invoice')){
                return view('adminCustomerAllInvoice',compact('customer_id','invoices'));
        }else{
            $user = Auth::user();
            $notifications = $user->notifications;

            return view('user.userCustomerAllInvoice',
                compact('invoices','customer_id','notifications'));
        }

    }

    public function viewInvoiceGenerator($customer_id,$quotation_id){

        $quotations = Quotation::where('id',$quotation_id)->with('customers','users')->get()->all();
        $users = User::all();


        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

//        dd($quotations);
        if (\request()->routeIs('view-invoice-generator')){
            $user = Auth::user();
            $notifications = $user->notifications;
            return view('user.viewInvoiceFormCustomerProfile',compact('quotations','customer_id',
                'users','notifications','unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('user.viewInvoiceFormCustomerProfile',compact('quotations','customer_id',
                'users','unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }

    }

    public function makeInvoice($customer_id,$quotation_id){

        $customer = CustomerModel::where('id', $customer_id)->first();
        $phoneNumber = $customer['phone_number'];

        $this->validate(\request(),[
            'phone' => 'nullable',
            'logo' => 'required',
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
            'delivery_date' => 'required',
            'delivery_charge' => 'nullable',
            'discount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
        ]);

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

         $admin_id = Auth::guard('admin')->id();


            Invoice::create([
                'logo' => \request('logo'),
                'admin_id' => $admin_id,
                'user_id' => null,
                'customer_id' => $customer_id,
                'invoice_no' => rand(111111,999999),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
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
                'phone_number' => $phoneNumber,
                'created_by' => \request('created_by'),
                'status' => 'Due',
            ]);

        return to_route('make-payment',[$customer_id,$quotation_id]);

    }


    public function viewGenerateNewInvoice($customer_id){
        $users = User::all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

//        dd($quotations);
        if (\request()->routeIs('admin-view-generate-new-invoice')){
            return view('adminCustomerGenerateNewInvoice',
                compact('customer_id','users','unites','statuses',
                    'querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('user.userCustomerGenerateNewInvoice',
                compact('customer_id','users','unites','statuses',
                    'querySources','deliveryTerms','paymentTypes','warranties'));
        }

    }

    public function generateNewInvoice($customer_id){

        $this->validate(\request(),[
            'phone_number' => 'nullable',
            'logo' => 'required',
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
            'delivery_address' => 'nullable',
            'receiver_name' => 'nullable',
            'receiver_number' => 'nullable',
            'discount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
            'status' => 'Due'
        ]);

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


        if (\request()->routeIs('admin-generate-new-invoice')){
            $admin_id = Auth::guard('admin')->id();

            Invoice::create([
                'phone_number' => \request('phone_number'),
                'user_id' => null,
                'admin_id' => $admin_id,
                'logo' => \request('logo'),
                'customer_id' => $customer_id,
                'invoice_no' => rand(111111,999999),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
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
                'created_by' => \request('created_by'),
                'delivery_address' => \request('delivery_address'),
                'receiver_name' => \request('receiver_name'),
                'receiver_number' => \request('receiver_number'),

            ]);

            $invoice= Invoice::where('customer_id',$customer_id)->get()->last();

            $invoice_id = $invoice['id'];
            return to_route('admin-make-payment',[$customer_id,$invoice_id]);

        }else{
            $user_id = Auth::user()->id;

            Invoice::create([
                'phone_number' => \request('phone_number'),
                'user_id' => $user_id,
                'admin_id' =>null,
                'logo' => \request('logo'),
                'customer_id' => $customer_id,
                'invoice_no' => rand(111111,999999),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
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
                'created_by' => \request('created_by'),
                'delivery_address' => \request('delivery_address'),
                'receiver_name' => \request('receiver_name'),
                'receiver_number' => \request('receiver_number'),
            ]);

            $invoice= Invoice::where('customer_id',$customer_id)->get()->last();
            $invoice_id = $invoice['id'];

            return redirect()->back()->with('success','Invoice Created Successfully');
//            return to_route('make-payment',[$customer_id,$invoice_id]);
        }


    }

    public function addPaymentGenerateInvoice($invoice_id){
        $invoices = Invoice::where('id', $invoice_id)->get()->last();

        $invoice_id = $invoices['id'];

//        dd($invoice_id);

        return view('user.userCustomerAddPayment', compact('customer_id','quotation_id','invoice_id'));
    }

    public function viewEditInvoice($customer_id,$invoice_id){

        $invoices = Invoice::where('id',$invoice_id)->with('payments','customers','users')->get()->all();
        $users = User::all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();


        if (\request()->routeIs('admin-view-edit-invoice')){
            return view('adminCustomerEditInvoice', compact('invoices','customer_id','users',
            'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('user.userCustomerEditInvoice', compact('invoices','customer_id','users',
                'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }

    }

    public function updateInvoice($customer_id,$invoice_id){
        $this->validate(\request(),[
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
            'delivery_address' => 'nullable',
            'receiver_name' => 'nullable',
            'receiver_number' => 'nullable',
            'discount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
            'logo' => 'required'
        ]);

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

        if (\request()->routeIs('admin-update-invoice')){

            $admin_id = Auth::guard('admin')->id();

            Invoice::where('id',$invoice_id)->update([
                'user_id' => null,
                'admin_id' => $admin_id,
                'customer_id' => $customer_id,
                'invoice_no' => rand(111111,999999),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
                'discount' => \request('discount_amount'),
                'extra_charge_name' => \request('extra_charge_name'),
                'extra_amount' => \request('extra_amount'),
                'vat_tax' => \request('vat_tax'),
                'delivery_term' => \request('delivery_term'),
                'warranty' => \request('warranty'),
                'delivery_date' => \request('delivery_date'),
                'payment_type' => \request('payment_type'),
                'other_condition' => \request('other_condition'),
                'created_by' => \request('submitted_by'),
                'delivery_address'=> \request('delivery_address'),
                'receiver_name'=> \request('receiver_name'),
                'receiver_number'=> \request('receiver_number'),
                'logo' => \request('logo'),
            ]);

        }else{

            $user_id = Auth::user()->id;

            Invoice::where('id',$invoice_id)->update([
                'user_id' => $user_id,
                'admin_id' => null,
                'customer_id' => $customer_id,
                'invoice_no' => rand(111111,999999),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
                'discount' => \request('discount_amount'),
                'extra_charge_name' => \request('extra_charge_name'),
                'extra_amount' => \request('extra_amount'),
                'vat_tax' => \request('vat_tax'),
                'delivery_term' => \request('delivery_term'),
                'warranty' => \request('warranty'),
                'delivery_date' => \request('delivery_date'),
                'payment_type' => \request('payment_type'),
                'other_condition' => \request('other_condition'),
                'created_by' => \request('submitted_by'),
                'delivery_address'=> \request('delivery_address'),
                'receiver_name'=> \request('receiver_name'),
                'receiver_number'=> \request('receiver_number'),
                'logo' => \request('logo'),
            ]);
        }


        return redirect()->back()->with('success','Invoice Updated');
    }

    public function removeSingleProductInvoice($customer_id,$invoice_id,$index_id){
        $invoice = Invoice::where('customer_id', $customer_id)->findOrFail($invoice_id);

        $products = json_decode($invoice->products, true);
        unset($products[$index_id]);
        $products = array_values(array_filter($products));

        $invoice->products = json_encode($products);
        $invoice->save();

           if(\request()->routeIs('admin-remove-single-product')){
            return redirect()->back();
        }else{
            return redirect()->route('user-view-edit-invoice',[$customer_id,$invoice_id,$index_id]);
        }
    }



    public function viewInvoicePdf($customer_id, $invoice_id)
                {
                    $invoice = Invoice::where('id', $invoice_id)
                        ->with('customers', 'users', 'payments', 'admins')
                        ->first();

                    if (!$invoice) {
                        // Handle the case when the invoice is not found
                        // For example, return an error message or redirect to another page
                        return "Invoice not found";
                    }

                    // Create a new Mpdf instance
                    $pdf = new Mpdf([
                        'format' => 'A4',
                    ]);

                    // Set the name for the PDF file
                    $invoiceName = 'Invoice_' . $invoice['invoice_no'] . '.pdf';

                    // Write HTML content to the PDF
                    $pdf->WriteHTML(view('pdf.invoicePdf', compact('invoice'))->render());

                    // Output the PDF as a string
                    $pdfContent = $pdf->Output($invoiceName, 'S');

                    // Return the response with PDF content and headers
                    return response($pdfContent, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $invoiceName . '"',
                    ]);
                }


    public function downloadInvoicePdf($invoice_id){
        $invoice = Invoice::where('id',$invoice_id)->with('users','customers','payments')->first();
        if (!$invoice) {
            // Handle the case when the quotation is not found
            // For example, return an error message or redirect to another page
            return "Quotation not found";
        }

          $invoiceName = 'Invoice_'.$invoice['invoice_no'].'.pdf';

        $pdf = new Mpdf([
            'format' => 'A4',
        ]);

        $pdf->WriteHTML(view('pdf.invoicePdf', compact('invoice'))->render());

        // Output the PDF as a string
        // $pdfContent = $pdf->Output($invoiceNo, 'D');

        // Return the response with PDF content and headers
        return response($pdf->Output($invoiceName, 'D'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>'inline; filename= "invoiceName.pdf"',
        ]);

    }

    public function deleteInvoice ($custome_id,$invoice_id){
        Invoice::where('id',$invoice_id)->delete();

        return redirect()->back()->with('Invoice Deleted');
    }

//    ============= Payment ================

    public function allPayments($customer_id){

        $payments = Payment::where('customer_id',$customer_id)->with('customers','invoices','users','accounts')->get()->all();

        $invoices = Invoice::where('customer_id',$customer_id)->get();

//        dd($payments);

        if (\request()->routeIs('admin-customer-all-payment')){

            return  view('adminCustomerAllPayments',compact('payments','customer_id','invoices'));
        }else{
            $user = Auth::user();
            $notifications = $user->notifications;

            return view('user.customerAllPayments',
                compact('payments','customer_id','notifications'));
        }

    }

    public function viewAddPaymentForm($customer_id,$quotation_id){

        $invoices = Invoice::where('customer_id',$customer_id)->get()->last();

        $invoice_id = $invoices['id'];

        $accounts = Accounts::all();

//        dd($invoice_id);

        return view('user.userCustomerAddPayment', compact('customer_id','quotation_id','invoice_id','accounts'));
    }

    public function addPaymentFromInvoice($customer_id, $invoice_id){

        $this->validate(\request(), [
            'pay_with' => 'required',
            'ref_no' => 'required',
            'bank_name' => 'required',
            'cash_in' => 'required',
            'amount' => 'required',
            'payment_note'=> 'nullable|max:600',
            'payment_date' => 'required',
        ]);

        if (\request()->routeIs('admin-direct-add-payment')) {

            $admin_id = Auth::guard('admin')->id();

            $payment = Payment::create([
                'user_id' => null,
                'admin_id' => $admin_id,
                'account_id' => \request('cash_in'),
                'invoice_id' => $invoice_id,
                'customer_id' => $customer_id,
                'payment_with' => \request('pay_with'),
                'bank_name' => \request('bank_name'),
                'Ref_no' => \request('ref_no'),
                'amount' => \request('amount'),
                'payment_date' => \request('payment_date'),
                'payment_note' => \request('payment_note')
            ]);

            $account =  Accounts::find(\request('cash_in'));
            $balanceUpdate = $account->balance + $payment->amount;

            Transaction::create([
                'account_id' => \request('cash_in'),
                'payment_id' => $payment->id,
                'expanse_id' => null,
                'table_note' => \request('payment_note'),
                'status' => 'Debit',
                'amount'=> \request('amount'),
                'balance' => $balanceUpdate,
            ]);

            $account->update([
                'balance' => $balanceUpdate,
            ]);

            return redirect()->route('admin-customer-all-payment', [$customer_id])->with('success', 'Payment added successfully');

        } else {
            if (Auth::check()) {
                $user_id = Auth::user()->id;

              $payment =  Payment::create([
                    'user_id' => $user_id,
                    'account_id' => \request('cash_in'),
                    'admin_id' => null,
                    'invoice_id' => $invoice_id,
                    'customer_id' => $customer_id,
                    'payment_with' => \request('pay_with'),
                    'bank_name' => \request('bank_name'),
                    'Ref_no' => \request('ref_no'),
                    'amount' => \request('amount'),
                    'payment_date' => \request('payment_date'),
                    'payment_note' => \request('payment_note')
                ]);
            }

            $account =  Accounts::find(\request('cash_in'));
            $balanceUpdate = $account->balance + $payment->amount;

            Transaction::create([
                'account_id' => \request('cash_in'),
                'payment_id' => $payment->id,
                'expanse_id' => null,
                'table_note' => \request('payment_note'),
                'status' => 'Debit',
                'amount'=> \request('amount'),
                'balance' => $balanceUpdate,
            ]);

            $account->update([
                'balance' => $balanceUpdate,
            ]);

            return redirect()->route('user-customer-profile', [$customer_id])->with('success', 'Payment added successfully');
        }
    }


    public function addPaymentsFromProfile($customer_id){

        $invoices = Invoice::where('customer_id',$customer_id)->get()->all();
//        dd($invoices);

        return view('user.userAddPaymentFromCustomerProfile',compact('invoices','customer_id'));
    }


    public function addPayment($customer_id){
        $this->validate(\request(),[
            'invoice_id' => 'required',
            'pay_with' => 'required',
            'payment_note' => 'nullable',
            'amount' => 'required',
            'ref_no' => 'required',
            'bank_name' => 'required',
            'payment_date' => 'required',
        ]);

        Payment::create([
           'user_id' => Auth::user()->id,
            'customer_id' => $customer_id,
            'invoice_id' => \request('invoice_id'),
            'payment_with' => \request('pay_with'),
            'bank_name' => \request('bank_name'),
            'payment_note' => \request('payment_note'),
            'payment_date' => \request('payment_date'),
            'amount' => \request('amount'),
            'Ref_no' => \request('ref_no'),
        ]);

        return redirect()->back()->with('success','payment Added successfully');
    }

    public function notes($customer_id){

        $notes = CustomerNotes::where('customer_id',$customer_id)
                                ->orderByDesc('created_at')
                                ->with('users','admins')
                                ->get();

       if (\request()->routeIs('admin-customer-notes')){
           return view('adminCustomerNotes', compact('notes','customer_id'));
       }else{
           return view('customerNotes', compact('notes','customer_id'));
       }

    }

    public function addNotes($customer_id){

        $this->validate(\request(),[
            'notes' => 'required|max:1000',
        ]);

        if (\request()->routeIs('admin-customer-add-notes')){

            $adminId = Auth::guard('admin')->id();

            CustomerNotes::create([
                'user_id' => null,
                'admin_id' => $adminId,
                'customer_id' => $customer_id,
                'notes' => \request('notes'),
            ]);
        }else{
            CustomerNotes::create([
                'user_id' => Auth::user()->id,
                'admin_id' => null,
                'customer_id' => $customer_id,
                'notes' => \request('notes'),
            ]);
        }



        return redirect()->back()->with('success', 'Notes Added');

    }

}
