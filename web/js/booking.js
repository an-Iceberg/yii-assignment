// Initial page state: everything is hidden (except treatment type)
$('#treatment').hide();
$('#date').hide();
$('#data').hide();
$('#personal-data').hide();
$('#overview').hide();

// Hiding all the error messages
$('#treatment-type-error').hide();
$('#treatment-error').hide();



// Switching from type to treatment
$('#type-next-btn').click(() => {

  elements = document.getElementsByName('booking[doctor]');
  doctor = '';

  // Puts the value of the selected radio button in 'doctor'
  for (i = 0; i < elements.length; i++)
  {
    if(elements[i].checked)
    {
      doctor = elements[i].value;
      // console.log('doctor:', doctor);
    }
  }

  // Input validation
  // Only go to the next step, if a radio button has been selected
  if (doctor != '')
  {
    // Ajax call to get all available treatments
    $.ajax('/site/treatment',{
      async: true,
      method: 'POST',
      // contentType: 'text/plain', // <- for some reason this makes the request body undetectable in Yii
      data: doctor,
      success: (data, status, jqXHR) =>
      {
        // Puts the returned content into the treatment section
        $('#treatment-content').html(() =>
        {
          string = '<pre>' + data + '</pre>';
          return string;
        });
      },
      error: (jqXHR, status, error) =>
      {
        console.log("Ajax call onto /site/treatment failed");
        console.log(error);
      }
    });

    $('#treatment-type-error').hide();
    $('#treatment-type').hide();
    $('#treatment').show();
  }
  // No radio button was selected
  else
  {
    $('#treatment-type-error').show();
  }
})

// Switching from treatment to type
$('#treatment-back-btn').click(() => {
  $('#treatment').hide();
  $('#treatment-type').show();
  $('#treatment-content').text('');
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
    $('#personal-data').hide();
    $('#overview').show();
  }
})

// Switching from overview to personal data
$('#overview-back-btn').click(() => {
  $('#overview').hide();
  $('#personal-data').show();
})
