@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('user.partials.sidebar')

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">
                    <div class="row">
                        <div class="col-xl-2">
                            @include('user.partials.userMailboxSidebar')
                        </div>
                        <div class="col-xl-10">
                            <div class="card">
                                @include('success')
                                @include('error')
                                <div class="card-body">
                                    <form action="{{route('send-replay',[$mail_id,$uid])}}" method="POST">
                                        {{csrf_field()}}
                                        <div class="mb-3 text-left">
                                            <label for="exampleFormControlInput1" class="form-label">To</label>
                                            <input name="mail_to" type="email" value="{{$to}}" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                        </div>

                                       <div class="mb-3">
                                           <textarea name="message_body" id="editor" rows="10"></textarea>
                                       </div>

                                      <div class="text-right">
                                          <button type="submit" class="btn btn-outline-primary">
                                             Send  <i class='bx bx-send'></i>
                                          </button>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
</script>

@include('partials.layoutEnd')
