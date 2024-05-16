<table class="table table-striped mb-0">
    <thead>
    <tr>
        <th>Sl</th>
        <th>Date</th>
        <th>Invoice No</th>
        <th>Customer Name</th>
        <th>Product Name</th>
        <th>Paid Amount</th>
        <th>Due Amount</th>
        <th>Total Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $index=>$invoice)
        <tr>
            <td>
                {{$loop->iteration}}
            </td>
            <td>{{$invoice->created_at->format('dM Y ')}}</td>
            <td>#{{$invoice->invoice_number}}</td>
            <td>
                @if(!empty($invoice->customers))
                    {{$invoice->customers['name']}}
                @endif
            </td>
            <td>
                @php
                    $productCodes = explode('+', $invoice->product_id);
                    $productNames =[];
                        foreach ($productCodes as $productCode){
                            $productNames[] = \App\Models\conquest\ConquestProduct::where('product_code',$productCode)->first();
                        }
                @endphp

                @foreach($productNames as $productName)
                    {{$productName->name}}<br>
                @endforeach
            </td>

            <td>
                $ {{$invoice->paid ??'0'}}
            </td>
            <td>
                $ {{$invoice->due ?? '0'}}
            </td>
            <td>
                $ {{$invoice->all_total_price}}
            </td>

        </tr>


    @endforeach
    </tbody>
</table>
