<?php

namespace App\Exports;

use App\Models\Query;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class QueryExport implements FromView
{
    public $queries;

    public function __construct($queries)
    {
        $this->queries = $queries;
    }

    public function collection()
    {
        return $this->queries;
    }

    /**
     *  @return \Illuminate\Contracts\View\View
    */
    public function view():View
    {
        $queries = $this->queries;
        return view('excel.queryExport',compact('queries'));
    }
}
