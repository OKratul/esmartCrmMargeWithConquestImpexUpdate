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
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul style="padding: 0px">
                                            <li>
                                                <a href="{{route('customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href="{{route('admin-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">All Query</h4>
                                    <button class="btn btn-primary">
                                        <a href="{{route('view-add-query-form',[$customer_id])}}" style="font-size: 20px; color:#7fe0f6">Add New <i class='bx bx-plus'></i></a>
                                    </button>
                                </div>
                                <div class="card-body text-left">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>date</th>
                                            <th>Company Name</th>
                                            <th>Query Details</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($allQueries as $key=>$query)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            {{$query->submit_date}}
                                                        </td>
                                                        <td>
                                                            {{$query['customers']['name']}}
                                                        </td>
                                                        <td>
                                                            <p>
                                                                {{$query->query_details}}
                                                            </p>
                                                            <span>Category:- <strong>{{$query->product_category}}</strong></span><br>
                                                            @if(!empty($query->product_link))
                                                                <span>Product link: {{$query->product_link}}</span>
                                                            @else
                                                                <span>Product link: Link Not Found</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <p>
                                                                {{$query['customers']['address']}}, {{$query['customers']['city']}},{{$query['customers']['country']}}<br>
                                                                phone:-{{$query['customers']['phone_number']}}<br>
                                                                email:{{$query['customers']['email']}}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            {{$query->status}}
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <div style="line-height: 30px" class="">
                                                                    <a class="text-white btn btn-sm btn-primary mb-1" href="{{route('admin-customer-show-edit-query',[$customer_id,$query->id])}}">
                                                                        Edit
                                                                    </a>

                                                                    <a onclick="confirm('are you sure you want to delete this query')"
                                                                       class="text-white btn btn-sm btn-danger mb-1" href="{{route('admin-deleteQuery',[$query->id])}}">
                                                                        Delete
                                                                    </a>

                                                                    <a class="text-white btn btn-sm btn-primary mb-1" href="{{route('view-quotation',[$customer_id])}}">
                                                                        Make Quot.
                                                                    </a>

                                                                    <button type="button" class="btn btn-sm btn-primary add-query-note mb-1" id="">
                                                                        Add Note
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="add-note-row d-none">
                                                        <td colspan="8">
                                                            <form class="add-note-form" method="POST" action="{{route('admin-add-note',[$customer_id,$query->id])}}">
                                                                {{ csrf_field() }}
                                                                <div>
                                                                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                                                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <button type="submit" class="btn btn-success">
                                                                        Submit
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger remove-query-note-form">
                                                                        Remove
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-center">Notes</td>
                                                    </tr>
                                                    @foreach($query->notes->sortBy(function ($note) {
                                                             return $note->date;
                                                         })->reverse() as $note)
                                                        <tr>
                                                            <td colspan="5">{{$note->notes}}</td>
                                                            <td>{{$note->user_name}}</td>
                                                            <td>{{$note->date}}</td>
                                                            <td>
                                                                <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this quotation?')" href="{{route('admin-delete-note',[$note->id])}}">delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="8">
                                                            <hr>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    let addQueryNoteButtons = document.querySelectorAll('.add-query-note');

    addQueryNoteButtons.forEach((noteButton) => {
        noteButton.addEventListener('click', () => {
            let noteFormRow = noteButton.closest('tr').nextElementSibling;
            if (noteFormRow) {
                noteFormRow.classList.remove('d-none');
            }
        });
    });

    let removeQueryNoteForms = document.querySelectorAll('.remove-query-note-form');

    removeQueryNoteForms.forEach((removeButton) => {
        removeButton.addEventListener('click', () => {
            let noteFormRow = removeButton.closest('tr');
            if (noteFormRow) {
                noteFormRow.classList.add('d-none');
            }
        });
    });
</script>

@include('partials.layoutEnd')
