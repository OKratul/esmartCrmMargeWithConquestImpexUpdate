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

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="expense-container">
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <h3>
                                 Expenses
                            </h3>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                                Add Expense Name
                            </button>
                            <button type="button" class="btn btn-danger">
                                Add Expanse
                            </button>
                        </div>
                    </div>

                    <div>

                    </div>

                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->


    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


{{-- ============= Expense Name Modal ============  --}}
    <div id="standard-modal" class="modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add Expense Name</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Expense Name</label>
                            <input type="text" id="simpleinput" class="form-control">
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">
                                Add Name
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->

@include('conquest.user.partials.rightbar')

<!-- Scripts -->
@include('conquest.user.partials.layoutScripts')

</body>
