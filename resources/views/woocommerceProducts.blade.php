

@include('partials.layoutHead')

<div id="wrapper">

    @if(request()->routeIs('user-woocommerce-products'))
        @include('user.partials.navbar')
        @include('user.partials.sidebar')
    @else
        @include('partials.navbar')
        @include('partials.sidebar')
    @endif



    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="">
                    <h3 class="p-4">All Products</h3>

                    <div class="product-card">
                        @foreach ($products as $product)

                            @php
                                $product_link = 'https://esmart.com.bd/product/'.$product->post_name
                            @endphp

                             <div class="card border-1 border-blue" style="width: 350px" >
                                 <a href="{{$product_link}}" target="_blank">
                                     <img class="card-img-top img-fluid" src="https://esmart.com.bd/wp-content/uploads/{{$product->image_filename}}" alt="{{$product->post_name}}">
                                 </a>
                                 <div class="card-body">
                                     <h4 class="card-title">
                                         {{$product->post_title}}
                                     </h4>
                                     <h4 class="card-title">
                                         <span>SKU:- {{$product->sku}}</span><br>
                                         <span>Price:- {{$product->price}} /-</span>
                                     </h4>
                                     <hr>
                                 </div>
                                 <div class="card-body" style="height:300px; overflow: scroll">
                                     <p class="card-text">{!! $product->post_content !!}<br></p>

                                 </div>
                                 <ul class="list-group list-group-flush">
                                     <li class="list-group-item"><h5>Category:-{{$product->category}}</h5> </li>
                                 </ul>
                                 <div class="card-body">
                                     <a href="#" class="card-link">Card link</a>
                                     <a href="#" class="card-link">Another link</a>
                                 </div>
                             </div>

                        @endforeach

                    </div>
                    <div>
                        {{$products->links()}}
                    </div>

                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>

@if(request()->routeIs('user-woocommerce-products'))

    @include('user.partials.rightbar')

@else
    @include('partials.rightbar')
@endif


@include('partials.layoutEnd')


