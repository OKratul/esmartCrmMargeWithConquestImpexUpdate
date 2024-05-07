<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\PaymentType;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WoocommerceController extends Controller
{

    public function products (){

        $search = \request('search');

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
            ->join('term_relationships', 'posts.ID', '=', 'term_relationships.object_id')
            ->join('term_taxonomy', function ($join) {
                $join->on('term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_taxonomy_id')
                    ->where('term_taxonomy.taxonomy', '=', 'product_cat');
            })
            ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
            ->join('postmeta as pm4', function ($join) { // Join to get image file name
                $join->on('pm2.meta_value', '=', 'pm4.post_id')
                    ->where('pm4.meta_key', '_wp_attached_file');
            })
            ->select(
                'posts.*',
                'pm1.meta_value AS price',
                'pm2.meta_value AS thumbnail_id', // This assumes thumbnail_id stores the attachment ID
                'pm3.meta_value AS sku',
                'pm4.meta_value AS image_filename', // The column containing the image file name
                'terms.name AS category' // Retrieve product category
            )
            ->where('posts.post_type', 'product')
            ->where('posts.post_status', 'publish')
            ->where('pm1.meta_key', '_price')
            ->where(function ($query) use ($search) {
                $query->where('posts.post_title', 'like', '%' . $search . '%')
                    ->orWhere('pm3.meta_value', 'like', '%' . $search . '%');
            })
            ->orderByDesc('posts.post_date')
            ->paginate(20);
        

        $querySources =QuerySource::all();
        $statuses = QueryStatus::all();
        $unites  = Unit::all();
        $customers = CustomerModel::all();
        $warranties = Warranty::all();
        $paymentTypes = PaymentType::all();
        $deliveryTerms = DeliveryTerm::all();
        $users = User::all();


//        $product_images = DB::connection('wordpress')
//            ->table('postmeta')
//            ->where('post_id','41585')
//            ->where('meta_key', '_wp_attached_file')
//            ->get();

//        dd($product_images);

//        dd($products);

        return view('woocommerceProducts',compact('products',
            'querySources','statuses','unites'
                ,'customers','warranties','paymentTypes',
                'deliveryTerms','users'
        ));

    }

}
