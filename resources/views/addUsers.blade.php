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
                        <div class="row">
                            <div class="col-md-12">
                                @include('partials.userRegistration')
                            </div>
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Queries</th>
                                        <th>Quotation</th>
                                        <th>Invoice</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">

                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <strong>{{$user->name}}</strong>
                                            </td>
                                            <td>
                                                {{$user->email}}
                                            </td>
                                            <td>
                                               {{count($user->queries)}}
                                            </td>
                                            <td>
                                                {{count($user->quotations)}}
                                            </td>
                                            <td>
                                                {{count($user->invoices)}}
                                            </td>
                                            <td>
                                                <a class="text-white btn btn-info" href="{{route('admin-user-profile',[$user->id])}}">
                                                    View Profile
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')



@include('partials.layoutEnd')

