<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\Invoice;
use App\Models\Query;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MakeUserFromOldDatabase extends Controller
{
    public function makeCustomersFromOldDatabase(){

        ini_set('max_execution_time', 220);

        $oldQueries = DB::table('wpzg_csc_query')->get()->all();

        foreach ($oldQueries as $oldQuery){
            $existingCustomer = CustomerModel::where('phone_number', $oldQuery->Phone)
                ->orWhere('email', $oldQuery->Email)
                ->first();

            if ($existingCustomer) {
                continue; // Skip this iteration and move to the next one
            }

            // Create a new customer if no matching records found
            CustomerModel::create([
                'customer_type' => 'old data',
                'name' => $oldQuery->Customer_Name,
                'contact_name' => $oldQuery->Customer_Name,
                'email' => $oldQuery->Email,
                'phone_number' => $oldQuery->Phone,
                'address' => $oldQuery->Address,
                'city' => null,
                'postal_code' => null,
                'country' => null,
            ]);
        }

        return redirect()->back();

    }

    public function importQuery(){

        ini_set('max_execution_time', 400);

        $oldData = 'old data';
        $customers = CustomerModel::where('customer_type', $oldData)->get();

        foreach ($customers as $customer) {
            $queries = DB::table('wpzg_csc_query')->where('Phone', $customer->phone_number)->get()->all();

            foreach ($queries as $query){
                if ($query && isset($query->Phone) && $customer->phone_number == $query->Phone) {
                    if ($query->Reminder_Date == '0000-00-00') {
                        Query::create([
                            'customer_id' => $customer->id,
                            'query_source' => $query->Taken_From,
                            'status' => $query->Status,
                            'query_details' => $query->Message,
                            'product_sku' => '0000',
                            'product_name' => $query->Message,
                            'product_quantity' => 0,
                            'product_category' => $query->Product_Cat,
                            'unit' => null,
                            'submit_date' => $query->Date,
                            'phone_number' => $query->Phone,
                            'reminder_date' => null,
                            'created_at' => $query->Created,
                        ]);
                    } else {
                        Query::create([
                            'customer_id' => $customer->id,
                            'query_source' => $query->Taken_From,
                            'status' => $query->Status,
                            'query_details' => $query->Message,
                            'product_sku' => '0000',
                            'product_name' => $query->Message,
                            'product_quantity' => 0,
                            'product_category' => $query->Product_Cat,
                            'unit' => null,
                            'submit_date' => $query->Date,
                            "phone_number" => $query->Phone,
                            'reminder_date' => $query->Reminder_Date,
                            'created_at' => $query->Created,
                        ]);
                    }
                }
            }

        }

// dd($queries->Phone);
        return redirect()->back();

    }

    public function importQuotation(){

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

        return redirect('user-login');

    }

    public function updateQueryToQuotation(){

        $queries = Query::all();
        $quotations = Quotation::all();

        foreach ($queries as $query){
            Quotation::where('phone_number',$query->phone_number)->update([
                'query_id' => null,
            ]);


        }
        return redirect()->back();
    }

    public function queryUserIdUpdate(){

        ini_set('max_execution_time', '300');

        $queries = Query::with('customers')->get(); // Remove the unnecessary `->all()`
        $customers = CustomerModel::all();

        foreach ($queries as $query) {
            $quotations = Quotation::where('customer_id', $query->customers['id'])->get(); // Remove the unnecessary `->all()`

            foreach ($quotations as $quotation) {
                $query->update([
                    'user_id' => $quotation->user_id,
                ]);
            }
        }

        return redirect()->back();

    }


  public function importInvoice()
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
      return redirect()->back();
  }

  public function deleteInvoice(){

        Invoice::where('other_condition',null)->delete();

        return redirect()->back();

  }

    public function deleteAllquery(){

        Query::where('product_sku',0000)->delete();

        return redirect()->back();
    }

    public function deleteQuotation(){
        ini_set('max_execution_time', 360);

        Quotation::where('query_id',null)->delete();

        return redirect()->back();
    }

    public function updateNullQuery(){
        $queries = Query::where('user_id', null)->update([
            'user_id' => 3,
        ]);

        return redirect()->back();
    }

    public function updateOldQuot(){

      $countQuotation =   Quotation::where('extra_charge_name', 'VAT 7.5%')->update([
          'vat_tax' => '7.5',
      ]);


//      dd(count($countQuotation));
        return redirect()->back();

    }

    public function updateCreated()
    {
        $oldQueries = DB::table('wpzg_csc_query')->get();

        foreach ($oldQueries as $oldQuery) {
            Query::where('product_link', null)
                ->update([
                    'created_at' => $oldQuery->Created,
                ]);
        }

        return redirect()->back();
    }

    public function updateQuotationLogo(){

        Quotation::where('logo', null)->update([
            'logo'=> 'Esmart',
        ]);

    }


}
