@include('partials.layoutHead')

<div id="wrapper">

    @include('user.partials.navbar')
    @include('user.partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
        <div class="card">
            <div class="card-body">
                @include('partials.allcustomersTable')
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>


@include('user.partials.rightbar')


@include('partials.layoutEnd')


