<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestTransection;
use Illuminate\Http\Request;

class ConquestTransectionController extends Controller
{
    public function trancestions($id){

        $transections = ConquestTransection::where('account_id', $id)->with('accounts','invoices')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('conquest.transections', compact('transections'));
    }}
