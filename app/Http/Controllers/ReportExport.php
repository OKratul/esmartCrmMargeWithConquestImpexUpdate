<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Exports\QueryExport;
use App\Exports\QuotationExport;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\Invoice;
use App\Models\PaymentType;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Quotation;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReportExport extends Controller
{


    public function exportQuery()
    {
        // Retrieve search parameters from the session


        if (\request()->routeIs('admin-query-export')){
            $searchTerm = Session::get('searchTerm');
            $dateFrom = Session::get('dateFrom');
            $dateTo = Session::get('dateTo');
            $status = Session::get('status_admin');
            $user = Session::get('user_admin');
        }else{
            $searchTerm = Session::get('search');
            $dateFrom = Session::get('date_form');
            $dateTo = Session::get('date_to');
            $status = Session::get('status');
            $user = Session::get('user');
        }

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
            ->get()
        ;

//        dd(Session::all());
//
//         Download the Excel file


        return Excel::download(new QueryExport($queries), 'Queries.xlsx');

//        dd($queries);
    }


    public function quotationExport(){

        $search = Session::get('search');
        $dateFrom = Session::get('date_form');
        $dateTo = Session::get('date_to');
        $byStatus = Session::get('by_status');
        $byUser = Session::get('by_user');


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
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!$search && !$byUser && !$byStatus && !$dateFrom && !$dateTo, function ($query) {
                // Handle default case if no filters are provided
                $query->orderByDesc('updated_at');
            })
            ->orderByDesc('created_at')
            ->get();


        return Excel::download(new QuotationExport($quotations),'quotation_report.xlsx');


    }

    public function invoiceExport(){

        $search = Session::get('search');
        $dateFrom = Session::get('date_form');
        $dateTo = Session::get('date_to');
        $status = Session::get('by_status');
        $user = Session::get('by_user');

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
            ->get();

        return Excel::download(new InvoiceExport($invoices),'invoice_report.xlsx');

    }


}
