@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-5">
                                    <p>
                                        Customer Type:- {{$query->customers['customer_type']}}
                                    </p>
                                    <p>
                                        Name :- {{$query->customers['name']}}
                                    </p>
                                    <p>
                                        Contact Name :- {{$query->customers['contact_name']}}
                                    </p>
                                    <p>
                                        Email :- {{$query->customers['email']}}
                                    </p>
                                    <p>
                                        Phone Number :- {{$query->customers['phone_number']}}
                                    </p>
                                    <p>
                                        Address :- {{$query->customers['address']}}
                                    </p>
                                </div>
                                <div class="col-2">
                                    <strong>
                                        Query Status
                                    </strong><br>
                                    {{$query->status}}
                                </div>
                                <div class="col-5">
                                    <div>
                                        <p>
                                            Query Source:- {{$query->query_source}}
                                        </p>
                                        <p>
                                            Query Details:- {{$query->query_details}}
                                        </p>
                                        <p>
                                            Product Sku:- {{$query->product_sku}}
                                        </p>
                                        <p>
                                            Product Name:- {{$query->product_name}}
                                        </p>
                                        <p>
                                            Product Quantity:- {{$query->product_quantity}}
                                        </p>
                                        <p>
                                            Product Category:- {{$query->product_category}}
                                        </p>
                                        <p>
                                            Reminder Date:- {{$query->reminder_date}}
                                        </p>
                                        <p>
                                            Submit Date:- {{$query->reminder_date}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @php($users = \App\Models\User::all())
                                <form class="" method="POST" action="{{route('req-for-trans',[$query->id])}}">
                                    {{csrf_field()}}
                                    <div class="d-flex align-items-center">
                                        <div class="mb-4">
                                            <label for="defaultSelect" class="form-label">Transfer Req.</label>
                                            <select name="req_user_id" id="defaultSelect" class="form-select">
                                                <option>Default select</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            {{--             Modal Button--}}
                                            <button type="submit" class="btn btn-outline-secondary mt-1">
                                                <i class='bx bxs-send' ></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@include('user.partials.layoutEnd')

