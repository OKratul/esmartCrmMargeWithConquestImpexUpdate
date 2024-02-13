<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class UpdateInvoiceStatusController extends Controller
{

    public function updateInvoiceStatus()
    {
        $invoices = Invoice::with('payments')->get();

        foreach ($invoices as $invoice) {
            $products = json_decode($invoice->products, true);

            $totalInvoiceValue = 0;

            foreach ($products as $product) {
                if ($invoice->vat_tax == 10.5) {
                    $priceWithAit = floatval($product['unit_price']) + floatval($product['unit_price']) * 3 / 100;
                    $priceWithVat = $priceWithAit + $priceWithAit * 7.5 / 100;
                    $totalInvoiceValue += floatval($priceWithVat) * floatval($product['quantity']) + floor( $invoice->delivery_charge);
                } else {
                    $priceWithVat = floatval($product['unit_price']) + floatval($product['unit_price']) * floatval($invoice->vat_tax / 100);
                    $totalInvoiceValue += floatval($priceWithVat) * floatval($product['quantity']) + floatval($invoice->delivery_charge);
                }
            }

            // Calculate total payment using the sum method
            $totalPayment = $invoice->payments->sum('amount');

            if ($totalInvoiceValue <= $totalPayment) {
                $invoice->update([
                    'status' => 'Paid'
                ]);
            } else {
                $invoice->update([
                    'status' => 'Due',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

}
