// Initial page state: everything (except treatment type) hidden
$('#treatment').hide();
$('#date').hide();
$('#data').hide();
$('#personal-data').hide();
$('#overview').hide();


// Switching from type to treatment
$('#type-next-btn').click(() => {
  $('#treatment-type').hide();
  $('#treatment').show();
})

// Switching from treatment to type
$('#treatment-back-btn').click(() => {
  $('#treatment').hide();
  $('#treatment-type').show();
})


// Switching from treatment to date
$('#treatment-next-btn').click(() => {
  $('#treatment').hide();
  $('#date').show();
})

// Switching from date to treatment
$('#date-back-btn').click(() => {
  $('#date').hide();
  $('#treatment').show();
})


// Switching from date to personal data
$('#date-next-btn').click(() => {
  $('#date').hide();
  $('#personal-data').show();
})

// Switching from personal data to date
$('#data-back-btn').click(() => {
  $('#personal-data').hide();
  $('#date').show();
})


// Switching from personal data to overview
$('#data-next-btn').click(() => {
  $('#personal-data').hide();
  $('#overview').show();
})

// Switching from overview to personal data
$('#overview-back-btn').click(() => {
  $('#overview').hide();
  $('#personal-data').show();
})
