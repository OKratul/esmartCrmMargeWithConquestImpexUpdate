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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3> <i class="fe-users"></i> Customers</h3>
                            </div>
                            <div>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-customer-modal">
                                    Add Customer <i class="fe-user-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Contact Person</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $index=>$customer)
                                        <tr>
                                            <th>{{$customer->id}}</th>
                                            <td>
                                                <a href="{{route('customer-profile',[$customer->id])}}">
                                                    {{$customer->name}}
                                                </a>
                                            </td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->address}}</td>
                                            <td>
                                                Email:- @if($customer->email)
                                                    {{$customer->email}}
                                                @else
                                                    Email Not Found
                                                @endif<br>
                                                Email-2:- @if($customer->email2)
                                                    {{$customer->email2}}
                                                @else
                                                    Email-2 Not Found
                                                @endif
                                            </td>
                                            <td>
                                                Name:- {{$customer->contact_person}}<br>
                                                Number:- {{$customer->contact_person_number}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#edit-customer-modal-{{$customer->id}}">
                                                    Edit </i>
                                                </button>
                                                <a onclick="return confirm('Are You Sure Want to Delete This Customer ?')" href="{{ route('conquest-customer-delete', [$customer->id]) }}" class="btn btn-outline-danger">
                                                    Delete
                                                </a>
                                                <a href="{{route('conquest-customer-profile',[$customer->id])}}" class="btn btn-outline-primary">
                                                    Profile
                                                </a>
                                            </td>
                                        </tr>

{{--                              Customer Edit Modal           --}}

                                        <div class="modal fade" id="edit-customer-modal-{{$customer->id}}" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('conquest-update-customer-info',[$customer->id])}}" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="mb-2 col-6">
                                                                    <label for="simpleinput" class="form-label">Customer Name *</label>
                                                                    <input value="{{$customer->name}}" name="name" type="text" required id="simpleinput" class="form-control">
                                                                </div>
                                                                <div class="mb-2 col-6">
                                                                    <label for="simpleinput" class="form-label">Phone Number *</label>
                                                                    <input value="{{$customer->phone}}" name="phone_number" type="text" required id="simpleinput" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-2 col-6">
                                                                    <label for="simpleinput" class="form-label">Email-1 *</label>
                                                                    <input value="{{$customer->email}}" name="email-1" type="email" required id="simpleinput" class="form-control">
                                                                </div>
                                                                <div class="mb-2 col-6">
                                                                    <label for="simpleinput" class="form-label">Email-2</label>
                                                                    <input value="{{$customer->email2}}" name="email-2" type="email" id="simpleinput" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-2 col-6">
                                                                    <label for="simpleinput" class="form-label">Address *</label>
                                                                    <textarea name="address" class="form-control" id="example-textarea" rows="3">
                                                                        {{$customer->address}}
                                                                    </textarea>
                                                                </div>
                                                                <div class="mb-2 col-3">
                                                                    <label for="simpleinput" class="form-label">Contact Person</label>
                                                                    <input value="{{$customer->contact_person}}" name="contact_person" type="text" id="simpleinput" class="form-control">
                                                                </div>
                                                                <div class="mb-2 col-3">
                                                                    <label for="simpleinput" class="form-label">Contact Person Number</label>
                                                                    <input value="{{$customer->contact_person_number}}" name="contact_person_number" type="text" id="simpleinput" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="text-center mt-2">
                                                                <button class="btn btn-primary">
                                                                    Update
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
                                {{$customers->links('pagination::bootstrap-5')}}
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

{{-- Add Customer Modal --}}
    <div class="modal fade" id="add-customer-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{route('conquest-add-customer')}}" method="POST">
                    @csrf
                      <div class="row">
                          <div class="mb-2 col-6">
                              <label for="simpleinput" class="form-label">Customer Name *</label>
                              <input name="name" type="text" required id="simpleinput" class="form-control">
                          </div>
                          <div class="mb-2 col-6">
                              <label for="simpleinput" class="form-label">Phone Number *</label>
                              <input name="phone_number" type="text" required id="simpleinput" class="form-control">
                          </div>
                      </div>
                      <div class="row">
                          <div class="mb-2 col-6">
                              <label for="simpleinput" class="form-label">Email-1 *</label>
                              <input name="email-1" type="email" required id="simpleinput" class="form-control">
                          </div>
                          <div class="mb-2 col-6">
                              <label for="simpleinput" class="form-label">Email-2</label>
                              <input name="email-2" type="email" id="simpleinput" class="form-control">
                          </div>
                      </div>
                      <div class="row">
                          <div class="mb-2 col-6">
                              <label for="simpleinput" class="form-label">Address *</label>
                              <textarea name="address" class="form-control" id="example-textarea" rows="3"></textarea>
                          </div>
                          <div class="mb-2 col-3">
                              <label for="simpleinput" class="form-label">Contact Person</label>
                              <input name="contact_person" type="text" id="simpleinput" class="form-control">
                          </div>
                          <div class="mb-2 col-3">
                              <label for="simpleinput" class="form-label">Contact Person Number</label>
                              <input name="contact_person_number" type="text" id="simpleinput" class="form-control">
                          </div>
                      </div>
                      <div class="text-center mt-2">
                          <button class="btn btn-primary">
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

<!-- Right Sidebar -->s

@include('conquest.user.partials.rightbar')

<!-- Scripts -->
@include('conquest.user.partials.layoutScripts')

</body>
