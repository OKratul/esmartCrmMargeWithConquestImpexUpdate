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
                    <div class="user-profiles">
                        <div class="card p-4 ">
                            <div class="row">
                                <div class="col-xl-6 card">
                                    <div>
                                       @if($user_info)
                                            <div class="text-left p-5">
                                                @if($user_info['pro_img'])
                                                    <img style="width: 300px" class="img-fluid user-pro-img" src="{{ asset('profiles/' . $user_info['pro_img']) }}" alt="user-profile-pic">
                                                @else
                                                    <img style="width: 300px" class="img-fluid user-pro-img" src="{{ asset('profiles/new.png') }}" alt="user-profile-pic">
                                                @endif
                                                <h4 class="text-light text-capitalize mt-3"><strong>Name:-</strong>{{$user_info['first_name']}} {{$user_info['last_name']}}</h4>
                                                <h6 class="text-light"><strong>Email:-</strong>{{$user_info['email']}}</h6>
                                            </div>
                                        @else
                                        <h4>
                                            User Info Dose Not Exist
                                        </h4>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 card">
                                    <div class="mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0 text-light">Profile Info</h5>
                                        </div>
                                        <div class="card-body">
                                            <form class="" method="POST" action="{{route('user-profile-added',[$id])}}" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-light" for="basic-default-name">First Name</label>
                                                    <div class="col-sm-10">
                                                        <input name="first_name" type="text" class="form-control" id="basic-default-name" placeholder="First Name">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-name">Last Name</label>
                                                    <div class="col-sm-10">
                                                        <input name="last_name" type="text" class="form-control" id="basic-default-name" placeholder="Last Name">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-company">Designation</label>
                                                    <div class="col-sm-10">
                                                        <input name="designation" type="text" class="form-control" id="basic-default-company" placeholder="Designation">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-email">Email</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <input name="email" type="email" id="basic-default-email" class="form-control" placeholder="okratul21@gmail.com">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-phone">Phone No</label>
                                                    <div class="col-sm-10">
                                                        <input name="phone" type="number" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-message">Joining Date</label>
                                                    <div class="col-sm-10">
                                                        <input name="joining_date" class="form-control" type="date" value="2021-06-18" id="html5-date-input">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-message">Date Of Barth</label>
                                                    <div class="col-sm-10">
                                                        <input name="date_of_birth" class="form-control" type="date" value="2021-06-18" id="html5-date-input">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-message">Nid Image</label>
                                                    <div class="col-sm-10">
                                                        <input name="nid_img" class="form-control" type="file" id="formFile">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 text-light col-form-label" for="basic-default-message">Profile Pic</label>
                                                    <div class="col-sm-10">
                                                        <input name="pro_img" class="form-control" type="file" id="formFile">
                                                    </div>
                                                </div>
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary">Send</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-5 p-5">
                            <div class="row">
                                <div class="col-6">
                                    <h4>Password Reset</h4>
                                    <div class="password-reset-form">
                                        <form method="POST" action="{{ route('user-reset-password') }}">
                                            @csrf
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-light" for="old_password">Old Password</label>
                                                <div class="col-sm-10">
                                                    <input name="old_password" type="password" class="form-control" id="old_password" placeholder="Old Password">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-light" for="password">New Password</label>
                                                <div class="col-sm-10">
                                                    <input name="password" type="password" class="form-control" id="password" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-light" for="password_confirmation">Confirm Password</label>
                                                <div class="col-sm-10">
                                                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-success" type="submit">
                                                    Submit
                                                </button>
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

    </div>

</div>

@include('user.partials.layoutEnd')

