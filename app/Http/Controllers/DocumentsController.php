<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index(){

        $documents = Document::latest('created_at')->paginate(25);

        return view('documents',compact('documents'));
    }

    public function uploadFile()
    {
        $this->validate(\request(), [
            'file_name' => 'required',
            'file' => 'required|file|mimes:docx,doc,jpg,jpeg,png,pdf,zip,txt',
        ]);

        $file = \request()->file('file');
        $fileExt = $file->getClientOriginalExtension();
        $fileName = \request('file_name') . '_' . now()->format('Y-m-d_H-i-s') . '.' . $fileExt;
        $file->move('upload', $fileName);

        $fileLink = asset('upload/' . $fileName);

        Document::create([
            'note' => \request('file_name'),
            'file_name' => $fileLink,
        ]);

        return redirect()->back()->with('success', 'File Uploaded');
    }


    public function deleteDocument($id)
    {
        // Get the document record from the database
        $document = Document::find($id);

        if ($document) {
            // Extract the file name from the URL
            $fileName = pathinfo(parse_url($document->file_name, PHP_URL_PATH), PATHINFO_BASENAME);

            // Delete the file from the public directory
            $filePath = public_path('upload/' . $fileName);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the record from the database
            $document->delete();

            // Optionally, you can also return a success message
            return redirect()->back()->with('success', 'Document deleted successfully.');
        } else {
            // Optionally, you can return an error message if the document is not found
            return redirect()->back()->with('error', 'Document not found.');
        }
    }


    public function downloadDocument($id)
    {
        // Get the document record from the database
        $document = Document::find($id);

        if ($document) {
            // Extract the file name from the URL
            $fileName = pathinfo(parse_url($document->file_name, PHP_URL_PATH), PATHINFO_BASENAME);

            // Get the full path to the file in the public directory
            $filePath = public_path('upload/' . $fileName);

            // Check if the file exists
            if (file_exists($filePath)) {
                // Return the file as a download response
                return response()->download($filePath, $document->note . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
            } else {
                // File not found, return back with an error message
                return redirect()->back()->with('error', 'File not found.');
            }
        } else {
            // Document not found, return back with an error message
            return redirect()->back()->with('error', 'Document not found.');
        }
    }


}
