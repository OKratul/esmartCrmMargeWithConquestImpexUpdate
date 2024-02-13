@include('conquest.user.partials.layoutHeader')

<!-- body start -->
<body class="loading bg-soft-dark" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

<!-- Begin page -->
<div id="wrapper">


    <!-- Topbar Start -->
    @include('conquest.user.partials.navbar')
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->

    <!-- Left Sidebar End -->
    @include('conquest.user.partials.leftsideBar')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                @include('error')
                @include('success')
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3> <i class="fe-users"></i>All Products</h3>
                            </div>
                            <div>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-product-modal">
                                    Add Product <i class="fe-user-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Total Added Qty </th>
                                    <th>Stock Qty</th>
                                    <th>Sell Qty</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $index=>$product)
                                    <tr class="text-black {{$product->quantity <= 10 ? 'table-danger' : ''}}">
                                        <th>#{{$product->product_code}}</th>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->size}}</td>
                                        <td>
                                            @if(!empty($product->stocks['add_qty']))
                                                {{$product->stocks['add_qty']}}
                                            @else
                                                ----
                                            @endif
                                        </td>
                                        <td>
                                            {{$product->quantity}}
                                        </td>
                                        <td>
                                            @if(!empty($product->stocks['add_qty']))
                                                {{$product->stocks['add_qty'] - $product->quantity }}
                                            @else
                                                ----
                                            @endif

                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-info mb-2" data-bs-toggle="modal" data-bs-target="#add-product-modal-{{$product->id}}">
                                               Edit
                                            </button>
                                            <a onclick="return confirm('Are You Sure Want to Delete This Product ?')" href="{{route('conquest-delete-product',[$product->id])}}" class="btn btn-sm btn-outline-danger mb-2">
                                                Delete
                                            </a><br>
                                            <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#update-stock-modal-{{$product->id}}">
                                                Update Stock
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#history-modal-{{$product->id}}">
                                                History
                                            </button>

                                        </td>
                                    </tr>


{{--=============================== Update Product Stock Modal--}}
                                    <div class="modal fade" id="update-stock-modal-{{$product->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Update Stock</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('conquest-stock-update',[$product->id])}}" method="POST">
                                                        @csrf
                                                        <div class="d-flex align-items-end justify-content-center">
                                                            <div class="mb-2 ">
                                                                <label for="simpleinput" class="form-label">Quantity*</label>
                                                                <input name="update_stock" type="text" required id="simpleinput" class="form-control">
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-success mb-2">
                                                                    update
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
{{--=============================== Product Edit Modal =================== --}}
                                    <div class="modal fade" id="add-product-modal-{{$product->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Edit Product</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('conquest-update-product',[$product->id])}}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Product Name *</label>
                                                                <input value="{{$product->name}}" name="name" type="text" required id="simpleinput" class="form-control">
                                                            </div>
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Product Size *</label>
                                                                <input value="{{$product->product_code}}" name="size" type="text" required id="simpleinput" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Buy Price </label>
                                                                <input value="{{$product->buying_price}}" name="buying_price" type="text" id="simpleinput" class="form-control">
                                                            </div>
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Quantity</label>
                                                                <input value="{{$product->quantity}}" name="quantity" type="text" id="simpleinput" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-2 col-6">
                                                                <label for="simpleinput" class="form-label">Product Code </label>
                                                                <input value="{{$product->product_code}}" name="product_code" type="text" id="simpleinput" class="form-control">
                                                                <span>Leve Empty For Auto Generate</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-center mt-2">
                                                            <button type="submit" class="btn btn-primary">
                                                                Submit <i class="fe-user-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{$products->links('pagination::bootstrap-5')}}
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->


    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

{{-- ========= Edit Product Modal ============  --}}

    @foreach($products as $product)
        {{--===============================  Product History Modal ==================--}}
        <div class="modal fade" id="history-modal-{{$product->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Update Stock</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <td>SL</td>
                                <td>Date</td>
                                <td>Previous Stock</td>
                                <td>Updated Stock</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product->histories as $index=> $history)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{$history->created_at}}
                                    </td>
                                    <td>
                                        {{$history->previous_stock}}
                                    </td>
                                    <td>
                                        {{$history->updated_stock}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach




    {{-- Add Produc Modal --}}
    <div class="modal fade" id="add-product-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('conquest-add-product')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-2 col-6">
                                <label for="simpleinput" class="form-label">Product Name *</label>
                                <input name="product_name" type="text" required id="simpleinput" class="form-control">
                            </div>
                            <div class="mb-2 col-6">
                                <label for="simpleinput" class="form-label">Product Size *</label>
                                <input name="product_size" type="text" required id="simpleinput" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2 col-6">
                                <label for="simpleinput" class="form-label">Buy Price *</label>
                                <input name="buy_price" type="text" required id="simpleinput" class="form-control">
                            </div>
                            <div class="mb-2 col-6">
                                <label for="simpleinput" class="form-label">Quantity</label>
                                <input name="quantity" type="text" id="simpleinput" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2 col-6">
                                <label for="simpleinput" class="form-label">Product Code </label>
                                <input name="product_code" type="text" id="simpleinput" class="form-control">
                                <span>Leve Empty For Auto Generate</span>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary">
                                Submit <i class="fe-user-plus"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</div>
<!-- END wrapper -->

<!-- Right Sidebar -->

@include('conquest.user.partials.rightbar')

<!-- Scripts -->
@include('conquest.user.partials.layoutScripts')

</body>
