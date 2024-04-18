@include('partials.layoutHead')

<div id="wrapper">

    @include('user.partials.navbar')
    @include('user.partials.sidebar')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h2 class="card-title text-primary">
                                            @if(now()->format('H:i') < '12:00')
                                                Good Morning 🎉</h2>
                                        @elseif(now()->format('H:i') < '17:00')
                                            Good Afternoon 🎉</h2>
                                        @else
                                            Good Evening 🎉</h2>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @include('partials.allQueriesTable')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('user.partials.rightbar')


@include('partials.layoutEnd')


<script>
    let addQueryNoteButtons = document.querySelectorAll('.add-query-note');

    addQueryNoteButtons.forEach((noteButton) => {
        noteButton.addEventListener('click', () => {
            let noteFormRow = noteButton.closest('tr').nextElementSibling;
            if (noteFormRow) {
                noteFormRow.classList.remove('d-none');
            }
        });
    });

    let removeQueryNoteForms = document.querySelectorAll('.remove-query-note-form');

    removeQueryNoteForms.forEach((removeButton) => {
        removeButton.addEventListener('click', () => {
            let noteFormRow = removeButton.closest('tr');
            if (noteFormRow) {
                noteFormRow.classList.add('d-none');
            }
        });
    });
</script>



