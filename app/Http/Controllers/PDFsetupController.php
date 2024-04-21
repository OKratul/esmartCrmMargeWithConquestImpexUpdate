<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PDFsetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class PDFsetupController extends Controller
{
    public function pdfSetup()
    {
        $this->validate(\request(), [
            'name' => 'required',
            'logo' => 'required|image',
            'address' => 'required',
            'hotline' => 'required',
            'email' => 'required|email',
            'website' => 'required|url',
            'seal' => 'required|image',
            'designation' => 'required', // Remove trailing space
        ]);

// Move uploaded files to the destination directory
        $logoFileName = null;
        $sealFileName = null;

        if (\request()->hasFile('logo')) {
            $logo = \request()->file('logo');
            $extension = $logo->getClientOriginalExtension();
            $logoFileName = asset('images/pdf/'.\request('name') . '_logo.' . $extension);
            $logo->move(public_path('images/pdf'), $logoFileName);
        }

        if (\request()->hasFile('seal')) {
            $seal = \request()->file('seal');
            $extension = $seal->getClientOriginalExtension();
            $sealFileName = asset('images/pdf/'. \request('name') . '_seal.' . $extension);
            $seal->move(public_path('images/pdf'), $sealFileName);
        }

        PDFsetup::create([
            'name' => \request('name'),
            'logo' => $logoFileName,
            'address' => \request('address'),
            'hotline' => \request('hotline'),
            'email' => \request('email'),
            'website' => \request('website'),
            'designation' => \request('designation'),
            'seal' => $sealFileName,
        ]);

        return redirect()->back()->with('success', 'Pdf Setup updated');

//    dd($logoFileName);
    }


}
