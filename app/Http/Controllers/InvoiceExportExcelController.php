<?php

namespace App\Http\Controllers;

use App\Exports\CompanyDataExport;
use App\Exports\InvoiceExport;
use App\Exports\QueryExport;
use App\Exports\QuotationExport;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceExportExcelController extends Controller
{

    public function invoiceExport(){

        return Excel::download(new InvoiceExport, 'Invoices.xlsx');

    }

    public function queryExport(){

        return Excel::download(new QueryExport, 'Queries.xlsx');

    }

    public function quotationExport(){

        return Excel::download(new QuotationExport,'quotations.xlsx');

    }

    public function companyData(){
        return Excel::download(new CompanyDataExport,'companyInfo.xlsx');
    }

}
