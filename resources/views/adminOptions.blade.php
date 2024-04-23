

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
                        <div class="card-body">
                            @include('success')
                            @include('error')
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#profile" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#pdf" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                       Pdf Options
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#options" data-bs-toggle="tab" aria-expanded="false" class="nav-link ">
                                        Status Options
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <div class="row">
                                        <div class="col-4">
                                           <div class="mt-3">
                                             <form method="POST" action="">
                                                 <div class="mb-2">
                                                     <label for="simpleinput" class="form-label">User Name</label>
                                                     <input type="text" id="simpleinput" name="customer_info_type" class="form-control">
                                                 </div>
                                                 <div class="mb-2">
                                                     <label for="simpleinput" class="form-label">Email</label>
                                                     <input type="text" id="simpleinput" name="customer_info_type" class="form-control">
                                                 </div>
                                             </form>
                                               <a href="">
                                                   Password Reset
                                               </a>
                                           </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h4 class="header-title">Upload Profile Image</h4>
                                                                <form action="/" method="post" class="dropzone" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
                                                                      data-upload-preview-template="#uploadPreviewTemplate">
                                                                    <div class="fallback">
                                                                        <input name="file" type="file" multiple />
                                                                    </div>

                                                                    <div class="dz-message needsclick">
                                                                        <i class="h1 text-muted dripicons-cloud-upload"></i>
                                                                        <h3>Drop files here or click to upload.</h3>
                                                                        <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
                                                    <strong>not</strong> actually uploaded.)</span>
                                                                    </div>
                                                                </form>

                                                                <!-- Preview -->
                                                                <div class="dropzone-previews mt-3" id="file-previews"></div>

                                                            </div> <!-- end card-body-->
                                                        </div> <!-- end card-->
                                                    </div><!-- end col -->
                                                </div>
                                                <!-- end row -->

                                                <!-- file preview template -->
                                                <div class="d-none" id="uploadPreviewTemplate">
                                                    <div class="card mt-1 mb-0 shadow-none border">
                                                        <div class="p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                                                </div>
                                                                <div class="col ps-0">
                                                                    <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                                                    <p class="mb-0" data-dz-size></p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <!-- Button -->
                                                                    <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                                                        <i class="dripicons-cross"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">

                                                    </div><!-- end col -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane show" id="pdf">
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 p-3" style="border-right: 1px solid #ccc">
                                            <h3>Pdf Setup For Esmart</h3>
                                            <div class="">
                                                <form method="POST" action="{{route('pdf-setup')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div>
                                                        <div class="mb-2">
                                                            <label for="example-palaceholder" class="form-label">Company Name</label>
                                                            <input name="name" type="text" id="example-palaceholder" class="form-control" placeholder="Esmart">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-fileinput" class="form-label">Upload Logo</label>
                                                            <input type="file" name="logo" id="example-fileinput" class="form-control">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-textarea" class="form-label">Text area</label>
                                                            <textarea name="address" class="form-control" id="example-textarea" rows="5"></textarea>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-palaceholder" class="form-label">Hotline</label>
                                                            <input name="hotline" type="text" id="example-palaceholder" class="form-control" placeholder="018452154,0124563">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-email" class="form-label">Email</label>
                                                            <input type="email" id="example-email" name="email" class="form-control" placeholder="Email">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-palaceholder" class="form-label">Website</label>
                                                            <input name="website" type="url" id="example-palaceholder" class="form-control" placeholder="esmart.com.bd">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-palaceholder" class="form-label">Designation</label>
                                                            <input name="designation" type="text" id="example-palaceholder" class="form-control" placeholder="esmart.com.bd">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="example-fileinput" class="form-label">Seal Image</label>
                                                            <input type="file" name="seal" id="" class="form-control">
                                                        </div>
                                                      <button type="submit" class="btn btn-primary">
                                                            Update Setup
                                                      </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="col-6 p-3">
                                            <div class="">
                                                <h3>
                                                    All Pdf Sets
                                                </h3>
                                                <div class="d-flex gap-3">
                                                    @if(empty($pdfSets))
                                                        <h4>
                                                            No Pdf Sets Found
                                                        </h4>
                                                    @endif
                                                    @foreach($pdfSets as $pdfSet)
                                                        <div class="card" style="width: 300px;border: 1px solid #cccccc">
                                                            <img class="card-img-top img-fluid mt-2" src="{{$pdfSet->logo}}" alt="Card image cap">
                                                            <div class="card-body">
                                                                <h4 class="card-title">{{$pdfSet->name}}</h4>
                                                                <p class="card-text">
                                                                    {{$pdfSet->address}}
                                                                </p>
                                                            </div>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">Hotline:- {{$pdfSet->hotline}}</li>
                                                                <li class="list-group-item">Email:- {{$pdfSet->email}}</li>
                                                                <li class="list-group-item">Website:- {{$pdfSet->website}}</li>
                                                                <li class="list-group-item">Designation:- {{$pdfSet->designation}}</li>
                                                            </ul>
                                                            <div class="card-body d-flex justify-content-center">
                                                                <img style="width: 150px" class="card-img-top img-fluid" src="{{$pdfSet->seal}}" alt="Card image cap">
                                                            </div>
                                                            <div class="card-body">
                                                                <a href="#" class="card-link">Card link</a>
                                                                <a href="#" class="card-link">Another link</a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane " id="options">

                                    <h3>Status Options</h3>
                                    <hr>

                                    <div class="row">
{{--                                        Query Source --}}
                                        <div class="col-4">
                                            <div class="p-3" style="border-right: 1px solid #ccc">
                                                <h5>Add Query Source</h5>
                                                <div>
                                                    <form action="{{route('add-querySource-options')}}" method="POST" >
                                                       @csrf
                                                        <div class="d-flex">
                                                           <div class="mb-2" style="width: 80%">
                                                               <input type="text" id="example-input-small" name="query_source" class="form-control form-control-sm" placeholder="Query Source">
                                                           </div>
                                                           <div>
                                                               <button type="submit" class="btn btn-primary btn-sm">
                                                                   submit
                                                               </button>
                                                           </div>
                                                       </div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $querySources = \App\Models\QuerySource::all();
                                                @endphp
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($querySources as $index => $querySource)
                                                            <tr>
                                                                <th scope="row">{{$index + 1}}</th>
                                                                <td>{{$querySource->query_source}}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#query_source{{$querySource->id}}">Edit</button>                                 <a href="{{ route('delete-query-source', [$querySource->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this query source?')">Delete</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
{{--                                        Query Status --}}
                                        <div class="col-4" style="border-right:1px solid #ccc ">
                                            <div class="p-3">
                                                <h5>Add Query Status</h5>
                                                <div>
                                                    <form action="{{route('add-queryStatus-options')}}" method="POST" >
                                                        @csrf
                                                        <div class="d-flex">
                                                            <div class="mb-2" style="width: 80%">
                                                                <input type="text" id="example-input-small" name="query_status" class="form-control form-control-sm" placeholder="Query Status">
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $queryStatuses = \App\Models\QueryStatus::all();
                                                @endphp
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($queryStatuses as $index => $queryStatus)
                                                                <tr>
                                                                    <th scope="row">{{$index + 1}}</th>
                                                                    <td>{{$queryStatus->query_status}}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#query_status{{$queryStatus->id}}">Edit</button>                         <a href="{{ route('delete-queryStatus-options', [$queryStatus->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this query status?')">Delete</a>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

