<?php

namespace Database\Seeders;

use App\Models\CustomerModel;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotationImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('max_execution_time', 460);
        ini_set('memory_limit', '1000M');

        $oldData = 'old data';
        $customers = CustomerModel::where('customer_type', $oldData)->get()->all();

        foreach ($customers as $customer) {
            $quotationDatas = DB::table('wpzg_csc_quotation')->where('Phone', $customer->phone_number)->get()->all();

            foreach ($quotationDatas as $quotationData) {
                $users = User::all();

                $names = explode('+', $quotationData->Product_Name);
                $quantity = preg_split("/[,+\-]/", $quotationData->Quantity);
                $quantities = array_map('trim', $quantity);
                $productCodes = explode('+', $quotationData->Product_Code);
                $unitPrices = explode('+', $quotationData->Unit_Price);
                $units = explode('+', $quotationData->Unit);
                $descriptions = explode(',', $quotationData->Description);
                $arrayLength = count($names);

                for ($i = 0; $i < $arrayLength; $i++) {
                    $products[] = [
                        'product_name' => isset($names[$i]) ? $names[$i] : null,
                        'product_code' => isset($productCodes[$i]) ? $productCodes[$i] : null,
                        'quantity' => isset($quantities[$i]) ? $quantities[$i] : null,
                        'description' => isset($descriptions[$i]) ? $descriptions[$i] : null,
                        'unit_price' => isset($unitPrices[$i]) ? $unitPrices[$i] : null,
                        'unit' => isset($units[$i]) ? $units[$i] : null,
                        'our_coasting' => null,
                        'product_source' => null,
                        'product_discount' => null,
                    ];
                }

                foreach ($users as $user) {
                    if ($customer->phone_number == $quotationData->Phone && $user->name == $quotationData->Submitted_By) {
                        $quotationAttributes = [
                            'customer_id' => $customer->id,
                            'logo' => 'Esmart',
                            'user_id' => $user->id,
                            'products' => json_encode($products),
                            'offer_validity' => null,
                            'warranty' => $quotationData->Warranty,
                            'payment_type' => $quotationData->Payment_Method,
                            'vat_tax' => ($quotationData->Tax == 'Exclude') ? null : $quotationData->Tax,
                            'delivery_term' => $quotationData->Delivery_Terms,
                            'other_condition' => $quotationData->Other_Condition,
                            'delivery_date' => now()->format('Y-m-d'),
                            'delivery_charge' => $quotationData->Delivery_Charge,
                            'discount_amount' => $quotationData->Discount,
                            'extra_charge_name' => $quotationData->Extra_Name,
                            'extra_amount' => $quotationData->Extra_Price,
                            'quotation_number' => $quotationData->Quotation_Number,
                            'phone_number' => $quotationData->Phone,
                            'status' => $quotationData->Status,
                            'created_at' =>$quotationData->Created ,
                        ];

                        Quotation::create($quotationAttributes);
                    }
                }

                // Reset the $products array for the next iteration
                $products = [];
            }
        }
    }
}
