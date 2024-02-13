@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    <div class="row">
                        <div class="col-xl-2">
                            @include('user.partials.userMailboxSidebar')
                        </div>
                        <div class="col-xl-10">
                            <div class="card">
                                <h5 class="card-header">Table Basic</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>From</th>
                                            <th>Subject</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach($messages as $message)
                                                    <tr>
                                                        <td class="text-left badge bg-label-primary">
                                                            {{$message->getFrom()[0]->mail}}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ Str::limit($message->getSubject(), 40) }}
                                                        </td>
                                                        <td>
                                                            <a class="btn" href="{{route('single-mail',[$mail_id,$message->getUid()])}}">
                                                                <i class='bx bx-envelope' style="font-size: 30px"></i>
                                                            </a>
                                                            <a href="{{route('user-mail-replay',[$mail_id,$message->getUid()])}}" class="btn">
                                                                <i class='bx bx-reply' style="font-size: 30px" ></i>
                                                            </a>
                                                            <a href="" class="btn">
                                                                <i class='bx bx-trash-alt' style="font-size: 30px"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div>
                                        {{$messages->links()}}
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