{{--                                    Warranty --}}
                                        <div class="col-4">
                                            <div class="p-3">
                                                <h5>Add Warranty </h5>
                                                <div>
                                                    <form action="{{route('warranty')}}" method="POST" >
                                                        @csrf
                                                        <div class="d-flex">
                                                            <div class="mb-2" style="width: 80%">
                                                                <input type="text" id="example-input-small" name="warranty" class="form-control form-control-sm" placeholder="Add Warranty">
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $warranties = \App\Models\Warranty::all() ;
                                                @endphp
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($warranties as $index => $warranty)
                                                                <tr>
                                                                    <th scope="row">{{$index + 1}}</th>
                                                                    <td>{{$warranty->warranty}}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#warranty{{$warranty->id}}">Edit</button>                             <a href="{{ route('delete-warranty', [$warranty->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this warranty?')">Delete</a>
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

                                    <div class="row">
                                        {{--                                        Unite --}}
                                        <div class="col-4" style="border-right:1px solid #ccc ">
                                            <div class="p-3">
                                                <h5>Add Units </h5>
                                                <div>
                                                    <form action="{{route('add-unit-options')}}" method="POST" >
                                                        @csrf
                                                        <div class="d-flex">
                                                            <div class="mb-2" style="width: 80%">
                                                                <input type="text" id="example-input-small" name="unit" class="form-control form-control-sm" placeholder="add Unit">
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $unites = \App\Models\Unit::all();
                                                @endphp
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($unites as $index => $unit)
                                                                <tr>
                                                                    <th scope="row">{{$index + 1}}</th>
                                                                    <td>{{$unit->unit}}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#unit{{$unit->id}}">Edit</button>
                                                                        <a href="{{ route('delete-unit-options', [$unit->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this unit?')">Delete</a>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{--  Payment Type  --}}
                                        <div class="col-4" style="border-right:1px solid #ccc ">
                                            <div class="p-3">
                                                <h5>Add Payment Type </h5>
                                                <div>
                                                    <form action="{{route('add-paymentType-options')}}" method="POST" >
                                                        @csrf
                                                        <div class="d-flex">
                                                            <div class="mb-2" style="width: 80%">
                                                                <input type="text" id="example-input-small" name="payment_type" class="form-control form-control-sm" placeholder="add Payment Type">
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $paymentTypes = \App\Models\PaymentType::all();
                                                @endphp
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($paymentTypes as $index => $paymentType)
                                                                <tr>
                                                                    <th scope="row">{{$index + 1}}</th>
                                                                    <td>{{$paymentType->payment_type}}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#payment_type{{$paymentType->id}}">Edit</button>                         <a href="{{ route('delete-paymentType-options', [$paymentType->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payment type?')">Delete</a>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--    Delivery Term    --}}
                                        <div class="col-4" style="border-right:1px solid #ccc ">
                                            <div class="p-3">
                                                <h5>Add Delivery Term </h5>
                                                <div>
                                                    <form action="{{route('add-deliveryTerm-options')}}" method="POST" >
                                                        @csrf
                                                        <div class="d-flex">
                                                            <div class="mb-2" style="width: 80%">
                                                                <input type="text" id="example-input-small" name="delivery_term" class="form-control form-control-sm" placeholder="add Delivery Term">
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $deliveryTerms = \App\Models\DeliveryTerm::all();
                                                @endphp
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($deliveryTerms as $index => $deliveryTerm)
                                                                <tr>
                                                                    <th scope="row">{{$index + 1}}</th>
                                                                    <td>{{$deliveryTerm->delivery_term}}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#delivery_term{{$deliveryTerm->id}}">Edit</button>                         <a href="{{ route('delete-deliveryTerm-options', [$deliveryTerm->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this delivery term?')">Delete</a>

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
                        </div>
                    </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

