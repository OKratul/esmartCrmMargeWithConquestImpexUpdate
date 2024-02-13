<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumbersController extends Controller
{

    public function index(){

        $search = \request('search');

        if ($search){
            $phoneNumbers = PhoneNumber::where('name','like',"%{$search}%")
                                            ->orWhere('number','like',"%{$search}%")
                                            ->orWhere('gmail','like',"%{$search}%")
                                            ->paginate(15);
        }else{
            $phoneNumbers = PhoneNumber::paginate(15);
        }

        return view('phoneNumber',compact('phoneNumbers'));

    }

    public function addPhoneNumber(){

        $this->validate(\request(),[
            'name' => 'required',
            'email' => 'nullable|email',
            'phone_number' => 'required',
            'note' => 'nullable|max:600',
        ]);

        PhoneNumber::create([
            'name' => \request('name'),
            'gmail' => \request('email'),
            'number' => \request('phone_number'),
            'notes' => \request('note'),
        ]);

        return redirect()->back()->with('success','Contact Added SuccessFully');

    }

}
