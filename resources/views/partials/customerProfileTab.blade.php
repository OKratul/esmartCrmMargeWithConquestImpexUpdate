<div class="tab-content">
    {{--                                                ======= Query Tab =========--}}
    <div class="tab-pane active" id="query-b1">
        <div class="card">
            <div class="card-body">
                @include('partials.customerProfileQuery')
            </div>
        </div>
    </div>
    {{--                                                ======== Quotation Tab =========--}}
    <div class="tab-pane" id="quotation-b1">
        <div class="card">
            <div class="card-body">
                @include('partials.customerProfileQuotations')
            </div>
        </div>
    </div>
    {{--                           ================ Invoice Tab ===============--}}
    <div class="tab-pane" id="invoice-b1">
        @include('partials.customerProfileInvoice')
    </div>
</div>
