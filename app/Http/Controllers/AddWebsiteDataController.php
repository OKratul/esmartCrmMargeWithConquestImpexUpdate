<?php

namespace App\Http\Controllers;

use App\Models\WebApiData;
use Illuminate\Http\Request;
use Automattic\WooCommerce\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AddWebsiteDataController extends Controller
{
    public function viewForm()
    {
        $websites = WebApiData::all();
        return view('admin.addWebsiteData', compact('websites'));
    }


    public function addSiteData(){

       $this->validate(\request(),[
            'domain'=>'required',
            'consumer_key'=>'required',
            'consumer_secret'=>'required',
        ]);

        WebApiData::create([
            'web_domain'=> \request('domain'),
            'consumer_key'=>\request('consumer_key'),
            'consumer_secret' => \request('consumer_secret'),
        ]);

        return redirect()->back()->with('success','Api added Successfully');
    }



}
