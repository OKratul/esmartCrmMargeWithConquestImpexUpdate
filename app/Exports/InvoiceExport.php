<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{

    public $invoices;

    public function __construct($invoices)
    {
        $this->invoices= $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }
    /**
    *  @return \Illuminate\Contracts\View\View
    */
    public function view():View
    {
        $invoices = $this->invoices;

        return view('excel.invoiceExport',compact('invoices'));
    }
}
