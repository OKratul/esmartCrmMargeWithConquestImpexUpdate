@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('user-all-products'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">

                    <div class="card">
                        <h5 class="card-header">All website</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product_image</th>
                                    <th>Product name</th>
                                    <th>Product_Description</th>
                                    <th>Product_price</th>
                                    <th>Product_stock</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody class="table-border-bottom-0 pb-5">

                                @foreach($products as $product)
                                    <tr>
                                        <td style="font-size: 12px">
                                            @foreach($product->images as $image)
                                                <img src="{{$image->src}}"  style="width:150px; height:150px" class="img-fluid">
                                            @endforeach
                                        </td>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{$product->name}}</strong>
                                        </td>


                                        <td style="font-size: 14px">
                                            <!-- {{!!$product->description!!}} -->
                                        </td>
                                        <td>
                                            {{$product->regular_price}}.tk
                                        </td>
                                        <td>
                                            {{$product->stock_status}}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
