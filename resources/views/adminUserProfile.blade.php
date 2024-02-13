@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')


            <div class="content-wrapper">

                {{--   =====   Content ===--}}

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-12 card p-3">
                            <div class="user-profile">
                                @foreach($users as $user)
                                   <div class="row bg-dark rounded">
                                        <div class="col-xl-11 align-middle pt-2">
                                            <h3 class="text-center rounded text-capitalize text-lighter">
                                                <strong>{{$user->name}}</strong><br>Sell Information
                                            </h3>
                                        </div>
                                       <div class="col-xl-1">
                                           <div class="demo-inline-spacing">
                                               <div class="btn-group">
                                                   <button type="button" class="btn btn-lg btn-outline-light btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                       <i class='bx bx-cog' style="font-size: 25px"></i>
                                                   </button>
                                                   <ul class="dropdown-menu dropdown-menu-end" style="">
                                                       <li><a class="dropdown-item" href="{{route('add-mail-user',[$user->id])}}"><i class='bx bx-mail-send menu-icon' ></i>Add Mail Account</a></li>
                                                       <li><a class="dropdown-item" href="">Another action</a></li>
                                                       <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                                       <li>
                                                           <hr class="dropdown-divider">
                                                       </li>
                                                       <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                                                   </ul>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                    <div class="row">
                                        <div class="col-4 p-4">
                                            <a href="" class="text-decoration-none user-account-card">
                                                <div class="card p-3 bg-label-primary ">
                                                    <div class="d-flex justify-content-between">
                                                        <h5>Quotations</h5>
                                                        @php
                                                            $quotations=$user->quotations;
                                                            $totalQuot= count($quotations)
                                                        @endphp
                                                        <h4>{{$totalQuot}}</h4>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        @php
                                                            $totalQuotAmount = 0;
                                                               foreach ( $quotations as $quotation){
                                                                   $quotProducts = (json_decode($quotation->products,true));
                                                                   foreach ($quotProducts as $quotProduct){
                                                                       $quantity = floatval($quotProduct['quantity']);
                                                                       $unitPriceVat =floatval($quotProduct['unit_price'] ) * floatval($quotation->vat_tax) /100 ;
                                                                       $unitPriceVat = ceil($unitPriceVat) ;

                                                                       $totalQuotAmount += $unitPriceVat * $quantity;
                                                                   }
                                                               }
                                                        @endphp
                                                        <h5>Total Amount of Quotations</h5>
                                                        <h4>${{$totalQuotAmount}}</h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        @php
                                            $totalInvoAmount = 0;
                                               foreach ($invoices as $invoice) {
                                                   $invoProducts = json_decode($invoice->products, true);
                                                   foreach ($invoProducts as $invoProduct) {
                                                       $invoQuantity = $invoProduct['quantity'];
                                                       $invoUnitPriceVat = $invoProduct['unit_price'] * (is_numeric($invoice->vat_tax) ? $invoice->vat_tax : 0) / 100;
                                                       $invoPriceVat = ceil($invoUnitPriceVat);

                                                       if (is_numeric($invoQuantity) && is_numeric($invoUnitPriceVat)) {
                                                           $totalInvoAmount += $invoUnitPriceVat * $invoQuantity;
                                                       }
                                                   }
                                               }
                                        @endphp
                                        <div class="col-4 p-4">
                                            <a href="" class="user-account-card text-decoration-none">
                                                <div class="card p-3 bg-label-success">
                                                    <div class="d-flex justify-content-between">
                                                        <h5>Invoices</h5>
                                                        <h4>
                                                            {{$totalInvo}}
                                                        </h4>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <h5>Total Amount Of Invo.</h5>
                                                        <h4>
                                                            ${{ceil($totalInvoAmount)}}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                            $queries = $user->queries;
                                            $totalQueries = count($queries);
                                        @endphp
                                            <div class="col-4 p-4">
                                               <a href="" class="user-account-card text-decoration-none">
                                                   <div class="card p-3 bg-label-info">
                                                       <div class="d-flex justify-content-between align-items-center">
                                                           <h5>Queries</h5>
                                                           <h4>
                                                               {{$totalQueries}}
                                                           </h4>
                                                       </div>
                                                   </div>
                                               </a>
                                            </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-xl-12">
                                            <h3 class="text-center bg-dark rounded text-capitalize text-lighter p-3">User Login Info And Attendance</h3>
                                            <div class="card">
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table-dark">
                                                        <thead>
                                                        <tr>
                                                            <th>Users Name</th>
                                                            <th>E-mails</th>
                                                            <th>Status</th>
                                                            <th>Login Time</th>
                                                            <th>LogOut Time</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="table-border-bottom-0">
                                                        <tr>
                                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
                                                            <td>Albert Cook</td>
                                                            <td>
                                                                <span class="badge bg-label-primary me-1">Active</span>
                                                            </td>
                                                            <td>

                                                            </td>
                                                            <td>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
