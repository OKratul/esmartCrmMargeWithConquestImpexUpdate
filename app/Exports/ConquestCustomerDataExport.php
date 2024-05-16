<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;

class ConquestCustomerDataExport implements FromCollection
{
    public $customers;

    /**
     *  @return \Illuminate\Contracts\View\View
    */
    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function collection()
    {
        return $this->customers;
    }


    public function view():View
    {
        $customers = $this->customers;

        return view('excel.conquest.conquestCustomerExport',compact('customers'));
    }


}
