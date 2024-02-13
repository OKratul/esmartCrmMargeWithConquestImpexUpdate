<div class="card mb-4">
    <h5 class="card-header">Add User/Staff</h5>
    <div class="card-body">
      <form method="POST" action="{{route('profile-added',[$id])}}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="mb-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">First Name</label>
              <div class="col-md-4">
                  <input class="form-control" type="text" name="first-name" id="html5-text-input">
              </div>
              <label for="html5-text-input" class="col-md-2 col-form-label">Last Name</label>
              <div class="col-md-4">
                  <input class="form-control" type="text" name="last-name" id="html5-text-input">
              </div>
          </div>

          <div class="mb-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">User Name</label>
              <div class="col-md-10">
                  <input class="form-control" type="text" name="user-name" id="html5-text-input">
              </div>
          </div>

          <div class="mb-3 row">
              <label for="html5-email-input" class="col-md-2 col-form-label">Email</label>
              <div class="col-md-10">
                  <input class="form-control" type="email" name="email" value="john@example.com" id="html5-email-input">
              </div>
          </div>

          <div class="mb-3 row">
              <label for="html5-tel-input" class="col-md-2 col-form-label">Phone</label>
              <div class="col-md-10">
                  <input class="form-control" type="tel" name="phone" value="90-(164)-188-556" id="html5-tel-input">
              </div>
          </div>

          <div class="mb-3 row">
              <label for="html5-date-input" class="col-md-2 col-form-label">Join Date</label>
              <div class="col-md-10">
                  <input class="form-control" type="date" name="join-date" value="2021-06-18" id="html5-date-input">
              </div>
          </div>
          <div class="mb-3 row">
              <label for="html5-date-input" class="col-md-2 col-form-label">Birthday</label>
              <div class="col-md-10">
                  <input class="form-control" type="date" name="birthday-date" value="2021-06-18" id="html5-date-input">
              </div>
          </div>
          <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupFile01">Nid</label>
              <input type="file" class="form-control" name="nid" id="inputGroupFile01">
          </div>

          <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupFile01">Profile Picture</label>
              <input type="file" class="form-control" name="profile-img" id="inputGroupFile01">
          </div>

          <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-primary">Add Profile
                  <i class='bx bxs-user-plus'></i>
              </button>
          </div>
      </form>

    </div>
</div>
