@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="customers">
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="card">
                                        <h4>All Expanses</h4>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Invoice No</th>
                                                    <th>Expanse Name</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                @foreach($expanses as $key => $expanse)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            @if($expanse->invoices)
                                                                {{$expanse->invoices->invoice_no}}
                                                            @else
                                                                No Invoice
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$expanse->expanse_name}}
                                                        </td>
                                                        <td>
                                                            {{$expanse->expanse_amount}}
                                                        </td>
                                                        <td>
                                                            {{$expanse->date}}
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <button class="btn btn-sm btn-primary">
                                                                    <a class="text-white" href="{{route('user-view-update-expanse',[$expanse->id])}}">Edit</a>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger" onclick="confirm('Are you sure you want to delete this Expanse')">
                                                                    <a class="text-white" href="{{route('user-delete-expanse',[$expanse->id])}}">Delete</a>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="popup" class="popup">
                                                <div class="popup-content">
                                                    <span class="close" onclick="closePopup()">&times;</span>
                                                    <h2>Pop-up Content</h2>
                                                    <p>This is the content of the pop-up window.</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{$expanses->links()}}
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card">
                                        <h4>Add Expanses</h4>
                                        <div class="card-body text-left">
                                            <form action="{{route('user-update-expanse',[$singleExpanse['id']])}}"
                                                      method="POST">
                                                {{csrf_field()}}
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-fullname">Expanse Name</label>
                                                    <input type="text" value="{{$singleExpanse['expanse_name']}}" name="expanse_name" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-company">Amount</label>
                                                    <input value="{{$singleExpanse['expanse_amount']}}" name="amount" type="number" class="form-control" id="basic-default-company" placeholder="ACME Inc.">
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                                                    <input class="form-control" name="date" type="date" value="{{$singleExpanse['date']}}" id="html5-date-input">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </form>
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

