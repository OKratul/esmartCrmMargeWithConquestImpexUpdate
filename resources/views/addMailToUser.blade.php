@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')


            <div class="content-wrapper">

                {{--   =====   Content ===--}}

                <div class="container-xxl flex-grow-1 container-p-y">
                    @include('error')
                    @include('success')
                    <div class="row">
                        <div class="col-12 card p-3">
                            <div class="user-profile">
                                <div class="bg-dark text-center pt-2 pb-2 rounded">
                                    <h3 class="text-white m-0">Add Mail</h3>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card mb-4 mt-3">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0">Mail Configuration</h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="POST" action="{{route('add-mail-to-user',[$id])}}">
                                                    {{csrf_field()}}
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-name">Host</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="host" class="form-control" id="basic-default-name" placeholder="imap.example.com">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-company">Port</label>
                                                        <div class="col-sm-10">
                                                            <input name="port" type="text" class="form-control" id="basic-default-company" value="993">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-company">SMTP Port</label>
                                                        <div class="col-sm-10">
                                                            <input name="smtp_port" type="text" class="form-control" id="basic-default-company" value="993">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-email">Encryption</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group input-group-merge">
                                                                <input name="encryption" type="text" id="basic-default-email" class="form-control" placeholder="SSL/TLS" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-phone">User Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="username" id="basic-default-phone" class="form-control phone-mask" placeholder="user1@example.com">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-message">Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="password" id="basic-default-phone" class="form-control phone-mask" placeholder="*************">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="basic-default-message">Protocol</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="protocol" id="basic-default-phone" class="form-control phone-mask" placeholder="imap">
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end">
                                                        <div class="col-sm-10">
                                                            <button type="submit" class="btn btn-primary">Add <i class='bx bx-plus menu-icon'></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="card mb-4">
                                            <table class="table table-dark">
                                                <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Username</th>
                                                    <th>Pass</th>
                                                    <th>Host</th>
                                                    <th>Port</th>
                                                    <th>Encryption</th>
                                                    <th>protocol</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    @foreach($mails as $key=> $mail)
                                                        <tr>
                                                            <td>
                                                                {{$loop->iteration}}
                                                            </td>
                                                            <td>
                                                               {{$mail->username}}
                                                            </td>
                                                            <td>
                                                                {{$mail->password}}
                                                            </td>
                                                            <td>
                                                                {{$mail->host}}
                                                            </td>
                                                            <td>
                                                                {{$mail->port}}
                                                            </td>
                                                            <td>
                                                                {{$mail->encryption}}
                                                            </td>
                                                            <td>
                                                                {{$mail->protocol}}
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">
                                                                    <a href="{{route('view-edit-email',[$id,$mail->id])}}" class="text-white">
                                                                        Edit
                                                                    </a>
                                                                </button>
                                                                <button class="btn btn-danger btn-sm" onclick="confirm('Are You sure You Want To Delete This Email')">
                                                                    <a href="" class="text-white">
                                                                        Delete
                                                                    </a>
                                                                </button>
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

</div>

@include('partials.layoutEnd')
