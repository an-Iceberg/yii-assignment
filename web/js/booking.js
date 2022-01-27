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

// Creates the date picker
// To modify the styles, edit the jquery-ui-1.10.0.custom.css
$('#datepicker').datepicker({
  beforeShowDay: (date) => {
    return [(date.getDay() != 0), ''];
  },
  minDate: 0,
  maxDate: '+6m',
  dateFormat: 'yy-mm-dd',
  showAnim: 'slideDown',
  showButtonPanel: true,
  changeMonth: true,
  changeYear: true,
});



// Switching from type to treatment
$('#type-next-btn').click(() => {
  // Hiding the error whenever the button is clicked makes for a nice effect
  $('#treatment-type-error').fadeOut();

  // Input validation
  // Only proceed, if a radio button has been selected
  if ($('input[name="booking[doctor]"]').is(':checked'))
  {
    form = $('#booking-form');

    // Ajax call to get all available treatments
    $.ajax('/site/treatment',{
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
        console.log("Ajax call onto /site/treatment failed");
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

  // Input validation
  // Only proceed, if a radio button has been selected
  if ($('input[name="booking[treatment]"]').is(':checked'))
  {
    form = $('#booking-form');

    // Ajax call to get all available dates
    $.ajax('/site/date', {
      async: true,
      method: 'POST',
      data: form.serialize(),
      success: (data, status, jqXHR) =>
      {
        // Fill in the available dates correctly
      },
      error: (jqXHR, status, error) =>
      {
        console.log("Ajax call onto /site/date failed");
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

  // Input validation
  date = $('input[name="booking[date]"]').val();
  hour = $('select[name="booking[hours]"]').val();
  minute = $('select[name="booking[minutes]"]').val();

  // Only proceed, if none of the selected values are empty
  if (date != '' && hour != null && minute != null)
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
  let recall = $('select[name="booking[recall]"]');

  let nameRegex = /^[a-zA-Z\-\ ]{1,50}$/;
  let streetRegex = /^[a-zA-Z0-9\.\-\ ]{1,50}$/;
  let zipRegex = /^\d{1,10}$/;
  let cityRegex = /^[a-zA-Z0-9\-\.\ ]{1,50}$/;
  let phoneRegex = /^[0-9\-\ \+]{1,16}$/;
  let emailRegex = /^[a-zA-Z\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|]{1,64}@[a-zA-Z0-9\.\-]{1,255}\.[a-z]{1,255}$/;

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

  // Recall
  if (recall.val() == null) {
    recall.css('border-color', '#dc3545');
    allInputIsValid = false;
  } else {
    recall.css('border-color', '#ced4da');
  }

  // Only moving on to the overview if all data is valid
  if (allInputIsValid) {
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
