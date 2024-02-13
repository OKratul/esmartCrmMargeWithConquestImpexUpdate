<?php

namespace Database\Seeders;

use App\Models\CustomerModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
