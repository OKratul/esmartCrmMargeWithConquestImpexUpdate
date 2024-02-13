<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\PaymentType;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Quotation;
use App\Models\QuotationHistory;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuotationController extends Controller
{
    public function allQuotation(){

        $pageTitle = 'All Quotation';
        $search = \request('search');
        $dateFrom = \request('date_from');
        $dateTo = \request('date_to');
        $byUser = \request('by_user');
        $byStatus = \request('by_status');

        $users = User::all();
        $customers = CustomerModel::all();

        $quotations = Quotation::with('customers', 'users', 'histories.users')
            ->when($search, function ($query) use ($search) {
                $query->where('quotation_number', 'like', "%{$search}%")
                    ->orWhereHas('customers', function ($query) use ($search) {
                        $query->where('email', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    })->orWhere(function ($query) use ($search) {
                        $query->whereRaw("json_unquote(json_extract(products, '$**.product_name')) like ?", ["%{$search}%"]);
                    });
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when($byUser, function ($query) use ($byUser) {
                $query->where('user_id', $byUser);
            })
            ->when($byStatus, function ($query) use ($byStatus) {
                $query->where('status', $byStatus);
            })
            ->when(!$search && !$byUser && !$byStatus && $dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('delivery_date', [$dateFrom, $dateTo]);
            })
            ->when(!$search && !$byUser && !$byStatus && !$dateFrom && !$dateTo, function ($query) {
                // Handle default case if no filters are provided
                $query->orderByDesc('updated_at');
            })
            ->paginate(10)
            ->withQueryString();

// Rest of your code...




        $user = Auth::user();
        $notifications = $user->notifications;


        $totalQuotation = $quotations->total();

        $totalQuotationValue = 0; // Initialize $totalQuotationValue outside the loop

        foreach ($quotations as $quotation) {
            $products = json_decode($quotation->products, true);

            foreach ($products as $product) {
                $unitPrice = $product['unit_price'];
                $priceWithVat = 0; // Initialize $priceWithVat

                if (!empty($quotation->vat_tax)) {
                    if ($quotation->vat_tax == 10.5) {
                        $priceWithAit = $unitPrice + floatval($unitPrice) * 3 / 100;
                        $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    } else {
                        $priceWithVat = $unitPrice + floatval($unitPrice) * floatval($quotation->vat_tax) / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    }
                } else {
                    $subTotal = floatval($unitPrice) * floatval( $product['quantity']);
                    $priceWithVat = $unitPrice;
                }

                // Accumulate the subTotal to the totalQuotationValue
                $totalQuotationValue += $subTotal;
            }
        }

        $quotationSents = Quotation::where('status', 'Sent')
            ->when($byUser, function ($query) use ($byUser) {
                $query->where('user_id', $byUser);
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->orderByDesc('created_at')
            ->get();

        $quotationNotSents = Quotation::where('status', 'Not Sent')
            ->when($byUser, function ($query) use ($byUser) {
                $query->where('user_id', $byUser);
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->orderByDesc('created_at')
            ->get();

// ==== Get Value For Total Not Sent =======

        $totalQuotationNotSentValue = 0;

        foreach ($quotationNotSents as $notSent) {
            $products = json_decode($notSent->products, true);

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
                $totalQuotationNotSentValue += $subTotal;
            }
        }

// ========== Get Value For Total Sent =============

        $totalSentValue = 0;
        foreach ($quotationSents as $sent) {
            $products = json_decode($sent->products, true);

            foreach ($products as $product) {
                $unitPrice = floatval($product['unit_price']);
                $priceWithVat = 0; // Initialize $priceWithVat

                if (!empty($sent->vat_tax)) {
                    if ($sent->vat_tax == 10.5) {
                        $priceWithAit = $unitPrice + floatval($unitPrice) * 3 / 100;
                        $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    } else {
                        $priceWithVat = $unitPrice + floatval($unitPrice) * floatval($sent->vat_tax) / 100;
                        $subTotal = floatval($priceWithVat) * floatval($product['quantity']);
                    }
                } else {
                    $subTotal = floatval($unitPrice) * floatval($product['quantity']);
                    $priceWithVat = $unitPrice;
                }

                // Accumulate the subTotal to the totalSentValue
                $totalSentValue += $subTotal;
            }
        }

//        ====== Closed Queris =======

        $closedQueries = Query::where('status', 'Closed')
            ->when($byUser, function ($query) use ($byUser) {
                $query->where('user_id', $byUser);
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->get();





//        dd($quotations);

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();
        $users = User::all();

        $customers = CustomerModel::all();
//        dd($quotations);

        return view('user.allQuotations',
            compact('quotations','totalQuotation','notifications','unites',
            'customers','users',
            'totalQuotationValue',
            'totalSentValue',
            'quotationSents',
            'quotationNotSents',
            'closedQueries',
            'pageTitle',
            'totalQuotationNotSentValue'
            ,'statuses','querySources','deliveryTerms','paymentTypes','warranties'));

    }

    public function quotation(){

        $this->validate(\request(),[
            'logo' => 'required',
            'phone_number' => 'nullable',
            'submitted_by' => 'required',
            'status' => 'required',
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
            'delivery_check' => 'nullable',
            'discount_amount' => 'nullable',
            'extra_charge_name' => 'nullable',
            'extra_amount' => 'nullable',
        ]);

//        dd(\request()->all());
        $data = request()->all();
        $products = [];

        // Iterate over the array fields and store them as an array of products

        foreach ($data['product_name'] as $index => $productName) {

            $productImage = request()->file('product_image');
            if ($productImage) {
                $imgExt = $productImage[$index]->extension();
                $proImg = 'quotation_product_image' . rand(1111, 9999) . '.' . $imgExt;

                $productImage[$index]->move('images/quotationProduct', $proImg);
            }else{
                $proImg = null;
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

        if (\request()->routeIs('user-quotation')){
            Quotation::create([
                'logo' => \request('logo'),
                'user_id' => \request('submitted_by'),
                'customer_id'=> \request('customer_id'),
                'contact_name' => \request('contact_name'),
                'phone_number' => \request('phone_number'),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
                'delivery_check' => \request('delivery_check'),
                'discount_amount' => \request('discount_amount'),
                'extra_charge_name' => \request('extra_charge_name'),
                'extra_amount' => \request('extra_amount'),
                'offer_validity' => \request('offer_validity'),
                'vat_tax' => \request('vat_tax'),
                'delivery_term' => \request('delivery_term'),
                'warranty' => \request('warranty'),
                'delivery_address' => \request('delivery_address'),
                'delivery_date' => \request('delivery_date'),
                'payment_type' => \request('payment_type'),
                'other_condition' => \request('other_condition'),
                'submitted_by' => \request('submitted_by'),
                'status' => \request('status'),
                'quotation_number' => rand(111111111111,99999999999),
            ]);
            return redirect('quotation/all-quotation')->with('success','Quotation Added');
        }else{
            Quotation::create([
                'logo' => \request('logo'),
                'user_id' => \request('submitted_by'),
                'customer_id'=> \request('customer_id'),
                'contact_name' => \request('contact_name'),
                'phone_number' => \request('phone_number'),
                'products' => json_encode($products),
                'delivery_charge' => \request('delivery_charge'),
                'delivery_check' => \request('delivery_check'),
                'discount_amount' => \request('discount_amount'),
                'extra_charge_name' => \request('extra_charge_name'),
                'extra_amount' => \request('extra_amount'),
                'offer_validity' => \request('offer_validity'),
                'vat_tax' => \request('vat_tax'),
                'delivery_term' => \request('delivery_term'),
                'warranty' => \request('warranty'),
                'delivery_address' => \request('delivery_address'),
                'delivery_date' => \request('delivery_date'),
                'payment_type' => \request('payment_type'),
                'other_condition' => \request('other_condition'),
                'submitted_by' => \request('submitted_by'),
                'status' => \request('status'),
                'quotation_number' => rand(111111111111,99999999999),
            ]);
            return redirect('admin/all-quotation')->with('success','Quotation Added');
        }


    }

    public function quotationHistory($id){

        $quotation = Quotation::where('id',$id)->with('histories.users')->first();

        return view('quotationHistory',compact('quotation'));

    }

    public function viewQuotationForm(){

        $customers = CustomerModel::all();
        $users = User::all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        if(\request()->routeIs('user-view-quotation-form')){
            return view('user.userQuotationGenerate',compact('customers','users',
                'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }else{
            return view('quotationGenerate',compact('customers','users',
                'unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));
        }
    }

    public function showEditQuotation($quotation_id){

        $quotations = Quotation::where('id',$quotation_id)->get()->all();
        foreach ($quotations as $quotation){
            $products = json_decode($quotation->products, true);
        }
        $customer_id = Quotation::where('id',$quotation_id)->with('customers','users')->first();

        $customer_id = $customer_id->customers['id'];

        $customers = CustomerModel::all();

        $users = User::all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        return view('user.editQuotation',compact('quotations','users','customer_id',
            'customers','products','unites','statuses','querySources','deliveryTerms','paymentTypes','warranties'));

    }

    public function updateQuotation($quotation_id){

            $quotation = Quotation::findOrFail($quotation_id);

            $oldData = $quotation->toArray();

            $this->validate(\request(),[
                'logo' => 'required',
                'submitted_by' =>'required',
                'product_name'=> 'required',
                'product_code'=> 'required',
                'quantity' => 'required',
                'unit_price' => 'required',
                'phone_number' => 'nullable',
                'unit'=>'required',
                'product_description' => 'nullable',
                'costing' => 'nullable',
                'product_discount' => 'nullable',
                'product_source' => 'nullable',
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
                'status' => 'required'
            ]);

//        dd(\request()->all());
        $data = \request()->all();
        $products = [];


        // Iterate over the array fields and store them as an array of products
        $quotation = Quotation::where('id', $quotation_id)->first();
        $product = json_decode($quotation->products, true);

        // Iterate over the array fields and store them as an array of products
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

            // Update the specific product within the $products array
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

        Quotation::where('id', $quotation_id)->update([
            'logo'=> \request('logo'),
            'phone_number' => \request('phone_number'),
            'user_id' => \request('submitted_by'),
            'products' => json_encode($products),
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
            'status' => \request('status'),
        ]);

        $quotationNew = Quotation::find($quotation_id);

        $newData = $quotationNew->toArray();

        $this->createQuotationHistory($quotation_id, $oldData, $newData);

        return redirect('quotation/all-quotation')->with('success','Quotation Updated Successfully');

    }

    protected function createQuotationHistory($quotation_id , array $oldData, array $newData){
        $userId = Auth::id();

        QuotationHistory::create([
            'quotation_id' => $quotation_id,
            'user_id' => $userId,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
        ]);
    }




}
