<?php

namespace Database\Seeders;

use App\Models\CustomerModel;
use App\Models\Query;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueryImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('max_execution_time', 360);

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
                        ]);
                    }
                }
            }

        }
    }
}
