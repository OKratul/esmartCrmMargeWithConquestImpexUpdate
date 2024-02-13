@include('partials.layoutHead')


<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    @include('error')
                    @include('success')

                    <div class="card">
                        <div class="card-body">
                            <table class="table  table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>User Name</th>
                                    <th>Old Data</th>
                                    <th>Edited Data</th>
                                    <th>Updated At</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach($quotation->histories()->orderByDesc('updated_at')->get() as $key => $history)
                                    @php
                                        $oldData = json_decode($history->old_data, true);
                                        $oldProducts = json_decode($oldData['products'], true);
                                        $newData = json_decode($history->new_data, true);
                                        $newProducts = json_decode($newData['products'], true);
                                    @endphp
                                    <tr class="text-left">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            @if(!empty($history->users['name']))
                                                {{$history->users['name']}}
                                            @else
                                                Admin
                                            @endif
                                        </td>
                                        <td>
                                            <div class="old-data">
                                                @foreach($oldProducts as $oldProduct)
                                                    <strong>Product Info:-</strong>{{$oldProduct['product_name']}}<br>
                                                    Code:- {{$oldProduct['product_code']}}<br>
                                                    Quantity:-{{$oldProduct['quantity']}}.{{$oldProduct['unit']}}<br>
                                                    Unit Price:-{{$oldProduct['unit_price']}}<br>
                                                    Description:-{{$oldProduct['description']}}<br>
                                                    Our Coasting:-{{$oldProduct['our_coasting']}}<br>
                                                    Source:-{{$oldProduct['product_source']}}<br>
                                                    Discount:-{{$oldProduct['product_discount']}}<br>
                                                @endforeach
                                                <strong>Offer Validity:-</strong>{{$oldData['offer_validity']}}<br>
                                                <strong>Warranty:-</strong>{{$oldData['warranty']}}<br>
                                                <strong>Payment Type:-</strong>{{$oldData['payment_type']}}<br>
                                                <strong>Vat & AIT:-</strong>{{$oldData['vat_tax']}}<br>
                                                <strong>Delivery Term:-</strong>{{$oldData['delivery_term']}}<br>
                                                <strong>Other Condition:-</strong>{{$oldData['other_condition']}}<br>
                                                <strong>Delivery Date:-</strong>{{$oldData['delivery_date']}}<br>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="old-data">
                                                @foreach($newProducts as $newProduct)
                                                    <strong>Product Info:-</strong>{{$newProduct['product_name']}}<br>
                                                    Code:- {{$newProduct['product_code']}}<br>
                                                    Quantity:-{{$newProduct['quantity']}}.{{$newProduct['unit']}}<br>
                                                    Unit Price:-{{$newProduct['unit_price']}}<br>
                                                    Description:-{{$newProduct['description']}}<br>
                                                    Our Coasting:-{{$newProduct['our_coasting']}}<br>
                                                    Source:-{{$newProduct['product_source']}}<br>
                                                    Discount:-{{$newProduct['product_discount']}}<br>
                                                @endforeach
                                                <strong>Offer Validity:-</strong>{{$newData['offer_validity']}}<br>
                                                <strong>Warranty:-</strong>{{$newData['warranty']}}<br>
                                                <strong>Payment Type:-</strong>{{$newData['payment_type']}}<br>
                                                <strong>Vat & AIT:-</strong>{{$newData['vat_tax']}}<br>
                                                <strong>Delivery Term:-</strong>{{$newData['delivery_term']}}<br>
                                                <strong>Other Condition:-</strong>{{$newData['other_condition']}}<br>
                                                <strong>Delivery Date:-</strong>{{$newData['delivery_date']}}<br>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $date = new DateTime($newData['updated_at']);
                                                $formattedDate = $date->format('Y-m-d h:i:s A');
                                            @endphp
                                            {{$formattedDate}}
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
