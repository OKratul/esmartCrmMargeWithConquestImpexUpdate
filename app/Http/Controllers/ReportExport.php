<?php

namespace App\Http\Controllers;

use App\Exports\QueryExport;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\PaymentType;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReportExport extends Controller
{

    public function viewQueryExport(){
        $querySources = QuerySource::all();
        $statuses = QueryStatus::all();
        $unites = Unit::all();
        $customers = CustomerModel::all();
        $warranties = Warranty::all();
        $paymentTypes= PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();
        $users = User::all();
        $queryStatus = QueryStatus::all();


        $searchTerm = \request('search');
        $dateFrom = \request('date_from');
        $dateTo = \request('date_to');
        $status = \request('status');
        $user = \request('user');

        Session::put('searchTerm', $searchTerm);
        Session::put('dateFrom', $dateFrom);
        Session::put('dateTo', $dateTo);
        Session::put('status', $status);
        Session::put('user', $user);

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


//        Excel::download(new QueryExport($queries), 'Queries.xlsx');

//dd($queries);
        return view('excel.viewQueryExport',
            compact('querySources','statuses','unites',
                    'customers','warranties','paymentTypes','deliveryTerms','users'
                    ,'queryStatus','queries'
            ));

    }

    public function exportQuery()
    {
        // Retrieve search parameters from the session
        $searchTerm = Session::get('searchTerm');
        $dateFrom = Session::get('dateFrom');
        $dateTo = Session::get('dateTo');
        $status = Session::get('status');
        $user = Session::get('user');

        // Use search parameters to filter the queries
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
            ->get();

        // Download the Excel file
        return Excel::download(new QueryExport($queries), 'Queries.xlsx');
    }

}
