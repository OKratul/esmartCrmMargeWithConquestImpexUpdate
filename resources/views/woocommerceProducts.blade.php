

@include('partials.layoutHead')

<div id="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="card">

                    <div class="card-body product-card">
                        @foreach ($products as $product)

                            @php
                                $product_link = 'https://esmart.com.bd/product/'.$product->post_name
                            @endphp

                         <div class="">
                             <div class="card border-1 border-dark">
                                 <div class="card-body" style="height: 500px;overflow: scroll">
                                    <div class="product-container">
                                        <div class="position-sticky">
                                            <a href="{{$product_link}}" target="_blank">
                                                <img src="#" alt="{{$product->post_name}}">
                                            </a>
                                            <h4>
                                                SKU:- {{$product->sku}}
                                            </h4>
                                        </div>
                                        <div>
                                            <h3>
                                                {{$product->post_title}}
                                            </h3>
                                            {!! $product->post_content !!}<br>

                                        </div>
                                        <div class="price">
                                            <hr>
                                            <h3>Price:- {{$product->price}}</h3>
                                        </div>
                                    </div>
                                 </div>
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


@include('partials.rightbar')


@include('partials.layoutEnd')


