<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\Query;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function customerQuery(){

        $validateData = Validator::make(\request()->all(),[
            'name' => 'required',
            'contact_name' => 'nullable',
            'phone_number' => 'required',
            'company_name' => 'nullable',
            'email' => 'required',
            'address' => 'nullable',
            'message' => 'nullable',
            'quantity' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_category' => 'nullable',
            'query_details' => 'nullable',
        ]);

        if ($validateData->fails()){
            return  response()->json([
                'status' => 'error',
                'errors' => $validateData->errors(),
            ]);
        }

        $customer = CustomerModel::where('phone_number',\request('phone_number'))->first();

        if (!empty($customer)){

            Query::create([
                'customer_id' => $customer['id'],
                'query_source' => 'WebSite',
                'status' => 'Pending',
                'query_details' => 'Contact to your client and ask for query details',
                'product_code' => \request('product_code'),
                'product_name' => \request('product_name'),
                'product_quantity' => \request('quantity'),
                'product_category' => \request('product_category'),
                'phone_number' => \request('phone_number'),
                'user_id' => null,
                'submit_date' => Carbon::now()->format('dM Y'),
             ]);

        }else{
            $customer = CustomerModel::create([
                'customer_type' => 'Individual',
                'contact_name' => \request('contact_name'),
                'name' => \request('name'),
                'email' => \request('email'),
                'phone_number' => \request('phone_number'),
                'address' => \request('address'),
            ]);

            Query::create([
                'customer_id' => $customer->id,
                'query_source' => 'WebSite',
                'status' => 'Pending',
                'query_details' => 'Contact to your client and ask for query details',
                'product_code' => \request('product_code'),
                'product_name' => \request('product_name'),
                'product_quantity' => \request('quantity'),
                'product_category' => \request('product_category'),
                'phone_number' => \request('phone_number'),
                'user_id' => null,
                'submit_date' => Carbon::now()->format('dM Y'),
            ]);

        }

        return response()->json([
            'status' => '200',
            'message' => 'data stored successfully'
        ]);

    }


}
