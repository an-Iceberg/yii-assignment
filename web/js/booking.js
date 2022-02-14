// Initial page state: everything is hidden (except treatment type)
$('#treatment').hide();
$('#date').hide();
$('#data').hide();
$('#personal-data').hide();
$('#overview').hide();

// Hiding all the error messages
$('#treatment-type-error').hide();
$('#treatment-error').hide();
$('#date-error').hide();



// Switching from type to treatment
$('#type-next-btn').click(() => {
  // Hiding the error whenever the button is clicked makes for a nice effect
  $('#treatment-type-error').fadeOut();

  // Input validation
  // Only proceed, if a radio button has been selected
  if ($('input[name="booking[role]"]').is(':checked'))
  {
    form = $('#booking-form');

    // Ajax call to get all available treatments
    $.ajax('/booking/booking/treatment',{
      async: true,
      method: 'POST',
      data: form.serialize(),
      success: (data, status, jqXHR) =>
      {
        // Puts the returned content into the correct position in the DOM
        $('#treatment-content').html(data);
      },
      error: (jqXHR, status, error) =>
      {
        console.log("Ajax call onto /booking/booking/treatment failed");
        console.log(error);
        $('#treatment-content').html("<p class=\"alert alert-warning\">Something went wrong with the Ajax call.</p>");
      }
    });

    $('#treatment-type-error').fadeOut();
    // Creates a nice fading effect between the two segments
    $('#treatment-type').fadeOut(400, () => {
      $('#treatment').fadeIn();
    });
  }
  // No radio button was selected
  else
  {
    $('#treatment-type-error').fadeIn();
  }
})

// Switching from treatment to type
$('#treatment-back-btn').click(() => {
  $('#treatment-error').fadeOut();
  $('#treatment-type-error').fadeOut();
  $('#treatment').fadeOut(400, () => {
    $('#treatment-type').fadeIn();
    $('#treatment-content').text('');
  });
})



// Switching from treatment to date
$('#treatment-next-btn').click(() => {
  $('#treatment-error').fadeOut();

  // Resetting the contents of the date and time inputs
  $('#datepicker').val(null);
  $('select[name="booking[time]"').val('');

  // Input validation
  // Only proceed, if a radio button has been selected
  if ($('input[name="booking[treatment]"]').is(':checked'))
  {
    form = $('#booking-form');

    // Ajax call to get all available dates
    $.ajax('/booking/booking/get-holidays', {
      async: true,
      method: 'POST',
      success: (data, status, jqXHR) =>
      {
        let dates = JSON.parse(data);

        // Creates the date picker
        $('#datepicker').datepicker({
          beforeShowDay: (date) => {

            // If the date is a sunday, disable it
            if(date.getDay() == 0)
            {
              return [false, ''];
            }

            // This is a small workaround but it's not tragic
            isHoliday = false;

            // TODO: adjust this to conform to DB changes
            // If the date matches a holiday, set the flag
            dates.forEach(holiday => {
              if (date.getDate() == parseInt(holiday.substring(8,10)) && date.getMonth() == parseInt(holiday.substring(5,7)) - 1 && date.getFullYear() == parseInt(holiday.substring(0,4)))
              {
                isHoliday = true;
              }
            });

            // Disable the date
            if (isHoliday)
            {
              return [false, ''];
            }

            return [true, ''];
          },
          minDate: 0,
          maxDate: '+6m',
          dateFormat: 'yy-mm-dd',
          showAnim: 'slideDown',
          changeMonth: true,
          changeYear: true,

          // When the date gets selected, fetch the booking times
          onSelect: (dateText, inst) =>
          {
            $.ajax('/booking/booking/get-bookings', {
              async: true,
              method: 'POST',
              data: form.serialize(),
              success: (data, status, jqXHR) => {
                let times = JSON.parse(data);

                // Resetting the contents of the time input
                $('select[name="booking[time]"').val('');

                // Enabling all options upon date change (except the placeholder text)
                $('option').attr({'disabled': false});
                $('option[value=""]').attr({'disabled': true});

                // Disable the times that have already been booked
                times.forEach(time => {
                  $('option[value="'+time+'"]').attr({'disabled': true});
                })
              },
              error: (jqXHR, status, error) =>
              {
                console.log("Ajax call onto /booking/booking/get-bookings failed");
                console.log(error);
                $('#date-content').html("<p class=\"alert alert-warning\">Something went wrong with the Ajax call.</p>")
              }
            })
          }
        });
      },
      error: (jqXHR, status, error) =>
      {
        console.log("Ajax call onto /booking/booking/get-holidays failed");
        console.log(error);
        $('#date-content').html("<p class=\"alert alert-warning\">Something went wrong with the Ajax call.</p>")
      }
    });

    $('#treatment-error').fadeOut();
    $('#treatment').fadeOut(400, () => {
      $('#date').fadeIn();
    });
  }
  // No radio button was selected
  else
  {
    $('#treatment-error').fadeIn();
  }
})

// Switching from date to treatment
$('#date-back-btn').click(() => {
  $('#treatment-error').fadeOut();
  $('#date').fadeOut(400, () => {
    $('#treatment').fadeIn();
  });
})



// Switching from date to personal data
$('#date-next-btn').click(() => {
  $('#date-error').fadeOut();

  dateRegex = /\d{4}-\d{2}-\d{2}/;

  // Input validation
  date = $('input[name="booking[date]"]').val();
  time = $('select[name="booking[time]"]').val();

  // Only proceed, if none of the selected values are empty
  if (date != '' && time != null && dateRegex.test(date))
  {
    $('#date-error').fadeOut();
    $('#date').fadeOut(400, () => {
      $('#personal-data').fadeIn();
    });
  }
  // At least one value is empty
  else
  {
    $('#date-error').fadeIn();
  }

})

