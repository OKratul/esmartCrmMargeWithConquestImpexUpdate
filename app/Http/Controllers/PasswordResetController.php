<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function passwordReset() {

        $this->validate(request(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed', // Make sure password and password_confirmation fields match
        ]);

        $user = Auth::user();

        if (Hash::check(request('old_password'), $user->password)) {
            $user->update([
                'password' => Hash::make(request('password')),
            ]);

            return redirect()->back()->with('success', 'Password Reset Successfully');
        }

        return redirect()->back()->withErrors(['old_password' => 'Incorrect old password']);
    }

}
