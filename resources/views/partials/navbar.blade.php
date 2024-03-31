{{-- navbar --}}

<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-end mb-0">

        <li class="d-none d-lg-block">
            <form class="app-search"
                  @if(request()->routeIs('admin-all-query'))
                      action="{{route('admin-all-query')}}"
                  @elseif(request()->routeIs('admin-all-quotation'))
                      action="{{route('admin-all-quotation')}}"
                  @elseif(request()->routeIs('admin-all-invoice'))
                      action="{{route('admin-all-invoice')}}"
                  @endif
                  method="GET">
                @csrf
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." id="top-search">
                        <button class="btn input-group-text" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </li>

        <li class="dropdown d-inline-block d-lg-none">
            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#"
               role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-search noti-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                <form class="p-3">
                    <input type="text" name="search" class="form-control" placeholder="Search ..."
                           aria-label="Recipient's username">
                </form>
            </div>
        </li>

        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#"
               role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-end">
                           <a href="" class="text-dark">
                              <small>Clear All</small>
                           </a>
                        </span>Notification
                    </h5>
                </div>

                <div class="noti-scroll" data-simplebar>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                        <div class="notify-icon">
                            <img src="{{asset('assets/images/users/user-1.jpg')}}" class="img-fluid rounded-circle" alt=""/></div>
                        <p class="notify-details">Cristina Pride</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Hi, How are you? What about our next meeting</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-primary">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">1 min ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon">
                            <img src="{{asset('assets/images/users/user-4.jpg')}}" class="img-fluid rounded-circle" alt=""/></div>
                        <p class="notify-details">Karen Robinson</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Wow ! this admin looks good and awesome design</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-warning">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <p class="notify-details">New user registered.
                            <small class="text-muted">5 hours ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">4 days ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-secondary">
                            <i class="mdi mdi-heart"></i>
                        </div>
                        <p class="notify-details">Carlos Crouch liked
                            <b>Admin</b>
                            <small class="text-muted">13 days ago</small>
                        </p>
                    </a>
                </div>

                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    View all
                    <i class="fe-arrow-right"></i>
                </a>

            </div>
        </li>

        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
               href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('assets/images/users/user-1.jpg')}}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ms-1">
                                    Nowak <i class="mdi mdi-chevron-down"></i>
                                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="#" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
                </a>

                <!-- item-->
                <a href="#" class="dropdown-item notify-item">
                    <i class="fe-lock"></i>
                    <span>Lock Screen</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{route('admin-logout')}}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>

        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li>

    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.html" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="22">
                            </span>
            <span class="logo-lg">
                                <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="16">
                            </span>
        </a>
        <a href="index.html" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="{{asset('assets/images/logo-sm.png')}}" alt="" height="22">
                            </span>
            <span class="logo-lg">
                                <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="16">
                            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0 " style="margin-left: 30px">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>
        <li>
            <div class="btn-group mt-2">
                <button style="font-size: 16px" type="button" class="btn btn-success dropdown-toggle rounded-pill"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Add New <i style="font-size: 18px" class="fe-plus-circle"></i>
                </button>
                <div class="dropdown-menu" style="">
                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#add-query-modal">
                        Query
                    </button>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#add-quotation-modal">
                        Quotation
                    </button>
                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#add-invoice-modal">
                        Invoice
                    </button>

                </div>
            </div>
        </li>
        <li>

{{--            Task Assign Modal      --}}
            <div class="mt-2" style="margin-left: 50px">

                <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#task-assign-modal">
                    Assign Task <i class="fe-user-plus"></i>
                </button>

            </div>
        </li>
    </ul>

    <div class="clearfix"></div>

</div>
<!-- end Topbar -->

@php
    $querySources = \App\Models\QuerySource::all();
     $statuses = \App\Models\QueryStatus::all();
     $unites = \App\Models\Unit::all();
     $customers= \App\Models\CustomerModel::all();
      $warranties = \App\Models\Warranty::all();
      $paymentTypes = \App\Models\PaymentType::all();
      $deliveryTerms = \App\Models\DeliveryTerm::all();
@endphp

{{--Modals Form--}}
<div>
    {{--  Query Modal Form  --}}
    @include('partials.adminNavbarQueryModal',compact('querySources'))

    {{--  Quotation Modal Form   --}}
    @include('partials.adminNavbarQuotationModal')

    {{--  Invoice Modal form   --}}
    @include('partials.adminNavbarInvoiceModal')

</div>


