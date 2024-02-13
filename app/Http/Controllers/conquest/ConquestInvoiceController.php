<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestCustomer;
use App\Models\conquest\ConquestInvoice;
use App\Models\conquest\ConquestProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class ConquestInvoiceController extends Controller
{
    public function allInvoice(){
        $invoices = ConquestInvoice::with('customers')->orderByDesc('created_at')->paginate(10);

        $customers = ConquestCustomer::all();
        $products = ConquestProduct::all();

//
//        foreach ($invoices as $invoice ){
//
//            $product_codes = $invoice->product_code->toArray();
//
////            $products = Product::where('product_code',)
//
//        }

        return view('conquest.allInvoice',compact('invoices','customers','products'));
//        dd($invoices);
    }


    public function makeInvoice(){

        $this->validate(\request(),[
            'customer' => 'required',
            'product_name'=> 'required',
            'quantity'=> 'required',
            'unit_price'=> 'required',
            'paid_amount' => 'required',
        ]);

        $productNames = \request('product_name');
        $quantity = \request('quantity');
        $unitPrice =\request('unit_price');


        $totalPrices = [];

        foreach ($productNames as $index => $productName) {
            // Assuming $quantity and $unitPrice are arrays with the same indexes as $productNames
            $quantityValue = $quantity[$index];
            $unitPriceValue = $unitPrice[$index];

            // Calculate total price for the current product
            $totalPrice = $quantityValue * $unitPriceValue;

            // Store the total price in an array
            $totalPrices[$productName] = $totalPrice;

            $product = ConquestProduct::where('product_code',$productName)->first();

            $stockQty = $product['quantity'] - $quantityValue;

            $product->update([
                'quantity' => $stockQty,
            ]);

        }

        $formattedTotalPrices = implode('+', $totalPrices);
        $totalSum = array_sum($totalPrices);


        $productName = implode('+', $productNames);
        $quantity = implode('+', $quantity);
        $unitPrice = implode('+',$unitPrice);

        $date = \request('date');

        $due = $totalSum - \request('paid_amount');

        $invoiceNo = mt_rand(1000000000, 9999999999);

        ConquestInvoice::create([
            'invoice_number' => $invoiceNo,
            'customer_id' => \request('customer'),
            'product_id' => $productName,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $formattedTotalPrices,
            'all_total_price'=> $totalSum,
            'delivery_charge' => \request('delivery_charge'),
            'paid' => \request('paid_amount'),
            'due' => $due,
            'status' => 'not sent',
            'discount'=> \request('discount_amount'),
            'date' =>  $date,
        ]);


        return redirect()->back()->with('success','Invoice Updated');


//        dd($due);

    }

    public function editInvoice($id){

        $this->validate(\request(),[
            'customer' => 'required',
            'product_name'=> 'required',
            'quantity'=> 'required',
            'unit_price'=> 'required',
            'paid_amount' => 'required',
        ]);

        $productNames = \request('product_name');
        $quantity = \request('quantity');
        $unitPrice =\request('unit_price');


        $totalPrices = [];

        foreach ($productNames as $index => $productName) {
            // Assuming $quantity and $unitPrice are arrays with the same indexes as $productNames
            $quantityValue = $quantity[$index];
            $unitPriceValue = $unitPrice[$index];

            // Calculate total price for the current product
            $totalPrice = $quantityValue * $unitPriceValue;

            // Store the total price in an array
            $totalPrices[$productName] = $totalPrice;

            $product = ConquestProduct::where('product_code',$productName)->first();

            $stockQty = $product['quantity'] - $quantityValue;

            $product->update([
                'quantity' => $stockQty,
            ]);

        }

        $formattedTotalPrices = implode('+', $totalPrices);
        $totalSum = array_sum($totalPrices);

        $productName = implode('+', $productNames);
        $quantity = implode('+', $quantity);
        $unitPrice = implode('+',$unitPrice);

        $due = $totalSum - \request('paid_amount');
        $date = \request('date');

        $invoice = ConquestInvoice::where('id',$id)->first();

        ConquestInvoice::where('id',$id)->update([
            'invoice_number' => $invoice['invoice_number'],
            'customer_id' => \request('customer'),
            'product_id' => $productName,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $formattedTotalPrices,
            'all_total_price'=> $totalSum,
            'delivery_charge' => \request('delivery_charge'),
            'paid' => \request('paid_amount'),
            'due' => $due,
            'status' => 'not sent',
            'discount'=> \request('discount_amount'),
            'date' =>  $date,
        ]);

        return redirect()->back()->with('success','Invoice Update Successfully');
    }


    public function viewInvoice($id)
    {
        $invoice = ConquestInvoice::where('id', $id)
            ->with('customers')
            ->first();

        if (!$invoice) {
            // Handle the case when the invoice is not found
            // For example, return an error message or redirect to another page
            return "Invoice not found";
        }

            // Create a new Mpdf instance
            $pdf = new Mpdf([
                'format' => 'A4',
            ]);

            // Set the name for the PDF file
            $invoiceName = 'Invoice_'.'.pdf';

            $imagePath = public_path('bjhgj.png');
            $imageData = file_get_contents($imagePath);
            $logo = 'data:image/png;base64,' . base64_encode($imageData);

            $contant = view('conquest/pdf/invoice', compact('invoice','logo'))->render();

            // Write HTML content to the PDF
            $pdf->WriteHTML($contant);

            // Output the PDF as a string
            $pdfContent = $pdf->Output($invoiceName, 'S');

            // Return the response with PDF content and headers
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $invoiceName . '"',
            ]);


    }


    public function challan($id){

        $invoice = ConquestInvoice::where('id', $id)->first();
        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');

        $imagePath = public_path('assets/Logo2-02.png');
        $imageData = file_get_contents($imagePath);
        $logo = 'data:image/png;base64,' . base64_encode($imageData);

        $dompdf = new Dompdf($pdfOptions);

        $html = view('pdf.challan', compact('logo', 'invoice'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setBasePath(public_path());

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();


        $pdfContent = $dompdf->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }


    public function deleteInvoice($id){

        ConquestInvoice::where('id',$id)->delete();

        return redirect()->back()->with('success','Invoice Deleted Successfully');

    }



    public function addInvoiceFromOldData(){
        $invoices = DB::table('wpdf_ism_invoice')->get();

        foreach ($invoices as $invoice){

            ConquestInvoice::create([
                'invoice_number' => $invoice->Invoice_Number,
                'customer_id' => $invoice->Customer_ID,
                'product_id' => $invoice->Product_ID,
                'quantity' => $invoice->Quantity,
                'unit_price' => $invoice->Unit_Price,
                'total_price' => $invoice->Total_Price,
                'all_total_price' => $invoice->All_Total_Price,
                'delivery_charge' => $invoice->Delivery_Charge,
                'paid' => $invoice->Paid,
                'warranty' => $invoice->Warranty,
                'discount' => $invoice->Discount,
                'extra_name' => $invoice->Extra_Name,
                'extra_price' => $invoice->Extra_Price,
                'date' => $invoice->Date,
                'status' => $invoice->Status,

            ]);

        }
        return redirect()->back();

    }
}
