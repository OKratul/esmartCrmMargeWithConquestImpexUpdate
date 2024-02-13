@include('user.partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('user-phone-numbers'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif
        <div class="layout-page">
            @if(request()->routeIs('user-phone-numbers'))
                @include('user.partials.navbar')
            @else
                @include('partials.navbar')
            @endif
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @include('error')
                                    @include('success')
                                </div>
                                <div class="col-6">
                                    <div>
                                        <form method="POST" action="@if(request()->routeIs('user-phone-numbers'))
                                                                        {{route('user-add-phonebook')}}
                                                                        @else
                                                                            {{route('add-phonebook')}}
                                                                        @endif
                                                                        ">
                                            {{csrf_field()}}
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name*</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                                        <input required name="name" type="text" class="form-control" id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                        <input name="email" type="text" id="basic-icon-default-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2">
                                                    </div>
                                                    <div class="form-text">You can use letters, numbers &amp; periods</div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 form-label" for="basic-icon-default-phone">Phone No*</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                                        <input name="phone_number" required type="text" id="basic-icon-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 form-label" for="basic-icon-default-message">Notes</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                                                        <textarea name="note" id="basic-icon-default-message" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Add <i class='bx bx-plus'></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-5">
                                        <div class="mb-3">
                                            <form method="GET" action="{{route('phone-numbers')}}">
                                                {{csrf_field()}}
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                                                    <input name="search" type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                                                    <button type="submit" class="btn btn-sm btn-primary"><i class='bx bx-search' ></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <table class="table table-dark rounded">
                                            <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Name</th>
                                                <th>Number</th>
                                                <th>E-mail</th>
                                                <th>Notes</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            @foreach($phoneNumbers as $index=>$phoneNumber)
                                                <tr>
                                                    <td>
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td>
                                                        {{$phoneNumber->name}}
                                                    </td>
                                                    <td>
                                                        {{$phoneNumber->number}}
                                                    </td>
                                                    <td>
                                                        {{$phoneNumber->gmail}}
                                                    </td>
                                                    <td>
                                                        {{$phoneNumber->notes}}
                                                    </td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary m-1">Edit</a>
                                                        <a href="" class="btn btn-sm btn-danger m-1">Delete</a>
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

</div>

@include('user.partials.layoutEnd')

