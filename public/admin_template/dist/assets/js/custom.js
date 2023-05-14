/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";
function updateClock() {
    var currentTime = new Date();
    // Operating System Clock Hours for 12h clock
    var currentHoursAP = currentTime.getHours();
    // Operating System Clock Hours for 24h clock
    var currentHours = currentTime.getHours();
    // Operating System Clock Minutes
    var currentMinutes = currentTime.getMinutes();
    // Operating System Clock Seconds
    var currentSeconds = currentTime.getSeconds();
    // Adding 0 if Minutes & Seconds is More or Less than 10
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
    // Picking "AM" or "PM" 12h clock if time is more or less than 12
    var timeOfDay = (currentHours < 12) ? "AM" : "PM";
    // transform clock to 12h version if needed
    currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
    // transform clock to 12h version after mid night
    currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
    // display first 24h clock and after line break 12h version
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
    // var currentTimeString = "24h kello: " + currentHours + ":" + currentMinutes + ":" + currentSeconds + "" + "<br>" + "12h kello: "    + currentHoursAP + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    // print clock js in div #clock.
    $("#clock_digital").html(currentTimeString);
}
$(document).ready(function () {
    setInterval(updateClock, 1000);
});


$('#datatable1').DataTable({
    responsive: false,
    aLengthMenu: [
        [5, 10, 30, 50, 100, 200, 300, -1],
        [5, 10, 30, 50, 100, 200, 300, "Semua"]
    ],
    pageLength: 5,
    responsive: false,
    language: {
        searchPlaceholder: 'Cari data ...',
        sSearch: '',
        lengthMenu: '_MENU_ Data / Halaman',
    }
});

$('#datatable2').DataTable({
    bLengthChange: false,
    searching: false,
    responsive: true
});

// Select2
// $('.dataTables_length select').select2({
//     minimumResultsForSearch: Infinity
// });

$('.select2').style('width', '100%');

$('#select2-a, #select2-b, .selectatuu').select2({
    minimumResultsForSearch: 10
});

$('#select2-a').on('select2:opening', function (e) {
    $(this).closest('.form-group').addClass('form-group-active');
});

$('#select2-a').on('select2:closing', function (e) {
    $(this).closest('.form-group').removeClass('form-group-active');
});


$(".submit_form").submit(function(event){
    $('button[type=submit]').prop('disabled', true);
    $('button[type=submit]').prepend('<i class="fa fa-clock-o"></i>&nbsp;');
    $('button[type=submit]').removeClass("btn-success");
    $('button[type=submit]').addClass("btn-secondary");
});
