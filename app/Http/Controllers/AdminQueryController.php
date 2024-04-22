<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTerm;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminQueryController extends Controller
{
    public function allQuery(){

        $pageTitle = 'Admin All Query';
        $searchTerm = \request('search');
        $dateFrom = \request('date_from');
        $dateTo = \request('date_to');
        $status = \request('status');
        $user = \request('user');

        Session::put('searchTerm', $searchTerm);
        Session::put('dateFrom', $dateFrom);
        Session::put('dateTo', $dateTo);
        Session::put('status_admin', $status);
        Session::put('user_admin', $user);

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

        $users = User::get()->all();


        $queryStatus = QueryStatus::get('query_status');


        $pendingQuery = Query::where('user_id',null)->count();
        $processingQuery = Query::where('status','Processing')->count();
//        $processingQuery = Query::where('status','Processing')->count();
        $quotationSent = Query::where('status','Quotation Sent')->count();
        $orderConfirmed = Query::where('status','Order Confirmed')->count();
        $deliveryOnGoing = Query::where('status','Delivery On Going')->count();
        $delivered = Query::where('status','Delivered')->count();
        $closed = Query::where('status','Closed')->count();

        $counts = [$processingQuery, $quotationSent, $orderConfirmed, $deliveryOnGoing,$delivered,$closed];

//        $counts = [$pendingQuery, $processingQuery, $quotationSent, $orderConfirmed, $deliveryOnGoing, $delivered, $closed];

        $statusCounts = $queryStatus->map(function ($status, $index) use ($counts) {
            return [
                'statusName' => $status->query_status,
                'count' => $counts[$index], // Use $index to get the corresponding count for each status
            ];
        })->toArray();

        $querySources = QuerySource::all();
        $unites = Unit::all();
        $warranties = Warranty::all();
        $paymentTypes = PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();



        $admin = Auth::guard('admin');
//        $notifications = $admin->unreadNotifications;

        $totalQuery = $queries->total();
//        dd($statusCounts);
//        dd($searchTerm);
        return view('adminAllQuery',compact('queries','totalQuery',
            'users' ,'queryStatus','unites','warranties','paymentTypes','deliveryTerms',
            'statusCounts',
            'pendingQuery',
            'querySources',
            'pageTitle',
        ));
    }
}
