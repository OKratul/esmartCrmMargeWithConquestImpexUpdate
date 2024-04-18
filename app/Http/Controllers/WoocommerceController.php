<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WoocommerceController extends Controller
{

    public function products (){

        $products = DB::connection('wordpress')
            ->table('posts')
            ->join('postmeta as pm1', 'posts.ID', '=', 'pm1.post_id')
            ->join('postmeta as pm2', function ($join) {
                $join->on('posts.ID', '=', 'pm2.post_id')
                    ->where('pm2.meta_key', '_thumbnail_id');
            })
            ->join('postmeta as pm3', function ($join) {
                $join->on('posts.ID', '=', 'pm3.post_id')
                    ->where('pm3.meta_key', '_sku');
            })
            ->select('posts.*', 'pm1.meta_value AS price', 'pm2.meta_value AS thumbnail_id', 'pm3.meta_value AS sku')
            ->where('posts.post_type', 'product')
            ->where('posts.post_status', 'publish')
            ->where('pm1.meta_key', '_price')
            ->orderByDesc('posts.post_date')
            ->paginate(20);


//        $product_images = DB::connection('wordpress')
//            ->table('postmeta')
//            ->where('post_id','41585')
//            ->where('meta_key', '_wp_attached_file')
//            ->get();

//        dd($product_images);

//        dd($products);

        return view('woocommerceProducts',compact('products'));

    }

}
