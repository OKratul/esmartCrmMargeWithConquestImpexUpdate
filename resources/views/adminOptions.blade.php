@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Option</h4>

                    <div class="row">
                        <div class="col-md-12 ">
                            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{route('admin-settings')}}"><i class="bx bx-user me-1"></i> Account</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{route('view-admin-options')}}"><i class="bx bx-bell me-1"></i>Options</a>
                                </li>
                            </ul>
                            <div class="card mb-4">
                                <h5 class="card-header">Query/Quotation/Invoice Select Options</h5>
                                <!-- Account -->
                               <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card-body">
                                            <h4>Add Select Options</h4>
                                            {{--   Unit--}}
                                            <form action="{{route('add-unit-options')}}" method="POST" >
                                            {{csrf_field()}}
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">Add Unit</label>
                                                   <div class="d-flex">
                                                       <input required name="unit" class="form-control" type="text" id="firstName" autofocus="">
                                                      <div>
                                                          <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                      </div>
                                                   </div>
                                                </div>
                                            </form>

                                            <form action="{{route('add-querySource-options')}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">Add Query Source</label>
                                                   <div class="d-flex">
                                                       <input name="query_source" required class="form-control" type="text" id="firstName" autofocus="">
                                                      <div>
                                                          <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                      </div>
                                                   </div>
                                                </div>
                                            </form>

                                            <form action="{{route('add-queryStatus-options')}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">Add Query Status</label>
                                                   <div class="d-flex">
                                                       <input name="query_status" required class="form-control" type="text" id="firstName" autofocus="">
                                                      <div>
                                                          <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                      </div>
                                                   </div>
                                                </div>
                                            </form>
                                            <form action="{{route('add-deliveryTerm-options')}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">Add Delivery Term</label>
                                                   <div class="d-flex">
                                                       <input name="delivery_term" required class="form-control" type="text" id="firstName" autofocus="">
                                                      <div>
                                                          <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                      </div>
                                                   </div>
                                                </div>
                                            </form>

                                            <form action="{{route('add-paymentType-options')}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">Add Payment Type</label>
                                                   <div class="d-flex">
                                                       <input name="payment_type" required class="form-control" type="text" id="firstName" autofocus="">
                                                      <div>
                                                          <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                      </div>
                                                   </div>
                                                </div>
                                            </form>

                                            <form action="{{route('warranty')}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstName" class="form-label">Warranty</label>
                                                   <div class="d-flex">
                                                       <input name="warranty" required class="form-control" type="text" id="firstName" autofocus="">
                                                      <div>
                                                          <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                      </div>
                                                   </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                   <div class="col-xl-6">
                                       <div class="card-body">
                                            <h4>Add Expense Options</h4>
                                           <form action="{{route('add-expense')}}" method="POST" >
                                               {{csrf_field()}}
                                               <div class="mb-3 col-md-6">
                                                   <label for="firstName" class="form-label">Add Expense Name</label>
                                                   <div class="d-flex">
                                                       <input required name="expense" class="form-control" type="text" id="firstName" autofocus="">
                                                       <div>
                                                           <button type="submit" class="btn btn-primary ml-1"><i class='bx bx-plus'></i></button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                                <hr class="my-0">

                                <!-- /Account -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
