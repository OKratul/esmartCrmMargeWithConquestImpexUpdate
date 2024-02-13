@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-2">
                            @include('admin.adminMailBoxSidebar')
                        </div>
                        <div class="col-xl-10">
                            <div class="card">
                                <div class="card-body text-left">
                                    <h5>Subject:- {!! implode('',$subject) !!}</h5>
                                    <hr>
                                    <div>

                                    </div>
                                    <div>
                                        {!! implode('',$body) !!}
                                    </div>
                                    <div>
                                        @foreach($attachments as $attachment)
                                            {!! $attachment !!}
                                        @endforeach
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

@include('partials.layoutEnd')
