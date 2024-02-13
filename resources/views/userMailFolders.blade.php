@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@include('partials.layoutEnd')
