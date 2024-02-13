@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('user-documents'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif

            <div class="layout-page">
                @if(request()->routeIs('user-documents'))
                    @include('user.partials.navbar')
                @else
                    @include('partials.navbar')
                @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @include('error')
                                    @include('success')
                                    <div>
                                        <h3>File/Document/Image/Pdf</h3>
                                        <form method="POST" action="@if(request()->routeIs('user-documents'))
                                                                            {{route('user-document-upload')}}
                                                                      @else {{route('document-upload')}}
                                                                      @endif
                                        " enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="input-group mb-2">
                                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-file' ></i></span>
                                                <input required name="file_name" type="text" class="form-control" placeholder="File Name" aria-label="Username" aria-describedby="basic-addon11">
                                            </div>
                                            <div class="input-group">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                <input required name="file" type="file" class="form-control" id="inputGroupFile01">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2">
                                                Upload <i class='bx bx-upload' ></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card mt-5">
                                        <div class="card-body file-container">
                                            <div class="">
                                                <form action="" method="GET">
                                                    {{csrf_field()}}
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                                                        <input name="search" type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                                                        <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            @foreach ($documents as $document)
                                                <div>
                                                    <div class="mb-2">
                                                        <p>Name: {{ $document->note }}</p>
                                                        <span style="font-size: 12px">link:- {{$document->file_name}}</span>
                                                    </div>
                                                    @if (in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['txt']))
                                                        <!-- View Text -->
                                                        <i class='bx bxs-file-txt' style="font-size: 150px"></i>
                                                    @elseif (in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                        <!-- View Images -->
                                                        <img src="{{ asset($document->file_name) }}" class="img-fluid" width="180" height="180px">
                                                    @elseif(in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['zip']))
                                                        <i class='bx bx-library' style="font-size: 150px"></i>
                                                    @elseif(in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['doc,docx']))
                                                        <i class='bx bxs-file-doc'  style="font-size: 150px"></i>
                                                    @elseif(in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['pdf']))
                                                        <i class='bx bxs-file-pdf' style="font-size: 150px"></i>
                                                    @endif

                                                    <div>
                                                        <a {{in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['zip']) ? 'hidden' : ''}} class="btn btn-sm btn-primary" target="_blank" href="{{ asset($document->file_name) }}">View</a>
                                                        <a class="btn btn-sm btn-info" href="@if(request()->routeIs('user-documents'))
                                                            {{route('user-download-document',[$document->id])}}
                                                            @else
                                                            {{route('admin-download-document',[$document->id])}}
                                                            @endif
                                                        ">Download</a>
                                                        <a onclick="confirm('are you sure you want to delete {{$document->note}} ?')" class="btn btn-sm btn-danger" href="
                                                        @if(request()->routeIs('user-documents'))
                                                        {{route('user-delete-document',[$document->id])}}
                                                        @else
                                                        {{route('user-delete-document',[$document->id])}}
                                                        @endif
                                                        ">Delete</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="p-3">
                                            {{$documents->links()}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@include('user.partials.layoutEnd')

