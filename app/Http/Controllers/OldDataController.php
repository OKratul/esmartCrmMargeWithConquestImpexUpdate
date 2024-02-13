<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OldDataController extends Controller
{
        public function oldQuery(){

            $search = \request('search');
            $date = \request('date');

            if ($search){
                $queries =  DB::table('wpzg_csc_query')
                    ->where('Phone','like', "%{$search}%")
                    ->orWhere('Product_Cat','like', "%{$search}%")
                    ->orWhere('Email','like',"%{$search}%")
                    ->orWhere('Customer_Name','like',"%{$search}%")
                    ->orderByDesc('date')
                    ->paginate(100);
            }elseif ($date){
                $queries = DB::table('wpzg_csc_query')
                    ->where('date','like', "%{$date}%")
                    ->orderByDesc('date')
                    ->paginate(10);
            }
            else{
                $queries = DB::table('wpzg_csc_query')
                    ->orderByDesc('date')
                    ->paginate(10);
            }

            $totalResult = $queries->total();
//            dd($queries);
            return view('allOldQueryData',compact('queries','totalResult'));
        }


        public function oldQuotation(){

                $search = \request('search');
                $date = \request('date');

                if ($search){
                    $quotations = DB::table('wpzg_csc_quotation')
                                    ->where('Quotation_Number','like',"%{$search}%")
                                    ->orWhere('Phone','like',"%{$search}%")
                                    ->orWhere('Email','like',"%{$search}%")
                                    ->orWhere('Customer_Name','like',"%{$search}%")
                                    ->orderByDesc('Created')
                                    ->paginate(100);
                }elseif($date){
                    $quotations = DB::table('wpzg_csc_quotation')
                                    ->where('Created' , 'like' ,"%{$date}%")
                                    ->paginate(100);
                }
                else{
                    $quotations = DB::table('wpzg_csc_quotation')
                                    ->orderByDesc('Created')
                                    ->paginate(10);
                }

                $totalQuotations = $quotations->total();

                return view('user.allOldQuotationData',compact('quotations','totalQuotations'));

        }

        public function oldInvoice(){

            $search = \request('search');
            $date = \request('date');

            if ($search){
                $invoices = DB::table('wpzg_csc_invoice')
                            ->where('Invoice_Number', 'like' , "%{$search}%")
                            ->orWhere('Customer_Name','like' ,"%{$search}%")
                            ->orWhere('Phone','like' ,"%{$search}%")
                            ->orWhere('Email','like' ,"%{$search}%")
                            ->orderByDesc('Date')
                            ->paginate(100);
            }elseif ($date){
                $invoices = DB::table('wpzg_csc_invoice')
                    ->where('Created', 'like' , "%{$date}%")
                    ->orderByDesc('Date')
                    ->paginate(100);
            }else{
                $invoices = DB::table('wpzg_csc_invoice')
                    ->orderByDesc('Date')
                    ->paginate(10);
            }

            $totalInvoice = $invoices->total();
            return view('user.allOldInvoiceData', compact('invoices','totalInvoice'));

        }

}
