<?php

namespace App\Http\Controllers;

use App\Events\QueryInserted;
use App\Exports\QueryExport;
use App\Listeners\SendQueryNotification;
use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\PaymentType;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use App\Notifications\QueryNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class QueryController extends Controller
{
    public function allQuery(){

        $pageTitle = 'All Query';

        $searchTerm = \request('search');
        $dateFrom = \request('date_from');
        $dateTo = \request('date_to');
        $status = \request('status');
        $user = \request('user');

        $queries = Query::with(['customers', 'notes', 'users'])
            ->when(!empty($searchTerm), function ($query) use ($searchTerm) {
                $query->whereHas('customers', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('email', 'like', "%{$searchTerm}%")
                        ->orWhere('phone_number', 'like', "%{$searchTerm}%")
                        ->orWhere('name', 'like', "%{$searchTerm}%")
                        ->orWhere('product_name', 'like', "%{$searchTerm}%");
                });
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when(!empty($user), function ($query) use ($user) {
                $query->where('user_id', '=', $user); // Exact match for user_id
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString()
        ;

        $pendingQuery = Query::where('user_id',null)->count();
        $processingQuery = Query::where('status','Processing')->count();
//        $processingQuery = Query::where('status','Processing')->count();
        $quotationSent = Query::where('status','Quotation Sent')->count();
        $orderConfirmed = Query::where('status','Order Confirmed')->count();
        $deliveryOnGoing = Query::where('status','Delivery On Going')->count();
        $delivered = Query::where('status','Delivered')->count();
        $closed = Query::where('status','Closed')->count();

        $users = User::all();
        $counts = [$processingQuery, $quotationSent, $orderConfirmed, $deliveryOnGoing,$delivered,$closed];


        $queryStatus = QueryStatus::get('query_status');

        $statusCounts = $queryStatus->map(function ($status, $index) use ($counts) {
            return [
                'statusName' => $status->query_status,
                'count' => $counts[$index], // Use $index to get the corresponding count for each status
            ];
        })->toArray();


        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        $totalQuery = $queries->total();

        $queryStatus = QueryStatus::all();


        $querySources = QuerySource::all();
        $unites = Unit::all();
        $warranties = Warranty::all();
        $paymentTypes = PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();
        $statuses = QueryStatus::all();
        $customers =CustomerModel::all();




//        dd($queries);
//        dd($searchTerm);
        return view('user.userAllQuery',compact('queries',
            'totalQuery','users','notifications','queryStatus',
                'pendingQuery',
                'processingQuery',
                'quotationSent',
                'orderConfirmed',
                'deliveryOnGoing',
                'delivered',
                'closed',
                'querySources',
                'unites',
                'warranties',
                'paymentTypes',
                'deliveryTerms',
                'statuses',
                'customers',
                'statusCounts',
                'counts',
                'pageTitle'
        ));

    }

    public function viewQueryForm(){

        $customers = CustomerModel::all();


//        dd($categories);
//        $categoryData = $productCategories->category()->getData();

//        $categories = $categoryData['categoriesWithSubcategories'];

////        dd($categories);

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        return view('addQueryForm',compact('customers',
            'unites', 'statuses', 'querySources', 'deliveryTerms', 'paymentTypes', 'warranties'));
    }

    public function queryWithCustomer(){

        $this->validate(\request(),[
            'type' => 'required',
            'name' => 'required',
            'contact_name' => 'nullable',
            'email' => 'nullable',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'nullable',
            'country' => 'nullable',
            'postal_code' => 'nullable',
            'query_source'=> 'required',
            'status'=> 'required',
            'query_details'=> 'required',
            'product_sku'=> 'nullable',
            'product_name'=> 'required',
            'product_quantity'=> 'required',
            'product_category'=> 'required',
            'submit_date'=> 'nullable',
            'reminder_date'=> 'nullable',
            'product_link' => 'nullable',
        ]);

        $customer = CustomerModel::where('phone_number',\request('phone'))
                                    ->first();

        $users  = User::all();

        if (!empty($customer )){

           $query =  Query::create([
                'customer_id' =>$customer['id'],
                'query_source' =>\request('query_source'),
                'status' =>\request('status'),
                'query_details' =>\request('query_details'),
                'product_sku' =>\request('product_sku'),
                'product_name' =>\request('product_name'),
                'phone_number' => \request('phone'),
                'product_quantity' =>\request('product_quantity'),
                'product_category' =>\request('product_category'),
                'reminder_date' =>\request('reminder_date'),
                'submit_date' => Carbon::now()->format('Y-m-d'),
                'product_link' => \request('product_link')
            ]);

            Notification::send($users, new QueryNotification($query));

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

            $customer_id = CustomerModel::latest('id')->value('id');

           $query = Query::create([
                'customer_id' =>$customer_id,
                'query_source' =>\request('query_source'),
                'status' =>\request('status'),
                'query_details' =>\request('query_details'),
                'product_sku' =>\request('product_sku'),
                'product_name' =>\request('product_name'),
                'phone_number' => \request('phone'),
                'product_quantity' =>\request('product_quantity'),
                'product_category' =>\request('product_category'),
                'reminder_date' =>\request('reminder_date'),
                'submit_date' => Carbon::now()->format('dM Y'),
                'product_link' => \request('product_link')

           ]);
            Notification::send($users, new QueryNotification($query));
        }

        if (\request()->routeIs('admin-updateQuery')){
            return to_route('dashboard')->with('success', 'Query And Customer Information Noted ');
        }else{
            return redirect()->back()->with('success','Customer And Query information Noted');
        }

    }

    public function addQuery(){

        $customer = CustomerModel::where('phone_number', \request('phone'))->first();


//        dd($customer['id']);

       $data = $this->validate(\request(),[
            'query_source' =>'required',
            'status' => 'required',
            'query_details' => 'nullable',
            'product_quantity' => 'nullable',
            'product_sku'=> 'nullable',
            'product_name'=> 'nullable',
            'product_category' => 'nullable',
            'reminder_date' => 'nullable',
            'product_link' => 'nullable'
        ]);

       $submitDate = Carbon::now()->format('Y-m-d');

       if (!empty($customer)){
           Query::create([
               'customer_id' => $customer['id'],
               'query_source' => \request('query_source'),
               'status' => \request('status'),
               'product_sku' => \request('product_sku'),
               'product_name' => \request('product_name'),
               'query_details' => \request('query_details'),
               'product_quantity' =>\request('product_quantity'),
               'product_category' => \request('product_category'),
               'reminder_date' => \request('reminder_date'),
               'submit_date' => $submitDate,
               'product_link' => \request('product_link'),
               'phone_number' => \request('phone'),

           ]);
       }else{

           $customer = CustomerModel::create([
               'customer_type' => \request('type'),
               'name' => \request('name'),
               'contact_name' => \request('contact_name'),
               'email' => \request('email'),
               'phone_number' => \request('phone'),
               'address' => \request('address'),
               'city' => \request('city'),
               'postal_code' => \request('postal_code'),
               'country' => \request('country'),
           ]);

           Query::create([
               'customer_id' => $customer['id'],
               'query_source' => \request('query_source'),
               'status' => \request('status'),
               'product_sku' => \request('product_sku'),
               'product_name' => \request('product_name'),
               'query_details' => \request('query_details'),
               'product_quantity' =>\request('product_quantity'),
               'product_category' => \request('product_category'),
               'reminder_date' => \request('reminder_date'),
               'submit_date' => $submitDate,
               'product_link' => \request('product_link'),
               'phone_number' => \request('phone'),

           ]);


       }

       return redirect('user/all-query')->with('success','Query Successfully added');
    }




    public function showUpdateQuery($query_id){

        $query = Query::where('id',$query_id)->first();

//        dd($query);

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        return view('user.userViewUpdateQuery',compact('query','unites','statuses',
            'querySources','deliveryTerms','paymentTypes','warranties'));
    }

    public function updateQuery($query_id){

        $data = $this->validate(\request(),[
            'query_source' =>'required',
            'status' => 'required',
            'query_details' => 'required',
            'product_quantity' => 'nullable',
            'product_sku'=> 'nullable',
            'product_name'=> 'nullable',
            'product_category' => 'nullable',
            'reminder_date' => 'nullable',
            'submit_date' => 'nullable',
            'product_link' => 'nullable',
        ]);

        Query::where('id',$query_id)->update([
            'query_source' => \request('query_source'),
            'status' => \request('status'),
            'product_sku' => \request('product_sku'),
            'product_name' => \request('product_name'),
            'query_details' => \request('query_details'),
            'product_quantity' =>\request('product_quantity'),
            'product_category' => \request('product_category'),
            'reminder_date' => \request('reminder_date'),
            'submit_date' => \request('submit_date'),
            'product_link' => \request('product_link'),
        ]);

           return redirect()->back()->with('success','Query Updated');


        // return to_route('my-queries')->with('success','Query Successfully Updated');

    }


    public function deleteQuery($query_id){

        $query = Query::where('id',$query_id)->delete();

        return redirect()->back()->with('success','Query Deleted ');
    }

    public function viewSingleQuery($query_id){

        $query = Query::where('id',$query_id)->first();

        return view('user.userViewSingleQuery',compact('query'));
    }


    public function viewUserAllQuery(){

        $userId = Auth::user()->id;

        $status = \request('status');

        $form = \request('date_from');
        $to = \request('date_to');

        if ($form || $to){

            $queries = Query::where('user_id', $userId)
                                ->whereBetween('created_at',[$form, $to])
                              ->with('customers','users')
                              ->orderByDesc('created_at')
                              ->paginate(500);

            $totalQuery = count($queries);

    }elseif (!empty($status)){
            $queries = Query::where('user_id', $userId)
                ->where('status',$status)
                ->with('customers','users')
                ->orderByDesc('created_at')
                ->paginate(500);

            $totalQuery = count($queries);
        }
        else{

            $queries = Query::where('user_id',$userId)
                ->orderByDesc('created_at')
                ->with('customers','users')
                ->paginate(20);

            $totalQuery = count(Query::where('user_id', $userId)->get());
        }

        $users = User::all();
        $statuses = QueryStatus::all();

        return view('user/authUserAllQuery', compact('queries','users','totalQuery','statuses'));
    }

}
