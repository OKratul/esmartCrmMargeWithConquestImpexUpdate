"use strict";

(function($) {
    function CalendarApp() {
        this.$body = $("body");
        this.$modal = $("#event-modal");
        this.$calendar = $("#calendar");
        this.$formEvent = $("#form-event");
        this.$btnNewEvent = $("#btn-new-event");
        this.$btnDeleteEvent = $("#btn-delete-event");
        this.$btnSaveEvent = $("#btn-save-event");
        this.$modalTitle = $("#modal-title");
        this.$calendarObj = null;
        this.$selectedEvent = null;
        this.$newEventData = null;
    }

    CalendarApp.prototype.onEventClick = function(event) {
        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");
        this.$newEventData = null;
        this.$btnDeleteEvent.show();
        this.$modalTitle.text("Edit Event");
        this.$modal.show();
        this.$selectedEvent = event.event;

        $("#event-title").val(this.$selectedEvent.title);
        $("#event-category").val(this.$selectedEvent.classNames[0]);
    };

    CalendarApp.prototype.onSelect = function(event) {
        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");
        this.$selectedEvent = null;
        this.$newEventData = event;
        this.$btnDeleteEvent.hide();
        this.$modalTitle.text("Add New Event");
        this.$modal.show();
        this.$calendarObj.unselect();
    };

    CalendarApp.prototype.init = function() {
        this.$modal = new bootstrap.Modal(document.getElementById("event-modal"), { keyboard: false });
        var eventsData = [
            { title: "Meeting with Mr. Shreyu", start: new Date($.now() + 158e6), end: new Date($.now() + 338e6), className: "bg-warning" },
            { title: "Interview - Backend Engineer", start: new Date($.now()), end: new Date($.now()), className: "bg-success" },
            { title: "Phone Screen - Frontend Engineer", start: new Date($.now() + 168e6), className: "bg-info" },
            { title: "Buy Design Assets", start: new Date($.now() + 338e6), end: new Date($.now() + 4056e5), className: "bg-primary" }
        ];

        var self = this;
        self.$calendarObj = new FullCalendar.Calendar(self.$calendar[0], {
            slotDuration: "00:15:00",
            slotMinTime: "08:00:00",
            slotMaxTime: "19:00:00",
            themeSystem: "bootstrap",
            bootstrapFontAwesome: false,
            buttonText: {
                today: "Today",
                month: "Month",
                week: "Week",
                day: "Day",
                list: "List",
                prev: "Prev",
                next: "Next"
            },
            initialView: "dayGridMonth",
            handleWindowResize: true,
            height: $(window).height() - 200,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            initialEvents: eventsData,
            editable: true,
            droppable: true,
            selectable: true,
            dateClick: function(event) {
                self.onSelect(event);
            },
            eventClick: function(event) {
                self.onEventClick(event);
            }
        });
        self.$calendarObj.render();

        self.$btnNewEvent.on("click", function(event) {
            self.onSelect({ date: new Date(), allDay: true });
        });

        // self.$formEvent.on("submit", function(event) {
        //     event.preventDefault();
        //     var form = self.$formEvent[0];
        //     if (form.checkValidity()) {
        //         if (self.$selectedEvent) {
        //             self.$selectedEvent.setProp("title", $("#event-title").val());
        //             self.$selectedEvent.setProp("classNames", [$("#event-category").val()]);
        //         } else {
        //             var eventData = {
        //                 title: $("#event-title").val(),
        //                 start: self.$newEventData.date,
        //                 allDay: self.$newEventData.allDay,
        //                 className: $("#event-category").val()
        //             };
        //             self.$calendarObj.addEvent(eventData);
        //         }
        //         self.$modal.hide();
        //     } else {
        //         event.stopPropagation();
        //         form.classList.add("was-validated");
        //     }
        // });

        self.$btnDeleteEvent.on("click", function(event) {
            if (self.$selectedEvent) {
                self.$selectedEvent.remove();
                self.$selectedEvent = null;
                self.$modal.hide();
            }
        });
    };

    $.CalendarApp = new CalendarApp();
    $.CalendarApp.init();
})(window.jQuery);

// Form Submit Code

$.CalendarApp = new CalendarApp();
$.CalendarApp.init();

// Event listener for form submission
$("#form-event").on("submit", function(event) {
    event.preventDefault();
    var formData = $(this).serialize(); // Serialize form data
    $.ajax({
        type: "POST",
        url: "{{ route('route_name_for_addEvent') }}", // Replace 'route_name_for_addEvent' with the actual route name
        data: formData,
        success: function(response) {
            console.log(response);
            // Handle success response here, for example, show a success message
            alert("Event added successfully!");
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Handle error response here, for example, show an error message
            alert("Error adding event. Please try again later.");
        }
    });
});


