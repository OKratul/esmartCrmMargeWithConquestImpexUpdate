@include('partials.layoutHead')
@php
    $admin = \App\Models\CrmAdmin::where('id',\Illuminate\Support\Facades\Auth::guard('admin')->id())->first();
@endphp

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
                    @include('error')
                    @include('success')
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin-settings')}}"><i class="bx bx-user me-1"></i> Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('view-admin-options')}}"><i class="bx bx-bell me-1"></i>Options</a>
                                </li>
                            </ul>
                            <div class="card mb-4">
                                <!-- Account -->
                                <div class="card-body">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div class="button-wrapper">
                                            @if(!empty($profileInfos))
                                                <img src="{{$profileInfos['pro_img']}}" alt="user-avatar" class="d-block rounded" height="150" width="150" id="uploadedAvatar">
                                            @else
                                                <img src="{{ asset('Asset/img/avatars/5.png') }}" class="d-block rounded" height="150" width="150">
                                            @endif
                                                <form action="{{route('admin-profile-update')}}" method="POST" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <label for="upload" class="btn btn-primary me-2 mb-3 mt-1" tabindex="0">
                                                    <span class="d-none d-sm-block">Upload new photo</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                    <input name="pro_img" type="file" id="upload" class="account-file-input" hidden="" accept="image/png,image/jpeg,image/jpg,image/gif">
                                                </label>

                                                <div class="d-flex">
                                                    <div>
                                                        <input required value="{{$admin->username}}" class="form-control" type="text" id="firstName" name="name" placeholder="your name" autofocus=""><br>
                                                        <input required value="{{$admin->email}}" class="form-control" type="text" id="firstName" name="email" placeholder="your name" autofocus="">
                                                    </div>
                                                    <button class="btn btn-primary ml-2" type="submit">
                                                        <i class='bx bx-check' style="font-size: 25px"></i>
                                                    </button>
                                                </div>

                                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0">

                                <!-- /Account -->
                            </div>
                            <div class="card">
                                <h5 class="card-header">Delete Account</h5>
                                <div class="card-body">
                                    <div class="mb-3 col-12 mb-0">
                                        <div class="alert alert-warning">
                                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                                            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                                        </div>
                                    </div>
                                    <form id="formAccountDeactivation" onsubmit="return false">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
                                            <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                                        </div>
                                        <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
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

@include('partials.layoutEnd')
