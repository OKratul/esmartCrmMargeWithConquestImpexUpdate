<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Automattic\WooCommerce\HttpClient\HttpClientException;


class ProductCategoryController extends Controller
{
    public function category()
    {

        $api = new EsmartApiController();


        $woocommerce = $api->api();
        $categories = $woocommerce->get('products/categories',
            [
                'per_page' => 10,
                'search' => \request('name'),
            ]
        );
//            dd($categories);

        $collection = new Collection($categories);

        $categoriesWithSubcategories = $collection->map(function ($category) use ($woocommerce) {
            $categoryId = $category->id;

//                 Query subcategories for the current category
            $subcategories = $woocommerce->get('products/categories',
                [
                    'parent' => $categoryId,
                    'per_page' => 50,
                ]
            );

//                 Assign subcategories to the current category
            $category->subcategories = $subcategories;

            return $category;
        });
//            dd($categoriesWithSubcategories);


        return view('productCategory', compact('categoriesWithSubcategories'));
    }


    public function addCategory()
    {

        $this->validate(\request(), [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'nullable',
            'parent' => 'nullable',
            'group_of_quantity' => 'nullable',
            'thumbnail' => 'nullable|mimes:jpeg,png,jpg'
        ]);


        $api = new EsmartApiController();

        $woocommerce = $api->api();


        $response = $woocommerce->get('products/categories');

        // Retrieve the uploaded image file
        $imageFile = request()->file('thumbnail');
        $imageExtetion = $imageFile->extension();

        $imageName = rand('1000','9999').'product'.'.'.$imageExtetion;

        request()->file('thumbnail')->move('images/products',$imageName);


//        dd($uploadedImage);

//        dd($uploadedThumbnail);

        $data = [
            'name' => \request('name'),
            'slug'=> \request('slug'),
            'description' => \request('description'),
            'parent' => \request('parent'),
            'group_of_quantity' => \request('group_of_quantity'),
            'display' => \request('display'),
            'image' => [
                'src' => asset('/images/products/'.$imageName),
            ],
        ];

        if ($data){
            $addCategory = $woocommerce->post('products/categories',$data);
            return redirect()->back()->with('success','Category added successfully');
        }else{
            return redirect()->back()->with('error','data not found');
        }

    }
}