<script type="text/javascript">

    //    ======== Quotation product details =======


    let addButton = document.getElementById('add_product');

    addButton.addEventListener('click', function () {
        let productContainer = document.getElementById('productDetailsContainer');


        let addProductDiv = document.createElement('div');

        addProductDiv.classList.add('product_details');

        addProductDiv.innerHTML = `
                                        <div class="mb-3">
                                            <!-- Add remove button -->
                                            <button class="remove_product btn btn-danger">Remove</button>
                                        </div>
                                         <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label">Product Name*</label>
                                        <input required type="text" name="product_name[]" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-company">Product Code*</label>
                                        <input type="text" required name="product_code[]" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-email">Quantity*</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" required name="quantity[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                        <input required type="text" name="unit_price[]" class="form-control phone-mask">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="defaultSelect" class="form-label">Select Unit*</label>
                                        <select required class="form-control" name="unit[]" required="">
                                            @foreach($unites as $unit)
        <option value="{{$unit->unit}}">{{$unit->unit}} </option>
                                                                                @endforeach
        </select>
    </div>
    <div class="mb-3 col-4">
        <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
        <input type="text" name="costing[]" class="form-control phone-mask">
    </div>
</div>

<div class="row">
    <div class="mb-3 col-8">
        <label class="form-label" for="basic-default-message">Product Description</label>
        <textarea name="product_description[]" class="form-control"></textarea>
    </div>
    <div class="mb-3 col-4">
        <label class="form-label" for="basic-default-phone">Product Discount</label>
        <input type="text" name="product_discount[]" class="form-control phone-mask">
    </div>
</div>
<div class="row">
        <div class="mb-3 col-6">
            <label class="form-label" for="basic-default-phone">Product Source</label>
            <input type="text" name="product_source[]" class="form-control phone-mask">
        </div>
        <div class="mb-3 col-6">
            <label class="form-label" for="basic-default-phone">Product image</label>
            <input type="file" name="product_image[]" class="form-control phone-mask">
        </div>
</div>

`
        productContainer.appendChild(addProductDiv);
        let removeButtons = document.getElementsByClassName('remove_product');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                // Remove the parent div when remove button is clicked
                this.parentNode.parentNode.remove();
            });
        }
    });
</script>


{{--========= Invoice Add product --}}

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        let addButton = document.getElementById('nav_add_product_invoice');

        addButton.addEventListener('click', function () {
            let productContainer = document.getElementById('nav-productDetailsContainer-invoice');
            let addProductDiv = document.createElement('div');

            addProductDiv.classList.add('nav-product_details_invoice');

            addProductDiv.innerHTML = `
                <div class="mb-3">
                    <!-- Add remove button -->
                    <button class="remove_product_invoice btn btn-danger">Remove</button>

                    <div class="row">
                            <div class="mb-3 col-4">
                                <label class="form-label">Product Name*</label>
                                <input required type="text" name="product_name[]" class="form-control" >
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="basic-default-company">Product Code*</label>
                                <input type="text" required name="product_code[]" class="form-control" >
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="basic-default-email">Quantity*</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" required name="quantity[]" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-4">
                                <label class="form-label" for="basic-default-phone">Unit Price*</label>
                                <input type="text" required name="unit_price[]" class="form-control phone-mask">
                            </div>
                            <div class="mb-3 col-4">
                                <label for="defaultSelect" class="form-label">Select Unit*</label>
                                <select class="form-control" name="unit[]" required >
                                    @foreach($unites as $unit)
            <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                    @endforeach
            </select>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-phone">Our Costing/Buying Amount</label>
                <input type="text" name="costing[]" class="form-control phone-mask">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-message">Product Description</label>
                <textarea name="product_description[]" class="form-control"></textarea>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-phone">Product Discount</label>
                <input type="text" name="product_discount[]" class="form-control phone-mask">
            </div>
            <div class="mb-3 col-4">
                <label class="form-label" for="basic-default-phone">Product Source</label>
                <input type="text" name="product_source[]" class="form-control phone-mask">
            </div>
        </div>

    </div>
<!-- ... (rest of your product details HTML) ... -->
<hr class="m-4">
`;

            productContainer.appendChild(addProductDiv);

            let removeButtons = document.getElementsByClassName('remove_product_invoice');
            for (let i = 0; i < removeButtons.length; i++) {
                removeButtons[i].addEventListener('click', function () {
                    // Remove the parent div when remove button is clicked
                    this.parentNode.parentNode.remove();
                });
            }
        });
    });
</script>
<div class="modal fade" id="task-assign-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Assign Task To Your User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('assign-task')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-2 col-6">
                            <label for="simpleinput" class="form-label">Select User*</label>
                            <select name="user_id" class="form-select">
                                <option>Select Status</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col-6">
                            <label for="simpleinput" class="form-label">Start Date*</label>
                            <input class="form-control" id="example-date" type="date" name="start_date">
                        </div>
                        <div class="mb-2 col-6">
                            <label for="simpleinput" class="form-label">End Date</label>
                            <input name="end_date" type="date" id="simpleinput" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col-12">
                            <label for="simpleinput" class="form-label">Job Title*</label>
                            <input required name="title" type="text" id="simpleinput" class="form-control">
                        </div>
                        <div class="mb-2 col-12">
                            <label for="simpleinput" class="form-label">Job Description</label>
                            <textarea name="description" type="text" id="simpleinput" class="form-control"></textarea>
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
