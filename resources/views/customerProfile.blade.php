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

                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-body">
                                    @include('error')
                                    @include('success')
                                    <h3 class="header-title mb-4">Customer Info</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4" style="border-right: 1px solid #ccc">
                                            <div>
                                                @include('partials.customerProfileForm')
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <ul class="nav nav-tabs nav-bordered">
                                                        <li class="nav-item">
                                                            <a href="#query-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active   ">
                                                                Queries
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="#quotation-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                                                Quotations
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="#invoice-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                                                Invoices
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="position-relative">
                                                    <button type="button" class="btn btn--md btn-success waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Add New <i class="ti-plus"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <button type="button" class=" btn btn-md waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#query">
                                                            Query
                                                        </button>
                                                        <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#quotation">
                                                            Quotation
                                                        </button>
                                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#invoice">
                                                            Invoice
                                                        </button>
                                                        <div class="dropdown-divider"></div>
                                                    </div>
                                                </div>
                                            </div>
{{--                                            ======= Modals --}}
                                            @include('partials.customerProfileQuotationForm')

                                            @include('partials.customerProfileTab')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- end row -->

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')

