<?php

namespace App\Http\Controllers;

use App\Models\Query;
use Illuminate\Http\Request;

class QueryStatusChange extends Controller
{
    public function processing($query_id){

        Query::where('id',$query_id)->update([
            'status' => 'Processing'
        ]);

        return redirect()->back()->with('success','Status Has Changed To Processing');
    }

    public function quotationSent($query_id){
        Query::where('id',$query_id)->update([
            'status' => 'Quotation Sent'
        ]);

        return redirect()->back()->with('success','Status Has Changed To Quotation Sent');
    }

    public function orderConfirmed($query_id) {

        Query::where('id',$query_id)->update([
            'status' => 'Order Confirmed'
        ]);

        return redirect()->back()->with('success','Status Has Changed To Order Confirmed');
    }
    public function deliveryOnGoing($query_id) {

        Query::where('id',$query_id)->update([
            'status' => 'Delivery On Going'
        ]);

        return redirect()->back()->with('success','Status Has Changed To Delivery On Going');
    }

    public function delivered($query_id) {

        Query::where('id',$query_id)->update([
            'status' => 'Delivered'
        ]);

        return redirect()->back()->with('success','Status Has Changed To Delivered');
    }
    public function closed($query_id) {

        Query::where('id',$query_id)->update([
            'status' => 'Closed'
        ]);

        return redirect()->back()->with('success','Status Has Changed To Closed');
    }


}
