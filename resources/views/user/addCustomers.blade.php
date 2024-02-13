@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">

                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2>Add Customer</h2>
                                @include('error')
                                @include('success')
                            </div>
                            <div class="card-body">

                                <form method="POST" action="{{route('user-addCustomer-done')}}">
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

                                    <button type="submit" class="btn btn-primary">Add<i class='bx bx-plus me-1'></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
