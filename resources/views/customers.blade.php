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
                <div class="customers">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{route('customer-added')}}">
                                                    {{csrf_field()}}
                                                    <div class="individual text-left" id="individualCustomer">
                                                        <div class="col-md-10 mb-4">
                                                            <div class="input-group">
                                                                <label class="input-group-text" for="inputGroupSelect01">Select Product type</label>
                                                                <select name="type" id="selectCustomerType">
                                                                    <option selected="">Choose Type</option>
                                                                    <option value="individual">Individual</option>
                                                                    <option value="company">Company</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-fullname">Full Name/Company Name</label>
                                                            <input name="name" type="text" class="form-control" placeholder="Full Name/ Company Name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-company">Contact Person Name</label>
                                                            <input name="contact_name" type="text" class="form-control" placeholder="">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-email">Email</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="email" name="email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-phone">Phone No</label>
                                                            <input type="number" name="phone" class="form-control phone-mask" placeholder="658 799 8941">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-message">Address</label>
                                                            <textarea name="address" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-email">City</label>
                                                            <div class="input-group input-group-merge">
                                                                <input name="city" type="text" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-default-email2">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-email">Country</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text" name="country" class="form-control" placeholder="john.doe">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="basic-default-email">Postal Code</label>
                                                            <div class="input-group input-group-merge">
                                                                <input name="postal_code" type="number" class="form-control">

                                                            </div>
                                                        </div>

                                                    </div>

                                                   <div class="text-center">
                                                       <button type="submit" class="text-center btn btn-primary">Submit<i class='bx bx-plus me-1'></i></button>
                                                   </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                                    Add New Customer <i class="fe-user-plus"></i>
                                </button>
                            </div>
                            <div>
                                @include('partials.allcustomersTable')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')



