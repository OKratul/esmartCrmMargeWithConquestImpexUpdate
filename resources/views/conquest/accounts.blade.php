@include('conquest.user.partials.layoutHeader')

<!-- body start -->
<body class="loading" data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

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

            @include('success')
            @include('error')
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="account-container mt-3">
                    <div class="d-flex justify-content-between">
                        <h2>
                            Accounts
                        </h2>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-account-modal">
                            Add New Account <i class="fe-plus"></i>
                        </button>

                    </div>
                    <hr>
                    <div class="d-flex justify-content-around mt-4">
                       @foreach($accounts as $account)
                            <div class="card" style="width: 400px">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h1>{{$account->account_name}} </h1>
                                        <div>
                                            <a href="{{route('conquest-trancestions',[$account->id])}}" class="btn btn-sm btn-outline-info">transections</a>
                                        </div>
                                    </div>
                                    <h5>Account No:- {{$account->account_number}}</h5>
                                    <h3>Balance:- ${{$account->balance}}</h3>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>Total Cash In</h4>
                                            <p>${{$account->total_cash_in ? :'00'}}</p>
                                        </div>
                                        <div>
                                            <h4>Total Cash Out</h4>
                                            <p>${{$account->total_cash_out? : '00'}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- container-fluid -->

        </div> <!-- content -->


    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->

{{--        Add Accounts Modal  --}}

<div class="modal fade" id="add-account-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('conquest-account-add')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-2 col-6">
                            <label for="simpleinput" class="form-label">Account Name*</label>
                            <input name="account_name" type="text" required id="simpleinput" class="form-control">
                        </div>
                        <div class="mb-2 col-6">
                            <label for="simpleinput" class="form-label">Account No*</label>
                            <input required name="account_no" type="text" id="simpleinput" class="form-control">
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-2 col-6">
                            <label for="simpleinput" class="form-label">Balance*</label>
                            <input required name="balance" type="text" id="simpleinput" class="form-control">
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">
                            Submit <i class="fe-user-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


@include('conquest.user.partials.rightbar')

<!-- Scripts -->
@include('conquest.user.partials.layoutScripts')

</body>
