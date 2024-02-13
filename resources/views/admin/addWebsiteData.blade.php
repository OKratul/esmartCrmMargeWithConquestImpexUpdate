@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">

                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h3 class="mb-0">Add Your Website Data</h3>
                            <small class="text-muted float-end">Default label</small>
                        </div>
                        @include('error')
                        @include('success')
                        <div class="card-body">
                            <form method="POST" action="{{route('site-added')}}">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Domain Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="domain" class="form-control" id="basic-default-name" placeholder="https://rental.esmart.com.bd/">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-company">Consumer_Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="consumer_key" class="form-control" id="basic-default-company" placeholder="'ck_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-email">Consumer_secret</label>
                                    <div class="col-sm-10">
                                        <div class="input-group input-group-merge">
                                            <input type="text" name="consumer_secret" id="basic-default-email" class="form-control" placeholder="cs_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" aria-label="john.doe" aria-describedby="basic-default-email2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary"><i class="bx bx-globe me-1"></i>Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">All website</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Client_key</th>
                                    <th>Client_secret</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody class="table-border-bottom-0 pb-5">
                                @foreach($websites as $website)
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{$website->web_domain}}</strong>
                                        </td>
                                        <td style="font-size: 12px">
                                            {{$website->consumer_key}}
                                        </td>

                                        <td style="font-size: 12px">
                                            {{$website->consumer_secret}}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                                </div>
                                            </div>
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

@include('partials.layoutEnd')
