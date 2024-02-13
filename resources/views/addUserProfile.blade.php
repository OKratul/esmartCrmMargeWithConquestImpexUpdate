@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')


            <div class="content-wrapper">

                {{--   =====   Content ===--}}


                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-md-12">
                            @include('error')
                            @include('success')
                            @include('partials.userInput')
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
