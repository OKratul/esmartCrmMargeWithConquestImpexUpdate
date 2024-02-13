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
                            @include('error')
                            @include('success')
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">

                                    <button class="btn btn-primary">
                                        <a href="{{route('user-view-query-form')}}" class="text-white">Add New <i class='bx bx-plus'></i></a>
                                    </button>

                                   <div class="d-inline">
                                       <h3 class="mb-0">All Query</h3>
                                       <hr>
                                       <h5><strong>total result:-</strong> {{$totalResult}}</h5>
                                   </div>
                                    <div class="filter">
                                        <form method="GET" action="{{route('old-query-date-filter')}}">
                                            {{csrf_field()}}
                                            <div class="mb-3 row">
                                                <div class="col-md-10 d-flex">
                                                    <input name="date" class="form-control" type="date" id="html5-date-input">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class='bx bx-filter-alt' ></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <div class="card-body text-left">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>date</th>
                                            <th>Company Name</th>
                                            <th>Address Phone & Email</th>
                                            <th>Product Category</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($queries as $key => $query)
                                                <tr>
                                                    <td>
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td>
                                                        {{$query->Date}}
                                                    </td>
                                                    <td>
                                                        {{$query->Customer_Name}}
                                                    </td>
                                                    <td>
                                                        {{$query->Phone}}
                                                        <p>
                                                            {{$query->Email}}<br>
                                                            {{$query->Email}}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        {{$query->Product_Cat}}
                                                    </td>
                                                    <td>
                                                        {{$query->Address}}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown text-right">
                                                            {{$query->Status}}
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu text-right">
                                                                <a class="dropdown-item" href="javascript:void(0);">Open</a>
                                                                <a class="dropdown-item" href="javascript:void(0);">Close</a>
                                                                <a class="dropdown-item" href="javascript:void(0);">Processing</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div style="line-height: 30px" class="">
                                                                <button type="button" class="btn btn-sm btn-primary">
                                                                    <a class="text-white" href="">Edit</a>
                                                                </button>
                                                                <button onclick="return confirm('Are you sure you want to delete this quotation?')" type="button" class="btn btn-sm btn-danger">
                                                                    <a class="text-white" href="">Delete</a>
                                                                </button><br>
                                                                <button type="button" class="btn btn-sm btn-primary">
                                                                    <a class="text-white" href="">Make Quot.</a>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-primary add-query-note" id="">
                                                                    Add Note
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="add-note-row d-none">
{{--                                                    <td colspan="8">--}}
{{--                                                        <form class="add-note-form" method="POST" action="{{route('add-note',[$customer->id,$query->id])}}">--}}
{{--                                                            {{ csrf_field() }}--}}
{{--                                                            <div>--}}
{{--                                                                <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>--}}
{{--                                                                <textarea class="form-control" name="notes" rows="3"></textarea>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="mt-3">--}}
{{--                                                                <button type="submit" class="btn btn-success">--}}
{{--                                                                    Submit--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-danger remove-query-note-form">--}}
{{--                                                                    Remove--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        </form>--}}
{{--                                                    </td>--}}
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{$queries->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@include('partials.layoutEnd')
