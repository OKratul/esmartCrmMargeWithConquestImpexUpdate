@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('user.partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="text-center">
                                <h3>List Of Email Accounts</h3>
                            </div>
                            <div class="card">
                                <h5 class="card-header">Dark Table head</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-dark">
                                        <tr class="text-white">
                                            <th>SL</th>
                                            <th>Email Accounts</th>
                                            <th>Inbox</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach($accounts as $key=> $account)
                                             <tr>
                                                 <td>
                                                     {{$loop->iteration}}
                                                 </td>
                                                 <td>
                                                     <a class="" href="{{route('user-fetch-mail-folders',[$account->id])}}">
                                                         {{$account->username}}
                                                     </a>
                                                 </td>
                                                 <td>

                                                 </td>
                                                 <td>

                                                 </td>
                                                 <td>

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
@include('partials.layoutEnd')
