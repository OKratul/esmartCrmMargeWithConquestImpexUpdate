<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th>SL</th>
        <th>Customer Name</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Email</th>
        <th>Contact Person</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customers as $index=>$customer)
        <tr>
            <th>{{$customer->id}}</th>
            <td>
                <a href="{{route('conquest-customer-profile',[$customer->id])}}">
                    {{$customer->name}}
                </a>
            </td>
            <td>{{$customer->phone}}</td>
            <td>{{$customer->address}}</td>
            <td>
                Email:- @if($customer->email)
                    {{$customer->email}}
                @else
                    Email Not Found
                @endif<br>
                Email-2:- @if($customer->email2)
                    {{$customer->email2}}
                @else
                    Email-2 Not Found
                @endif
            </td>
            <td>
                Name:- {{$customer->contact_person}}<br>
                Number:- {{$customer->contact_person_number}}
            </td>

        </tr>

    @endforeach
    </tbody>
</table>
