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
                <div class="account-container">
                   @foreach($accounts as $account)
                        <div style="width:400px">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h3>{{$account->account_type}}</h3>
                                        <h4>{{$account->bank_name}}</h4>
                                        <p>({{$account->account_number}})</p>
                                        <h3>Balance:- ${{$account->balance}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                   @endforeach
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






