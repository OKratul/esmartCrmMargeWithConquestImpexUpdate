@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-header">Today's Attendance</h5>
                                    <h5 class="card-header">
                                        {{\Carbon\Carbon::now()->format('Y-m-d')}}
                                    </h5>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>sl</th>
                                            <th>User Name</th>
                                            <th>Login Time</th>
                                            <th>Attendance</th>
                                            <th>logout Time</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach($users as $user)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            {{ $user->name }}
                                                        </td>
                                                        <td>
                                                            @if($user->attendances->isNotEmpty())
                                                                {{ \Carbon\Carbon::parse($user->attendances->first()->login_time)->format('h:i A') }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->attendances->isNotEmpty())
                                                                @if(\Carbon\Carbon::parse($user->attendances->first()->login_time)->format('H:i A') > \Carbon\Carbon::createFromFormat('h:i A', '10:30 AM')->format('H:i A'))
                                                                    <span class="badge bg-label-warning me-1">Late</span>
                                                                @else
                                                                    <span class="badge bg-label-success me-1">Present</span>
                                                                @endif
                                                            @else
                                                                <span class="badge bg-label-danger me-1">Absent</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->attendances->isNotEmpty())
                                                                @if($user->attendances->last()->logout_time)
                                                                    {{ \Carbon\Carbon::parse($user->attendances->last()->logout_time)->format('h:i A') }}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-5">
                                <div class="card-body">
                                    <div id='calendar'></div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid'],
            events: [

            ]
        });

        calendar.render();
    });
</script>






