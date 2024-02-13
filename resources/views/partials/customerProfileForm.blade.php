<form method="POST" 
     @if(request()->routeIs('user-customer-profile'))
          action="{{route('user-customer-update',[$customer->id])}}"
      @else
          action="{{route('customer-update',[$customer->id])}}"
      @endif
    >
    {{csrf_field()}}
    <div class="individual text-left" id="individualCustomer">
        <div class="col-md-10 mb-2">
            <div class="input-group">
                <label class="input-group-text" for="inputGroupSelect01">Select Product type</label>
                <select name="type" id="selectCustomerType">
                    <option selected="">Choose Type</option>
                    <option {{$customer->customer_type == 'individual' ? 'selected' : ''}} value="individual">Individual</option>
                    <option  {{$customer->customer_type == 'company' ? 'selected' : ''}} value="company">Company</option>
                </select>
            </div>
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-fullname">Full Name/Company Name</label>
            <input name="name" type="text" class="form-control" value="{{$customer->name}}">
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-company">Contact Person Name</label>
            <input name="contact_name" type="text" class="form-control" value="{{$customer->contact_name}}">
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-email">Email</label>
            <div class="input-group input-group-merge">
                <input type="email" name="email" class="form-control" value="{{$customer->email}}">
            </div>
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-phone">Phone No</label>
            <input type="text" name="phone" class="form-control phone-mask" value="{{$customer->phone_number}}" >
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-message">Address</label>
            <textarea name="address" class="form-control">
                                                            {{$customer->address}}
                                                        </textarea>
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-email">City</label>
            <div class="input-group input-group-merge">
                <input name="city" type="text" class="form-control" value="{{$customer->city}}">
            </div>
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-email">Country</label>
            <div class="input-group input-group-merge">
                <input type="text" name="country" class="form-control" value="{{$customer->country}}">
            </div>
        </div>
        <div class="mb-2">
            <label class="form-label" for="basic-default-email">Postal Code</label>
            <div class="input-group input-group-merge">
                <input name="postal_code" value="{{$customer->postal_code}}" type="number" class="form-control">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
