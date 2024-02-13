@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')
                    <div class="row">
                        <div class="col-xl-2">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="customer-profile-sidebar">
                                        <ul style="padding: 0px">
                                            <li>
                                                <a href="{{route('customer-profile',[$customer_id])}}"><i class='bx bx-user-circle me-1' ></i> Profile</a>
                                            </li>
                                            <li>
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
                                            <li class="active-2">
                                                <a href="{{route('admin-customer-notes',[$customer_id])}}"><i class='bx bx-note me-1'></i>Notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div>
                                @include('error')
                                @include('success')
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header text-left">
                                        <form method="POST" action="{{route('admin-customer-add-notes',[$customer_id])}}">
                                            @csrf
                                            <div class="text-left">
                                                <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                                <textarea name="notes" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2">
                                                Add Note
                                            </button>
                                        </form>
                                    </div>
                                    <hr>
                                    <div class="card-body mt-5 text-left border-2">
                                        @foreach($notes as $note)
                                         <div class="mb-5">
                                             <h4>
                                                 {{$note->notes}}<br>
                                             </h4>
                                             @if(!empty($note->users))
                                                 <span>({{$note->users->name}})</span><br>
                                             @endif

                                             @if(!empty($note->admins))
                                                 <span>({{$note->admins->username}})-admin</span><br>
                                             @endif

                                             <span>{{date('Y-m-d',strtotime($note->created_at))}}</span><br>
                                             <span>({{date('h:i:s A',strtotime($note->created_at))}})</span>

                                         </div>
                                        @endforeach
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

@include('partials.layoutEnd')
