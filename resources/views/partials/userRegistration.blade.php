<div class="card mb-4">
    <h5 class="card-header">Add User/Staff</h5>

    @include('success')
    @include('error')
    <div class="card-body">
        <form method="POST" action="{{route('register-user')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="mb-3 row">
                <label for="html5-text-input" class="col-md-3 col-form-label">User Name</label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="username" id="html5-text-input">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="html5-text-input" class="col-md-3 col-form-label">Password*</label>
                <div class="col-md-9">
                    <input class="form-control" type="password" name="password" id="html5-text-input">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="html5-text-input" class="col-md-3 col-form-label">Confirm Password*</label>
                <div class="col-md-9">
                    <input class="form-control" type="password" name="password_confirmation" id="html5-text-input">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="html5-email-input" class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                    <input class="form-control" type="email" name="email" value="john@example.com" id="html5-email-input">
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Add User
                    <i class='bx bxs-user-plus'></i>
            </div>
        </form>

    </div>
</div>
