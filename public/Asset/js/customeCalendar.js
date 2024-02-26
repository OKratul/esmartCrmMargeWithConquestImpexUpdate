
//Add Date input to Form

var dateInput = document.createElement("input");

// Set attributes for the date input
dateInput.setAttribute("type", "date");
dateInput.setAttribute("id", "event-date");
dateInput.setAttribute("name", "end_date");
dateInput.setAttribute("class", "form-control");
// dateInput.setAttribute("required", "");

// Create a new div to contain the date input
var dateInputGroup = document.createElement("div");
dateInputGroup.classList.add("col-md-12", "col-8", "mb-3");

// Append the date input to the new div
dateInputGroup.appendChild(dateInput);

// Find the parent element where you want to insert the new div
var buttonsParent = document.querySelector('.text-end');

// Insert the new div containing the date input before the buttons parent element
buttonsParent.parentNode.insertBefore(dateInputGroup, buttonsParent);


//
// $(document).ready(function () {
//     $('#form-event').submit(function (event) {
//         // Prevent the default form submission
//         event.preventDefault();
//
//         // Collect form data
//         var formData = {
//             title: $('#event-title').val(),
//             category: $('#event-category').val(),
//
//             // Add other form fields here if needed
//         };
//
//         // Send the data using AJAX
//         $.ajax({
//             type: 'POST',
//             url: "{{ route('admin-calendar-add') }}", // Assuming you are using Blade syntax
//             data: formData,
//             success: function (data) {
//                 // Handle success response here
//                 console.log('Success:', data);
//             },
//             error: function (xhr, status, error) {
//                 // Handle error response here
//                 console.error('Error:', error);
//             }
//         });
//     });
// });
