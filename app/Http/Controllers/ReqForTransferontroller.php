<?php

namespace App\Http\Controllers;

use App\Models\AssignReq;
use App\Models\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReqForTransferontroller extends Controller
{
    public function storeReq($query_id){

        $this->validate(\request(),[
            'req_user_id' => 'required',
        ]);

        AssignReq::create([
            'user_id' => Auth::user()->id,
            'query_id' => $query_id,
            'request_id' => \request('req_user_id'),
        ]);

        return redirect()->back()->with('success', 'your request has sent,wait for admin approval');

    }


    public function approveReq($query_id,$req_id,$id){

            Query::where('id',$query_id)->update([
                'user_id' => $req_id,
            ]);

            AssignReq::where('id',$id)->delete();

            return redirect()->back()->with('success','Query Transfer');
    }

    public function declineReq($id){

        AssignReq::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Transfer Request Declined');

    }


}
