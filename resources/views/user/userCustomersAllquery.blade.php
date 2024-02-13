@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul>
                                            <li>
                                                <a href="{{route('user-customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li class="active-2">
                                                <a href="{{route('user-view-all-query',[$customer_id])}}"><i class='bx bx-notepad me-1'></i>Lead/Query</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-all-quotations',[$customer_id])}}"><i class='bx bxs-file-pdf me-1'></i>All Quotations</a>
                                            </li>
                                            <li>
                                                <a href="{{route('all-invoice',[$customer_id])}}"><i class='bx bx-food-menu me-1'></i> Invoices</a>
                                            </li>
                                            <li>
                                                <a href="{{route('customer-all-payment',[$customer_id])}}"><i class='bx bxs-badge-dollar me-1'></i> payments</a>
                                            </li>
                                            <li>
                                                <a href="{{route('user-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">All Query</h4>
                                    @include('error')
                                    @include('success')
                                    <a class="btn btn-primary" href="{{route('user-query-add-form-profile',[$customer_id])}}" style="font-size: 20px; color:#7fe0f6">Add New <i class='bx bx-plus'></i></a>
                                </div>
                                <div class="card-body text-left" style="overflow: scroll">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Crated At</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Address Phone & Email</th>
                                            <th class="text-center">Query Details</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allQueries as $key=>$query)
                                                <tr>
                                                    <td class="text-center">
                                                        {{$query->created_at->format('d M Y')}}<br>
                                                        <span class="text-center" style="font-size: 12px">
                                                            {{$query->created_at->format('h:i A')}}
                                                        </span>
                                                    </td>
                                                    <td>
                                                       @if(!empty($query->users))
                                                            {{$query->users['name']}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$query->customers['name']}}
                                                    </td>
                                                    <td>
                                                        {{$query->customers['address']}}, {{$query->customers['city']}},{{$query->customers['country']}}<br>
                                                        phone:-{{$query->customers['phone_number']}}<br>
                                                        email:{{$query->customers['email']}}
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
                                                        {{$query->status}}
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                           @if(!empty($query->users))
                                                                @if($query->users['id'] == \Illuminate\Support\Facades\Auth::user()->id)
                                                                    <div style="line-height: 30px" class="">
                                                                        <a class="text-light btn btn-sm btn-primary mb-2 text-white" href="{{route('user-customer-show-edit-query',[$customer_id,$query->id])}}">Edit</a>
                                                                        <a onclick="return confirm('Are you sure you want to delete this quotation?')" class="mb-2 text-white btn btn-sm btn-danger" href="{{route('deleteQuery',[$query->id])}}">Delete</a>
                                                                        <a class="btn btn-sm btn-primary mb-2" href="{{route('user-view-add-quotation',[$query->customer_id])}}">
                                                                            Make Quot.
                                                                        </a><br>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-info add-query-note" id="">
                                                                Add Note
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="add-note-row d-none">
                                                    <td colspan="8">
                                                        <form class="add-note-form" method="POST" action="{{route('add-note',[$customer_id,$query->id])}}">
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
                                                            <button class="btn btn-sm btn-info">
                                                                <a href="">edit</a>
                                                            </button>
                                                            <button class="btn btn-sm btn-danger">
                                                                <a onclick="return confirm('Are you sure you want to delete this quotation?')" href="{{route('delete-note',[$customer_id,$query->id,$note->id])}}">delete</a>
                                                            </button>
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
