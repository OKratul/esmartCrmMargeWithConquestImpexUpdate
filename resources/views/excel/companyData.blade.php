<table>
    <thead>
    <tr>
        <h1 style="font-size: 25px">
            All Company Data
        </h1>
    </tr>
    <tr>
        <th>
            Company Name
        </th>
        <th>
            <h1>
                Email
            </h1>
        </th>
        <th>
            <h1>
                Phone Number
            </h1>
        </th>
        <th>
            <h1>
                Address
            </h1>
        </th>

    </tr>
    </thead>
    <tbody>
    @foreach($oldDatas as $data)

        <tr>
            <td>
                Company:-{{$data->name}} <br>
                Customer Name:-{{$data->contact_name}}
            </td>
            <td>
                {{$data->email}}
            </td>
            <td>
                {{$data->phone_number}}
            </td>
            <td>
                {{$data->address}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
