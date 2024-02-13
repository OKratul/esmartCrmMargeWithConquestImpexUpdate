@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

       @if(request()->routeIs('user-add-products'))
           @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">

                    <div class="row">
                        <div class="col-xl-2">
                            <div class="card">
                                    <div class="product-side-bar">
                                        <ul class="tabs">
                                            <li id="general" class="active">
                                                General
                                            </li>
                                            <li id="inventory">
                                                Inventory
                                            </li>
                                            <li id="linkedProduct">
                                                Linked Product
                                            </li>
                                            <li id="attributes" class="tabs">
                                                Attributes
                                            </li>
                                            <li id="advanced">
                                                Advanced
                                            </li>
                                            <li id="bulkDiscount" class="tabs">
                                                Bulk Discount
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Add Products</h5>
                                <div class="table-responsive text-nowrap">
                                    @include('error')
                                    @include('success')
                                    <div class="card-body">
                                        <form method="POST" action="{{route('add-category')}}">
                                            {{csrf_field()}}

                                            <div class="mb-3 row">
                                                <label for="html5-text-input" class="col-md-2 col-form-label">Select Type</label>
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="inputGroupSelect01">Select Product type</label>
                                                        <select name="type" id="select_type">
                                                            <option selected="">Choose Type</option>
                                                            <option value="simple_product">Simple Products</option>
                                                            <option value="Variable_product">Variable Products</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-search-input" class="col-md-2 col-form-label">Product Name</label>
                                                <div class="col-md-10">
                                                    <input name="name" class="form-control" type="text" placeholder="product name" id="html5-search-input">
                                                </div>
                                            </div>
                                    <hr>

                                            {{--  General  --}}

                                            <div class="tab-content general">

                                               <div class="price">
                                                   <div class="mb-3 row">
                                                       <label for="html5-email-input" class="col-md-2 col-form-label">Regular Price</label>
                                                       <div class="col-md-10">
                                                           <input name="regular_price" class="form-control" type="number" placeholder="12000" id="html5-email-input">
                                                       </div>
                                                   </div>

                                                   <div class="mb-3 row">
                                                       <label class="col-md-2 col-form-label">Sale Price</label>
                                                       <div class="col-md-10">
                                                           <input name="sale_price" class="form-control" type="number" placeholder="12000" >
                                                       </div>
                                                   </div>
                                               </div>

                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Minimum Quantity</label>
                                                    <div class="col-md-10">
                                                        <input name="sale_price" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Maximum Quantity</label>
                                                    <div class="col-md-10">
                                                        <input name="sale_price" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Group of</label>
                                                    <div class="col-md-10">
                                                        <input name="sale_price" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>

                                            </div>
{{--                                            General End--}}

{{--                                            Inventory--}}
                                            <div class="tab-content inventory">
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Quantity</label>
                                                    <div class="col-md-10">
                                                        <input name="quantity" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>

                                                <div class="col-md text-left mb-3">
                                                    <small class="text-light fw-semibold">Allow backorders ?</small>
                                                    <div class="form-check mt-3">
                                                        <input name="default-radio-1" class="form-check-input" type="radio" value="" id="defaultRadio1">
                                                        <label class="form-check-label" for="defaultRadio1">Do not allow </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input name="default-radio-1" class="form-check-input" type="radio" value="" id="defaultRadio2" checked="">
                                                        <label class="form-check-label" for="defaultRadio2"> Allow, but notify customer </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input name="default-radio-1" class="form-check-input" type="radio" value="" id="defaultRadio2" checked="">
                                                        <label class="form-check-label" for="defaultRadio2"> Allow </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Low stock threshold</label>
                                                    <div class="col-md-10">
                                                        <input name="_low_stock_amount" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="col-md text-left">
                                                    <label>Sold individually</label>
                                                    <div class="form-check">
                                                        <input name="_sold_individually" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                    </div>
                                                </div>
                                            </div>

{{--                                            Inventory End--}}

