<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ConquestInvoiceExport implements FromView
{

    public $invoices;

    /**
     *  @return \Illuminate\Contracts\View\View
    */

    public function __construct($invoices)
    {
        $this->invoices= $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }


    public function view():View
    {
        $invoices = $this->invoices;

        return view('excel.conquest.conquestInvoiceExport',compact('invoices'));
    }
}
