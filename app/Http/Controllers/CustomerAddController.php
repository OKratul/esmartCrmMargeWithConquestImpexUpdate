<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class CustomerAddController extends Controller
{
        public function index(){

            if (\request()->routeIs('user-addCustomer')){
                return view('user.addCustomers');
            }else{
                return view('addCustomer');
            }
        }

        public function addCustomer(){

            $this->validate(\request(),[
                'type' => 'required',
                'name'=> 'required',
                'contact_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' =>'required',
                'city' => 'required',
                'country'=>'required',
                'postal_code'=> 'required',
            ]);

            CustomerModel::create([
                'customer_type' => \request('type'),
                'name' => \request('name'),
                'contact_name' => \request('contact_name'),
                'email' => \request('email'),
                'phone_number'=> \request('phone'),
                'address' => \request('address'),
                'city' => \request('city'),
                'country' => \request('country'),
                'postal_code' => \request('postal_code'),
            ]);

           $customers =  CustomerModel::all()->last();

           $id = $customers['id'];

            if (\request()->routeIs('user-addCustomer-done')){
                return to_route('user-customer-profile',[$id])->with('success', 'Profile Added Successfully');
            }else{
                return to_route('customer-profile',[$id])->with('success', 'Profile Added Successfully');
            }
        }

}
