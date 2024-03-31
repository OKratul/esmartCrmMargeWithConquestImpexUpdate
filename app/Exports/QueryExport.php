<?php

namespace App\Exports;

use App\Models\Query;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class QueryExport implements FromView
{
    /**
     *  @return \Illuminate\Contracts\View\View
    */
    public function view():View
    {
        $queries = Query::with('customers')->orderByDesc('created_at')->get();

        return view('excel.queryExport',compact('queries'));

    }
}
