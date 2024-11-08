@include('partials.layoutHead')

<div id="bg">
    <canvas></canvas>
    <canvas></canvas>
    <canvas></canvas>
</div>

<!-- / Content -->
<div class="container d-flex align-items-center justify-content-center" style="height: 850px">
    <div class="authentication-wrapper authentication-basic container-p-y ">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card text-white" style="background: rgba(0,0,0,0.5)">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center p-4">
                        <a href="#" class="app-brand-link gap-2">
                           <img src="{{asset('images/12356.png')}}" class="img-fluid">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2 text-white">Welcome to E-smart CRM 👋</h4>
                    <p class="mb-4">Admin Login</p>
                        @include('error')
                    <form id="formAuthentication" class="mb-3" action="{{route('admin-login')}}" method="POST">

                        {{csrf_field()}}
                        <div class="mb-3">
                            <label for="username" class="form-label text-white">Username</label>
                            <input
                                type="text"
                                class="form-control "
                                id="username"
                                name="username"
                                placeholder="Enter your email or username"
                                autofocus
                            />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label text-white" for="password">Password</label>
                                <a href="#">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>New on our platform?</span>
                    </p>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>

@include('partials.layoutEnd')
