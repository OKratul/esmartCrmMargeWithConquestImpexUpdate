

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
                            <h4 class="header-title mb-4">Default Tabs</h4>

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
                                    @include('success')
                                    @include('error')
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
                                    <p>Vakal text here dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p>
                                    <p class="mb-0">Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
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


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')


