<?php

namespace App\Http\Controllers;

use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AddProductController extends Controller
{
    public function productForm(){

        $api = new EsmartApiController();
        $woocommerce = $api->api();

        $unit = $woocommerce->get('products');

        $attributes = $woocommerce->get('products/attributes');

//dd($attributes);

        return view('addProducts',compact('attributes'));
    }


    public function addProduct(){
        try {
            $validator = Validator::make(\request()->all(), [
                'type'=> 'required',
                'name'=> 'required',
                'regular_price'=>'required',
                'description' => 'nullable',
                'short_description'=> 'nullable',
                'category' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'name' => \request('name'),
                'type' => 'simple',
                'regular_price' => \request('regular_price'),
                'description' => \request('description'),
                'short_description' => \request('short_description'),
                'categories' => [
                    [
                        'id' => 9
                    ],
                    [
                        'id' => 14
                    ]
                ],
            ];

            $api = new EsmartApiController();
            $woocommerce = $api->api();

            $products = $woocommerce->post('products', $data);

            return redirect()->back()->with('success', 'Product Added Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

    }

}
