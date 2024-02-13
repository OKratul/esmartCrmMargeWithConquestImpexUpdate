<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConquestExpenseController extends Controller
{
    public function expenses(){

        return view('expenses');

    }
}
