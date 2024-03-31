<?php

namespace App\Exports;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\View\View;

class QuotationExport implements FromView
{
    /**
     *  @return \Illuminate\Contracts\View\View
    */
    public function view():View
    {
        $quotations = Quotation::with('customers')->orderByDesc('created_at')->get();

        return view('excel.quotationExport',compact('quotations'));
    }
}
