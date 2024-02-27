<?php

namespace App\Http\Controllers\conquest;

use App\Http\Controllers\Controller;
use App\Models\conquest\ConquestCustomer;
use App\Models\conquest\ConquestProduct;
use App\Models\conquest\ConquestProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConquestProductController extends Controller
{
    public function allProduct(){
        $products = ConquestProduct::with('stocks')->orderByDesc('created_at')->paginate(10);

//        dd($products);
        return view('conquest.allProducts',compact('products'));
    }

    public function addProduct(){

        $this->validate(\request(),[
            'product_name' => 'required',
            'product_code' => 'nullable',
            'product_size' => 'required',
            'quantity' => 'required',
            'buy_price' => 'nullable',
        ]);

        $productName = \request('product_name');

        $codePrefix = implode('', array_map(function($word) {
            return strtoupper($word[0]);
        }, explode(' ', $productName)));

        // Generate a 4-digit random number
        $randomNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Concatenate the code prefix and the random number with a dash
        $generatedProductCode = $codePrefix . '-' . $randomNumber;

        // Check if the 'product_code' is empty, and if so, use the generated code
        $productCode = \request('product_code') ?: $generatedProductCode;

        $product = ConquestProduct::create([
            'product_code' => $productCode,
            'name' => \request('product_name'),
            'size' => \request('product_size'),
            'quantity' => \request('quantity'),
            'buying_price' => \request('buy_price'),
        ]);

        ConquestProductStock::create([
            'product_id' => $product->id,
            'add_qty' => \request('quantity'),
        ]);

        return redirect()->back();
    }

    public function updateProduct($id){

        $this->validate(\request(),[
            'name' => 'required',
            'product_code'=> 'required',
            'quantity'=> 'required',
            'buying_price'=> 'nullable',
            'size'=> 'nullable',
        ]);

        ConquestProduct::where('id',$id)->update([
            'product_code'=> \request('product_code'),
            'name'=> \request('name'),
            'size'=> \request('size'),
            'quantity'=> \request('quantity'),
            'buying_price'=> \request('buying_price'),
        ]);

        return redirect()->back()->with('success', 'Product Updated Successfully');

    }


    public function deleteProduct($id){

        ConquestProduct::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Product Deleted');

    }

    public function updateStock($id){

        $this->validate(\request(),[
            'update_stock' => 'required',
        ]);

        $productStock = ConquestProductStock::where('product_id' , $id)->first();
        $total = $productStock->add_qty + \request('update_stock');

        $product = ConquestProduct::where('id',$id)->first();
        $stockTotal = $product['quantity'] + \request('update_stock');



        $productStock->histories()->create([
            'previous_stock' => $product['quantity'],
            'updated_stock' => $total,
        ]);

        $product->histories()->create([
            'previous_stock' => $product['quantity'],
            'updated_stock' => $total,
        ]);

        $productStock->update([
            'add_qty' => $total,
        ]);

        $product->update([
            'quantity' => $stockTotal,
        ]);

        return redirect()->back()->with('success','Stock Updated');

    }



//    Old Database Query

    public function updateOldStock()
    {
        $oldStocks = DB::table('wpdf_Ism_Stock')->get();

        foreach ($oldStocks as $oldStock){

            $product = ConquestProduct::where('product_code',$oldStock->Product_ID)->first();

            if ($product){
                ConquestProductStock::create([
                    'product_id' => $product['id'],
                    'add_qty' => $oldStock->Add_Qty,
                    'added' => $oldStock->Added,
                ]);
            }

        }

        return redirect()->back()->with('success','Old Stock Updated');

    }

    public function updateCustomersFromOldData(){
        $customers = DB::table('wpdf_ism_customer')->get();

        foreach ($customers as $customer){

            ConquestCustomer::create([
                'id' => $customer->Customer_ID ,
                'name' => $customer->Name,
                'phone'=> $customer->Phone,
                'email' => $customer->Email,
                'email2' => $customer->Email2,
                'address' => $customer->Address,
                'contact_person' => $customer->Contact_Person,
                'contact_person_number' => null,
            ]);

        }

        return redirect()->back();

    }


    public function insertOldProduct(){

        $oldProducts = DB::table('wpdf_ism_product')->get();

        foreach ($oldProducts as $product){
            ConquestProduct::create([
                'id' => $product->ID,
                'product_code' => $product->Product_ID,
                'name' => $product->Name,
                'size' => $product->Size,
                'quantity' => $product->Quantity,
                'buying_price' => null,
            ]);
        }

        return redirect()->back()->with('success','Old Data Updated');

    }


}
