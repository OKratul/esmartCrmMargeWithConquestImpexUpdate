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
            $logoFileName = \request('name') . '_logo.' . $extension;
            $logo->move(public_path('images/pdf'), $logoFileName);
        }

        if (\request()->hasFile('seal')) {
            $seal = \request()->file('seal');
            $extension = $seal->getClientOriginalExtension();
            $sealFileName =  \request('name') . '_seal.' . $extension;
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

    public function editPdfSetup($id){

        $this->validate(\request(), [
            'name' => 'required',
            'address' => 'required',
            'hotline' => 'required',
            'email' => 'required|email',
            'website' => 'required|url',
            'designation' => 'required', // Remove trailing space
        ]);

        $pdfSet = PDFsetup::where('id',$id)->first();

        if (\request()->hasFile('logo')) {
            $logo = \request()->file('logo');
            $extension = $logo->getClientOriginalExtension();
            $number = rand(1,10000);
            $logoFileName = \request('name_') .$number.'_logo.' . $extension;
            $logo->move(public_path('images/pdf'), $logoFileName);
        }else{
                $logoFileName = $pdfSet['logo'];
        }

        if (\request()->hasFile('seal')) {
            $seal = \request()->file('seal');
            $extension = $seal->getClientOriginalExtension();
            $number = rand(1,10000);
            $sealFileName =  \request('name_') .$number.'_seal.' . $extension;
            $seal->move(public_path('images/pdf'), $sealFileName);
        }else{
            $sealFileName = $pdfSet['seal'];
        }

        $pdfSet->update([
            'name' => \request('name'),
            'address' => \request('address'),
            'hotline' => \request('hotline'),
            'email' => \request('email'),
            'website' => \request('website'),
            'designation' => \request('designation'),
            'logo' => $logoFileName,
            'seal' => $sealFileName,
        ]);

        return redirect()->back()->with('success', 'Pdf setup Updated');

    }

    public function deletePdfset($id){

        PDFsetup::where('id',$id)->delete();

        return redirect()->back()->with('success','Pdf set Deleted');

    }



}
