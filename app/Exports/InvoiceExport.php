<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{
    /**
    *  @return \Illuminate\Contracts\View\View
    */
    public function view():View
    {
        $invoices = Invoice::with('customers')->orderByDesc('created_at')->get();

        return view('excel.invoiceExport',compact('invoices'));
    }
}
