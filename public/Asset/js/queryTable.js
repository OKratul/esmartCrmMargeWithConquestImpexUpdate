//=====Note Submit Form========
//
// $(document).ready(function () {
//
//   $(document).on('click','#add-note-button',function (e){
//       e.preventDefault();
//
//       let notes = $('#modal-note').val();
//
//       $.ajax({
//           url:"{{route('admin-add-note',[$query->customers['id'],$query->id])}}",
//           method:'post',
//           data:{notes:notes},
//           success:function (res){
//
//           },error:function (res){
//
//           }
//       })
//
//   })
//
// });



// $(document).ready(function () {
//     $(document).on('click', '#pagination-container a', function (e) {
//         e.preventDefault();
//
//         var url = $(this).attr('href');
//
//         $.ajax({
//             url: url,
//             success: function (data) {
//               var newData = $('#table-content').html(data);
//
//               // console.log(data);
//             }
//
//         });
//     });
// });

//
// $(document).ready(function () {
//     $(document).on('click', '#pagination-container a', function (e) {
//         e.preventDefault();
//
//         var url = $(this).attr('href');
//         var queryDateForm = $('#query_date_form').val();
//         var queryDateTo = $('#query_date_to').val();
//         var status = $('#status').val();
//
//         $.ajax({
//             url: url,
//             data: {
//                 queryDateForm: queryDateForm,
//                 queryDateTo: queryDateTo,
//                 status: status,
//             },
//             success: function (data) {
//                 var newData = $(data); // Convert the response to a jQuery object
//
//                 // Update the content inside the specific elements
//                 $('#table-content').html(newData.find('#table-content').html());
//                 // Update the filter values in the form if needed
//                 // $('#query_date_form').val(queryDateForm);
//                 // $('#query_date_to').val(queryDateTo);
//                 // $('#status').val(status);
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 console.error('Error loading page:', textStatus, errorThrown);
//             }
//         });
//     });
// });


// $(document).ready(function () {
//     $(document).on('click', '#pagination-container a', function (e) {
//         e.preventDefault();
//
//         var url = $(this).attr('href');
//
//         $.ajax({
//             url: url,
//             success: function (data) {
//                 var newData = $(data); // Convert the response to a jQuery object
//
//                 // Update the content inside the specific elements
//                 $('#query-table-body').html(newData.find('#query-table-body').html());
//                 $('#pagination-container').html(newData.find('#pagination-container').html());
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 console.error('Error loading page:', textStatus, errorThrown);
//             }
//         });
//     });
// });