// Switching from personal data to date
$('#data-back-btn').click(() => {
  $('#date-error').fadeOut();
  $('#personal-data').fadeOut(400, () => {
      $('#date').fadeIn();
  });
})



// Switching from personal data to overview
$('#data-next-btn').click(() => {

  let salutation = $('select[name="booking[patient_salutation]"]');
  let firstName = $('input[name="booking[patient_firstName]"]');
  let lastName = $('input[name="booking[patient_lastName]"]');
  let birthdate = $('input[name="booking[patient_birthdate]"]');
  let street = $('input[name="booking[patient_street]"]');
  let zipCode = $('input[name="booking[patient_zipCode]"]');
  let city = $('input[name="booking[patient_city]"]');
  let phoneNumber = $('input[name="booking[patient_phoneNumber]"]');
  let email = $('input[name="booking[patient_email]"]');
  let newPatient = $('select[name="booking[newPatient]"]');
  let callback = $('select[name="booking[callback]"]');

  let nameRegex = /^[a-zA-Z\-\s]{1,50}$/;
  let streetRegex = /^[a-zA-Z0-9.\-\s]{1,50}$/;
  let zipRegex = /^\d{1,10}$/;
  let cityRegex = /^[a-zA-Z0-9\-.\s]{1,50}$/;
  let phoneRegex = /^[0-9\-\s+]{1,16}$/;
  let emailRegex = /^[a-zA-Z.!#$%&'*+\-/=?^_`{|]{1,64}@[a-zA-Z0-9.\-]{1,255}\.[a-z]{1,255}$/;

  let allInputIsValid = true;

  // Input validation
  // Salutation
  if (salutation.val() == null) {
    salutation.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    salutation.css('border-color', '#ced4da');
  }

  // First name
  // Mark the input field red if it's empty or it does not match the regex
  if (firstName.val() == '' || !nameRegex.test(firstName.val())) {
    firstName.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    firstName.css('border-color', '#ced4da');
  }

  // Last name
  if (lastName.val() == '' || !nameRegex.test(lastName.val())) {
    lastName.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    lastName.css('border-color', '#ced4da');
  }

  // Birthdate
  if (birthdate.val() == '') {
    birthdate.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    birthdate.css('border-color', '#ced4da');
  }

  // Street
  if (street.val() == '' || !streetRegex.test(street.val())) {
    street.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    street.css('border-color', '#ced4da');
  }

  // Postal code
  if (zipCode.val() == '' || !zipRegex.test(zipCode.val())) {
    zipCode.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    zipCode.css('border-color', '#ced4da');
  }

  // City
  if (city.val() == '' || !cityRegex.test(city.val())) {
    city.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    city.css('border-color', '#ced4da');
  }

  // Phone number
  if (phoneNumber.val() == '' || !phoneRegex.test(phoneNumber.val())) {
    phoneNumber.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    phoneNumber.css('border-color', '#ced4da');
  }

  // E-Mail
  if (email.val() == '' || !emailRegex.test(email.val())) {
    email.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    email.css('border-color', '#ced4da');
  }

  // New patient
  if (newPatient.val() == null) {
    newPatient.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    newPatient.css('border-color', '#ced4da');
  }

  // callback
  if (callback.val() == null) {
    callback.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    callback.css('border-color', '#ced4da');
  }

  // Only moving on to the overview if all data is valid
  if (allInputIsValid) {

    // Injecting all the input data into the overview section
    $('#overview>.content').html(
      `<dt class="col-sm-3">Treatment type</dt>
      <dd class="col-sm-9">
        ${$('input[name="booking[role]"]').val()}
      </dd>

      <dt class="col-sm-3">Treatment</dt>
      <dd class="col-sm-9">
        ${$('input[name="booking[treatment]"]').val()}
      </dd>

      <dt class="col-sm-3">Booking Date and Time</dt>
      <dd class="col-sm-9">
        ${$('input[name="booking[date]"]').val()}
        ${$('select[name="booking[time]"]').val()}
      </dd>

      <dt class="col-sm-3">Patient Information</dt>
      <dd class="col-sm-9">
        <p>
          ${salutation.val()}
          ${firstName.val()}
          ${lastName.val()}
        </p>
        <p>Born
          ${birthdate.val()}
        </p>
        <p>
          ${zipCode.val()}
          ${city.val()}
        </p>
        <p>
          ${street.val()}
        </p>
        <p>
          ${phoneNumber.val()}
        </p>
        <p>
          ${email.val()}
        </p>
      </dd>

      ${$('textarea[name="booking[patient_comment]"]').val() == '' ? '' : '<dt class="col-sm-3">Comment</dt>' + '<dd class="col-sm-9">' + $('textarea[name="booking[patient_comment]"]').val() + '</dd>'}

      <dt class="col-sm-3">New Patient</dt>
      <dd class="col-sm-9">
        ${newPatient.val() == 1 ? 'Yes' : 'No'}
      </dd>

      <dt class="col-sm-3">callback</dt>
      <dd class="col-sm-9">
        ${callback.val() == 1 ? 'Yes' : 'No'}
      </dd>`
    )

    $('#personal-data').fadeOut(400, () => {
      $('#overview').fadeIn();
    });
  }
})

// Switching from overview to personal data
$('#overview-back-btn').click(() => {
  $('#overview').fadeOut(400, () => {
    $('#personal-data').fadeIn();
  });
})