{{--    Edit Modals --}}


    {{--    Query Source--}}
        @foreach($querySources as $querySource)
            <div class="modal fade" id="query_source{{$querySource->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myCenterModalLabel">Query Source Edit </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('edit-query-source',[$querySource->id])}}" method="POST" >
                                @csrf
                                <div class="d-flex">
                                    <div class="mb-2" style="width: 80%">
                                        <input value="{{$querySource->query_source}}" type="text" id="example-input-small" name="query_source" class="form-control form-control-sm" placeholder="Query Source">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        @endforeach
    {{--    Query Source Model End--}}

    {{--  Query Status Edit  --}}
    @foreach($queryStatuses as $queryStatus)
        <div class="modal fade" id="query_status{{$queryStatus->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myCenterModalLabel">Query Status Edit </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('edit-queryStatus-options',[$queryStatus->id])}}" method="POST" >
                            @csrf
                            <div class="d-flex">
                                <div class="mb-2" style="width: 80%">
                                    <input value="{{$queryStatus->query_status}}" type="text" id="example-input-small" name="query_status" class="form-control form-control-sm" placeholder="Query Source">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach
    {{--  Query Status End  --}}

    {{--  Edit Unit Option  --}}
    @foreach($unites as $unit)
        <div class="modal fade" id="unit{{$unit->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myCenterModalLabel">Unit Edit </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('edit-unit-options',[$unit->id])}}" method="POST" >
                            @csrf
                            <div class="d-flex">
                                <div class="mb-2" style="width: 80%">
                                    <input value="{{$unit->unit}}" type="text" id="example-input-small" name="unit" class="form-control form-control-sm" placeholder="Query Source">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach

    {{--  Edit Payment Type Option  --}}
    @foreach($paymentTypes as $paymentType)
        <div class="modal fade" id="payment_type{{$paymentType->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myCenterModalLabel">Unit Edit </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('edit-paymentType-options',[$paymentType->id])}}" method="POST" >
                            @csrf
                            <div class="d-flex">
                                <div class="mb-2" style="width: 80%">
                                    <input value="{{$paymentType->payment_type}}" type="text" id="example-input-small" name="payment_type" class="form-control form-control-sm" placeholder="Query Source">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach

    {{--  Edit Payment Type Option  --}}
    @foreach($deliveryTerms as $deliveryTerm)
        <div class="modal fade" id="delivery_term{{$deliveryTerm->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myCenterModalLabel">Unit Edit </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('edit-deliveryTerm-options',[$deliveryTerm->id])}}" method="POST" >
                            @csrf
                            <div class="d-flex">
                                <div class="mb-2" style="width: 80%">
                                    <input value="{{$deliveryTerm->delivery_term}}" type="text" id="example-input-small" name="delivery_term" class="form-control form-control-sm" placeholder="Query Source">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach

    {{--  Edit Warranty Option  --}}
    @foreach($warranties as $warranty)
        <div class="modal fade" id="warranty{{$warranty->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myCenterModalLabel">Unit Edit </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('edit-warranty',[$warranty->id])}}" method="POST" >
                            @csrf
                            <div class="d-flex">
                                <div class="mb-2" style="width: 80%">
                                    <input value="{{$warranty->warranty}}" type="text" id="example-input-small" name="warranty" class="form-control form-control-sm" placeholder="Query Source">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    @endforeach



    {{-- End Edit Models --}}

</div>


@include('partials.rightbar')


@include('partials.layoutEnd')


