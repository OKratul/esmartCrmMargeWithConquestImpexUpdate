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
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <button class="btn btn-lg font-16 btn-success w-100" id="btn-new-event"><i class="fa fa-plus me-1"></i> Create New</button>

                            <div id="external-events">
                                <br>
                                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                <div class="external-event bg-primary" data-class="bg-primary">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>New Theme Release
                                </div>
                                <div class="external-event bg-pink" data-class="bg-pink">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>My Event
                                </div>
                                <div class="external-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Meet manager
                                </div>
                                <div class="external-event bg-purple" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Create New theme
                                </div>
                            </div>

                            <!-- checkbox -->
                            <div class="form-check mt-3">
                                <input type="checkbox" class="form-check-input" id="drop-remove">
                                <label class="form-check-label" for="drop-remove">Remove after drop</label>
                            </div>

                        </div> <!-- end col-->

    @include('error')
    @include('success')
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-body">

                                    <div id="calendar"></div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                    </div>  <!-- end row -->


                    <!-- Add New Event MODAL -->
                    <div class="modal fade" id="event-modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header py-3 px-4 border-bottom-0 d-block">
                                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <h5 class="modal-title" id="modal-title">Event</h5>
                                </div>
                                <div class="modal-body px-4 pb-4 pt-0">
                                    <form action="{{route('admin-calendar-add')}}" method="POST" class="needs-validation" name="event-form" id="form-event" novalidate>
                                      @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Event Name</label>
                                                    <input class="form-control" placeholder="Insert Event Name"
                                                           type="text" name="title" id="event-title" required />
                                                    <div class="invalid-feedback">Please provide a valid event name</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select class="form-select" name="category" id="event-category" required>
                                                        <option value="bg-danger" selected>Danger</option>
                                                        <option value="bg-success">Success</option>
                                                        <option value="bg-primary">Primary</option>
                                                        <option value="bg-info">Info</option>
                                                        <option value="bg-dark">Dark</option>
                                                        <option value="bg-warning">Warning</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a valid event category</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6 col-4">
                                                <button type="button" class="btn btn-danger" id="btn-delete-event">Delete</button>
                                            </div>
                                            <div class="col-md-6 col-8 text-end">
                                                <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end modal-content-->
                        </div> <!-- end modal dialog-->
                    </div>
                    <!-- end modal-->
                </div>
                <!-- end col-12 -->
            </div>

        </div> <!-- content -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


@include('partials.rightbar')


@include('partials.layoutEnd')





{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function() {--}}
{{--        var calendarEl = document.getElementById('calendar');--}}

{{--        var calendar = new FullCalendar.Calendar(calendarEl, {--}}
{{--            // Calendar configuration options--}}
{{--            events: {!! json_encode($formattedEvents) !!},--}}
{{--            // Other options--}}
{{--            dateClick: function(info) {--}}
{{--                $('#event_id').val('');--}}
{{--                $('#event-details').val('');--}}
{{--                $('#start_time').val(info.dateStr); // Set clicked date as start_time--}}
{{--                $('#end_date').val(info.dateStr);--}}
{{--                $('#largeModal').modal('show');--}}
{{--                $('#saveButton').text('Save Event');--}}
{{--                $('#deleteButton').hide();--}}
{{--            },--}}
{{--            eventClick: function(info) {--}}
{{--                $('#event_id').val(info.event.id);--}}
{{--                $('#event-details').val(info.event.title);--}}
{{--                $('#start_time').val(info.event.start.toISOString().split('T')[0]);--}}
{{--                $('#end_date').val(info.event.end.toISOString().split('T')[0]);--}}
{{--                $('#largeModal').modal('show');--}}
{{--                $('#saveButton').text('Update Event');--}}
{{--                $('#deleteButton').show();--}}
{{--            }--}}
{{--        });--}}

{{--        calendar.render();--}}

{{--        $('#eventForm').submit(function(e) {--}}
{{--            e.preventDefault();--}}
{{--            var event_id = $('#event_id').val();--}}
{{--            var action = event_id ? "{{ route('admin-calendar-update', ['id' => ':id']) }}" : '' ;--}}
{{--            action = action.replace(':id', event_id);--}}

{{--            $.ajax({--}}
{{--                url: action,--}}
{{--                type: event_id ? 'PUT' : 'POST',--}}
{{--                data: $(this).serialize(),--}}
{{--                success: function(response) {--}}
{{--                    $('#largeModal').modal('hide');--}}
{{--                    calendar.refetchEvents();--}}
{{--                },--}}
{{--                error: function(error) {--}}
{{--                    // Handle error--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        // Delete Event with AJAX--}}
{{--        var deleteButton = document.getElementById('deleteButton');--}}

{{--        deleteButton.addEventListener('click', function() {--}}
{{--            if (confirm("Are you sure you want to delete this event?")) {--}}
{{--                var event_id = $('#event_id').val();--}}
{{--                var deleteUrl = "{{ route('admin-calendar-delete', ['id' => ':id']) }}";--}}
{{--                deleteUrl = deleteUrl.replace(':id', event_id);--}}

{{--                // Redirect to the delete URL--}}
{{--                window.location.href = deleteUrl;--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
