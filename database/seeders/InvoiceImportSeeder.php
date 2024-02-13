<?php

namespace Database\Seeders;

use App\Models\CustomerModel;
use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('max_execution_time', 300);
        $oldInvoices = DB::table('wpzg_csc_invoice')->get()->all();

        foreach ($oldInvoices as $oldInvoice) {


            $names = explode('+', $oldInvoice->Product_Name);
            $quantities = explode('+', $oldInvoice->Quantity);
            $productCodes = explode('+', floatval( $oldInvoice->Product_Code));
            $unitPrices = explode('+', $oldInvoice->Unit_Price);
            $units = explode('+', $oldInvoice->Unit);
            $arrayLength = count($names);
            $products = [];
            for ($i = 0; $i < $arrayLength; $i++) {
                $products[] = [
                    'product_name' => isset($names[$i]) ? $names[$i] : null,
                    'product_code' => isset($productCodes[$i]) ? $productCodes[$i] : null,
                    'quantity' => isset($quantities[$i]) ? $quantities[$i] : null,
                    'description' => null,
                    'unit_price' => isset($unitPrices[$i]) ? $unitPrices[$i] : null,
                    'unit' => isset($units[$i]) ? $units[$i] : null,
                    'our_coasting' => null,
                    'product_source' => null,
                    'product_discount' => null,
                ];
            }

            $customers = CustomerModel::all();

            foreach ($customers as $customer){

                if ($customer->phone_number == $oldInvoice->Phone){

                    Invoice::create([
                        'user_id' => 3,
                        'logo' => 'Esmart',
                        'phone_number' => $oldInvoice->Phone,
                        'customer_id' => $customer->id,
                        'invoice_no' => $oldInvoice->Invoice_Number,
                        'products' => json_encode($products),
                        'delivery_charge' => $oldInvoice->Delivery_Charge,
                        'discount_amount' => $oldInvoice->Discount,
                        'offer_validity' => null ,
                        'vat_tax' => null,
                        'delivery_term' => $oldInvoice->Delivery_Way,
                        'warranty' => $oldInvoice->Warranty,
                        'delivery_date' => $oldInvoice->Date,
                        'payment_type' => $oldInvoice->Payment_Method,
                        'other_condition' => null,
                        'created_by' => 'MD Shakil Ahmed',
                        'created_at' => $oldInvoice->Created,
                    ]);

                }

            }

        }
    }
}
