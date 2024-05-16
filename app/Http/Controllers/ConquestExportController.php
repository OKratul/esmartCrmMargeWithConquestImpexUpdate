<?php

namespace App\Http\Controllers;


use App\Exports\ConquestCustomerDataExport;
use App\Exports\ConquestInvoiceExport;
use App\Models\conquest\ConquestCustomer;
use App\Models\conquest\ConquestInvoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ConquestExportController extends Controller
{


    public function exportInvoice(){

        $invoices = ConquestInvoice::with('customers')->get()->all();

        return Excel::download(new ConquestInvoiceExport($invoices), 'conquest_invoices.xlsx');


//        dd($invoices);

    }

    public function exportCustomer(){

        $customers= ConquestCustomer::all();

        return Excel::download(new ConquestCustomerDataExport($customers),'customerData.xlsx');

    }



}
