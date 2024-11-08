<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestCustomer;
use App\Models\conquest\ConquestInvoice;
use App\Models\conquest\ConquestPayment;
use App\Models\conquest\ConquestProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class ConquestInvoiceController extends Controller
{
    public function allInvoice(){

        $search = \request('search');

        $invoices = ConquestInvoice::with('customers')
            ->where(function ($query) use ($search) {
                $query->whereHas('customers', function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('email2', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->orWhere('product_id', 'like', '%' . $search . '%')
            ->orWhere('invoice_number', 'like', '%' . $search . '%')
            ->orderByDesc('created_at')
            ->paginate(10);

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
            'paid_amount' => 'nullable',
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

    public function editInvoice($id)
    {
        $this->validate(request(), [
            'customer' => 'required',
            'product_name' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
            'paid_amount' => 'nullable',
        ]);

        $newProductNames = request('product_name');
        $newQuantities = request('quantity');
        $newUnitPrices = request('unit_price');

        $totalPrices = [];

        $invoice = ConquestInvoice::where('id', $id)->first();
        $originalProductNames = explode('+', $invoice['product_id']);
        $originalQuantities = explode('+', $invoice['quantity']);

        // Restore original stock quantities
        foreach ($originalProductNames as $index => $originalProductName) {
            $originalQuantity = $originalQuantities[$index];
            $product = ConquestProduct::where('product_code', $originalProductName)->first();
            $product->update([
                'quantity' => $product['quantity'] + $originalQuantity,
            ]);
        }

        // Calculate new total prices and update stock quantities
        foreach ($newProductNames as $index => $newProductName) {
            $newQuantity = $newQuantities[$index];
            $newUnitPrice = $newUnitPrices[$index];

            $totalPrice = $newQuantity * $newUnitPrice;
            $totalPrices[$newProductName] = $totalPrice;

            $product = ConquestProduct::where('product_code', $newProductName)->first();
            $product->update([
                'quantity' => $product['quantity'] - $newQuantity,
            ]);
        }

        $formattedTotalPrices = implode('+', $totalPrices);
        $totalSum = array_sum($totalPrices);

        $productName = implode('+', $newProductNames);
        $quantity = implode('+', $newQuantities);
        $unitPrice = implode('+', $newUnitPrices);

        $due = $totalSum - request('paid_amount');
        $date = request('date');

        ConquestInvoice::where('id', $id)->update([
            'invoice_number' => $invoice['invoice_number'],
            'customer_id' => request('customer'),
            'product_id' => $productName,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $formattedTotalPrices,
            'all_total_price' => $totalSum,
            'delivery_charge' => request('delivery_charge'),
            'paid' => request('paid_amount'),
            'due' => $due,
            'status' => 'not sent',
            'discount' => request('discount_amount'),
            'date' => $date,
        ]);

        return redirect()->back()->with('success', 'Invoice Updated Successfully');
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

            $imagePath = public_path('Asset 1Impex Logo.png');
            $imageData = file_get_contents($imagePath);
            $logo = 'data:image/png;base64,' . base64_encode($imageData);

            $contant = view('conquest/pdf/invoice', compact('invoice','logo'))->render();

            // Write HTML content to the PDF
            $pdf->WriteHTML($contant);
//            $invoiceDate = $invoice['date']->format('d M Y');

            // Output the PDF as a string
            $pdfContent = $pdf->Output($invoiceName, 'S');

            // Return the response with PDF content and headers
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $invoiceName . '"',
            ]);
//        dd($invoice);


    }


    public function challan($id){

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
        $invoiceName = 'Challan'.'.pdf';

        $imagePath = public_path('Asset 1Impex Logo.png');
        $imageData = file_get_contents($imagePath);
        $logo = 'data:image/png;base64,' . base64_encode($imageData);

        $contant = view('conquest/pdf/challan', compact('invoice','logo'))->render();

        // Write HTML content to the PDF
        $pdf->WriteHTML($contant);
//            $invoiceDate = $invoice['date']->format('d M Y');

        // Output the PDF as a string
        $pdfContent = $pdf->Output($invoiceName, 'S');

        // Return the response with PDF content and headers
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $invoiceName . '"',
        ]);

    }


    public function moneyReceipt($id){
        $invoice = ConquestPayment::where('id',$id)->with('customers')->first();

        $pdf = new Mpdf([
            'format' => 'A4',
        ]);

        $invoiceName = 'Challan'.'.pdf';

        $imagePath = public_path('Asset 1Impex Logo.png');
        $imageData = file_get_contents($imagePath);
        $logo = 'data:image/png;base64,' . base64_encode($imageData);

        $contant = view('conquest/pdf/moneyReceipt', compact('invoice','logo'))->render();


        $pdf->WriteHTML($contant);
//            $invoiceDate = $invoice['date']->format('d M Y');

        // Output the PDF as a string
        $pdfContent = $pdf->Output($invoiceName, 'S');

        // Return the response with PDF content and headers
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $invoiceName . '"',
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
                'due' => '00',
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
