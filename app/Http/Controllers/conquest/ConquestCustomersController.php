<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestCustomer;
use Illuminate\Http\Request;

class ConquestCustomersController extends Controller
{
    public function allCustomers(){

        $search = \request('search');

        if (!empty($search)) {
            $customers = ConquestCustomer::where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('email2', 'like', '%' . $search . '%')
                ->orWhere('contact_person', 'like', '%' . $search . '%')
                ->orWhere('contact_person_number', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->paginate(10);
        } else {
            $customers = ConquestCustomer::orderByDesc('created_at')->paginate(10);
        }
//        dd($customers);
        return view('conquest.allCustomers',compact('customers'));
    }

    public function addCustomer(){

        $this->validate(\request(),[
            'name' => 'required',
            'phone_number' => 'required',
            'email-1' => 'required|email',
            'email-2' => 'nullable|email',
            'address' => 'required',
            'contact_person' => 'nullable',
            'contact_person_number' => 'nullable',
        ]);

        ConquestCustomer::create([
            'name' => \request('name'),
            'phone' => \request('phone_number'),
            'email' => \request('email-1'),
            'email2' => \request('email-2'),
            'address' => \request('address'),
            'contact_person' => \request('contact_person'),
            'contact_person_number' => \request('contact_person_number'),
        ]);

        return redirect()->back()->with('success','Customer Created Successfully');

    }

    public function updateInfo($id){
        $this->validate(\request(),[
            'name' => 'required',
            'phone_number' => 'required',
            'email-1' => 'required|email',
            'email-2' => 'nullable|email',
            'address' => 'required',
            'contact_person' => 'nullable',
            'contact_person_number' => 'nullable',
        ]);

        ConquestCustomer::where('id',$id)->update([
            'name' => \request('name'),
            'phone' => \request('phone_number'),
            'email' => \request('email-1'),
            'email2' => \request('email-2'),
            'address' => \request('address'),
            'contact_person' => \request('contact_person'),
            'contact_person_number' => \request('contact_person_number'),
        ]);

        return redirect()->back()->with('success','Customer Info Updated');
    }

    public function deleteCustomer($id){

        ConquestCustomer::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Customer Info Deleted');

    }

    public function customerProfile($id){

        $customer = ConquestCustomer::where('id',$id)->with('invoices','payments')->first();

        return view('conquest.customerProfile',compact('customer'));

//        dd($customer);
    }
}