{{--                                            Linked Product--}}
                                            <div class="tab-content linkedProduct">
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Upsell</label>
                                                    <div class="col-md-10">
                                                        <input name="sale_price" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Cross Sell</label>
                                                    <div class="col-md-10">
                                                        <input name="sale_price" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                            </div>
{{--                                            Linked Product End--}}

{{--                                            Attributes--}}
                                            <div class="tab-content attributes text-left">

                                                <div class="mb-3 d-flex">
                                                    <button class="btn btn-gray text-dark" type="button">Add New</button>
                                                    <select id="defaultSelect" class="form-select ml-2">
                                                        <option>Select Existing</option>
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

{{--                                            Attributes End--}}


{{--                                            Advanced--}}
                                            <div class="tab-content advanced">

                                                <div class="mb-3 row">
                                                    <label for="html5-url-input" class="col-md-2 col-form-label">Purchase Note</label>
                                                    <div class="col-md-10">
                                                        <textarea name="_purchase_note" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Menu order</label>
                                                    <div class="col-md-10">
                                                        <input name="sale_price" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>

                                                <div class="col-md text-left">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <label class="form-check-label" for="inlineCheckbox1">Enable reviews</label>
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    </div>
                                                </div>
                                            </div>
{{--                                            Advanced End--}}


{{--                                            Custom Options--}}
                                            <div class="tab-content customOption">
                                                <div class="mb-3 text-left">
                                                    <label for="exampleFormControlSelect1" class="form-label">Select unit</label>
                                                    <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                                        <option selected="">Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Vendor Name</label>
                                                    <div class="col-md-10">
                                                        <input name="esmart_vendor" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-md-2 col-form-label">Vendor Number</label>
                                                    <div class="col-md-10">
                                                        <input name="esmart_vendor_num" class="form-control" type="number" placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="col-md text-left">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <label class="form-check-label" for="inlineCheckbox1">Shoiw on New Arrival</label>
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    </div>
                                                </div>
                                                <div class="col-md text-left">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <label class="form-check-label" for="inlineCheckbox1">Show Verified partner</label>
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    </div>
                                                </div>
                                            </div>

{{--                                            Custom Options End--}}


{{--                                            Bulk Discount--}}
                                            <div class="tab-content bulkDiscount">
                                                <div class="col-md text-left">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <label class="form-check-label" for="inlineCheckbox1">Bulk Discount enabled</label>
                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="html5-url-input" class="col-md-2 col-form-label">Purchase Note</label>
                                                    <div class="col-md-10">
                                                        <textarea name="_bulkdiscount_text_info" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary">Add Discount line</button>
                                            </div>



{{--                                            Bulk Discount End--}}



                                            <hr class="m-5">

                                            <div class="mb-3 row">
                                                <label for="html5-url-input" class="col-md-2 col-form-label">Description</label>
                                                <div class="col-md-10">
                                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-tel-input" class="col-md-2 col-form-label">Sold individually</label>
                                                <div class="col-md-10">
                                                    <textarea name="short_description" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-password-input" class="col-md-2 col-form-label">Category</label>
                                                <div class="col-md-10">
                                                    <input name="categories" class="form-control" type="text" placeholder="Category" id="html5-password-input">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-password-input" class="col-md-2 col-form-label">Product Slug</label>
                                                <div class="col-md-10">
                                                    <input name="categories" class="form-control" type="text" placeholder="Slug" id="html5-password-input">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-password-input" class="col-md-2 col-form-label">Product Tag</label>
                                                <div class="col-md-10">
                                                    <input name="categories" class="form-control" type="text" placeholder="abcd,efgh" id="html5-password-input">
                                                </div>
                                                <div class="form-text">Separate tags with commas</div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Add <i class='bx bx-plus me-1' ></i></button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="category-search p-4">
                                    <label for="defaultFormControlInput" class="form-label">Search Category</label>
                                    <input placeholder="search..." type="text" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
