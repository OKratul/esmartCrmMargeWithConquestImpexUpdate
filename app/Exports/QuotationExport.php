<?php

namespace App\Exports;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\View\View;

class QuotationExport implements FromView
{

    public $quotaitons;

    public function __construct($quotaitons)
    {
        $this->quotaitons= $quotaitons;
    }

    public function collection()
    {
        return $this->quotaitons;
    }

    /**
     *  @return \Illuminate\Contracts\View\View
    */

    public function view():View
    {

        $quotations = $this->quotaitons;

        return view('excel.quotationExport',compact('quotations'));
    }
}
