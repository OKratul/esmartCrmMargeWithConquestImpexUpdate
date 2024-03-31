<?php

namespace App\Exports;

use App\Models\CustomerModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;


class CompanyDataExport implements FromView
{
    /**
    * @return \Illuminate\Contracts\View\View
    */
    public function view():View
    {
        $oldDatas = CustomerModel::where('customer_type','company')->get();

        return view('excel.companyData',compact('oldDatas'));

    }
}
