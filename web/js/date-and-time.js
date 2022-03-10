// TODO: most of these values will need to be injected with php based on the language chosen
console.log(holidays);

let datepicker = $('#date').datepicker({
  dateFormat: 'dd-mm-yy',
  prevText: '⮜',
  nextText: '⮞',
  changeMonth: true,
  changeYear: true,
  firstDay: 1,
  beforeShowDay: function(date) {
    let day = date.getDay();

    // Disables all Sundays
    if (day == 0)
    {
      return [false, ''];
    }

    let disableToday = false;

    // Searches for a holiday matching today
    holidays.forEach(holiday => {
      if (
        date.getDate() == holiday.day &&
        date.getMonth() == holiday.month &&
        date.getFullYear() == holiday.year
      )
      {
        disableToday = true;
      }
    });

    // Disables today, if today is a holiday
    if (disableToday)
    {
      return [false, ''];
    }

    return [true, ''];
  },
  minDate: 0,
  maxDate: '+6m',
  onUpdateDatepicker: function(datepicker) {
    $('.ui-datepicker-prev').attr('title', 'Previous Month');
    $('.ui-datepicker-next').attr('title', 'Next Month');
  },
  showButtonPanel: true,
  altField: '#selectedDate',
  altFormat: 'yy-mm-dd',

  // If the user selects a date, query the times form the DB
  onSelect: function(dateText, inst) {
    $('#time-container').fadeOut(300, () => {

      let data = {
        "date": `${dateText.substr(6, 4)}-${dateText.substr(3, 2)}-${dateText.substr(0, 2)}`,
        "role": $('#role').val(),
        "totalDuration": $('#totalDuration').val()
      }

      // Ajax call
      $.ajax({
        type: "post",
        url: "/booking/get-times",
        data: data,
        success: function (response) {
          console.log('Success');
          console.log(response);

          $('h2.h4').html(`On ${dateText} the following times are open:`);
          $('#times').html(response);
          $('#time-container').fadeIn(300);
        },
        error: function (error) {
          console.log(':('+'\n'+'Something went wrong.');
          console.log(error);
          $('#time-container').fadeIn(300);
        }
      });
    });
  }
});

$('.ui-datepicker-prev').attr('title', 'Previous Month');
$('.ui-datepicker-next').attr('title', 'Next Month');
