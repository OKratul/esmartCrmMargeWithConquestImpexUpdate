@include('partials.layoutHead')

<div id="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
               <div class="card mt-4">
                   <div class="card-body">
                       <div class="table-responsive text-nowrap">
                           <table class="table ">
                               <thead>
                               <tr class="text-left">
                                   <th>SL</th>
                                   <th>Cash In Account</th>
                                   <th>Invoice No</th>
                                   <th>Customer Name</th>
                                   <th>Ref No</th>
                                   <th>Pay With</th>
                                   <th>Amount</th>
                                   <th>Action</th>
                               </tr>
                               </thead>
                               <tbody class="table-border-bottom-0">
                               @foreach($payments as $key=>$payment)
                                   <tr onclick="" class="payment-row">

                                       <td class="align-middle text-left">
                                           {{$loop->iteration}}
                                       </td>
                                       <td class="text-left">
                                           {{$payment->accounts['bank_name']}} ({{$payment->accounts['account_number']}})
                                       </td>
                                       <td class="align-middle text-left">
                                           @if($payment->invoices)
                                               #{{$payment->invoices['invoice_no']}}
                                           @endif
                                       </td>
                                       <td class="text-left align-middle">
                                           @if(!empty($payment->customers))
                                               {{$payment->customers['name']}}
                                           @endif
                                       </td>
                                       <td class="align-middle text-left">
                                           {{$payment->Ref_no}}
                                       </td>
                                       <td class="align-middle text-left">
                                           {{$payment->payment_with}}
                                       </td>
                                       <td class="align-middle text-left">
                                           {{$payment->amount}} .TK
                                       </td>
                                       <td>
                                           @if(request()->routeIs('admin-all-payments'))
                                               <a href="{{route('admin-single-money_rec',[$payment->id])}}" class="btn btn-sm btn-info ">
                                                   Money.Rec
                                               </a>
                                           @else
                                               <a href="{{route('single-money_rec',[$payment->id])}}" class="btn btn-sm btn-info ">
                                                   Money.Rec
                                               </a>
                                           @endif
                                       </td>

                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                           <div id="payment-details-popup" style="display: none;">
                               <!-- Content of the popup -->
                               <!-- You can customize the layout and add more details here -->
                               <p id="payment-details"></p>
                           </div>

                       </div>
                       {{$payments->links()}}
                   </div>
               </div>
                {{--                            @if()--}}

               </div>
            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')






