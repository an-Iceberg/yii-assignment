// < > ≪ ≫ ≺ ≻ ⊲ ⊳ ➤ ➣ ➢ ᗒ ᗕ ⋙ ⋘ ▻ ◅ ❯ ❮ ❱ ❰ ⩤ ⩥ ⫷ ⫸ ⪡ ⪢
// ⮜⮝⮞⮟
// ⮘⮙⮚⮛

// TODO: most of these values will need to be injected with php somehow based on the language chosen
// TODO: holidays for the selected role must also be accounted for

let datepicker = $('#date').datepicker({
  dateFormat: 'dd-mm-yy',
  prevText: '⮜',
  nextText: '⮞',
  changeMonth: true,
  changeYear: true,
  firstDay: 1,
  beforeShowDay: function(date) {
    let day = date.getDay();
    return [(day != 0), ''];
  },
  minDate: 0,
  maxDate: '+6m',
  onUpdateDatepicker: function(datepicker) {
    $('.ui-datepicker-prev').attr('title', 'Previous Month');
    $('.ui-datepicker-next').attr('title', 'Next Month');
  },
  showButtonPanel: true,
  altField: '#selectedDate',

  // If the user selects a date, query the times form the DB
  onSelect: function(dateText, inst) {
    $('#time-container').fadeOut(300, () => {

      let data = {
        "date": `${dateText.substr(6, 4)}-${dateText.substr(3, 2)}-${dateText.substr(0, 2)}`,
        "role": $('input[type="hidden"][name="role"]').val()
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
          $('#time-container').fadeIn(300);
        },
        error: function (error) {
          console.log('Something went wrong :(');
          console.log(error);
          $('#time-container').fadeIn(300);
        }
      });

    });
  }
});

$('.ui-datepicker-prev').attr('title', 'Previous Month');
$('.ui-datepicker-next').attr('title', 'Next Month');

// Sorts dates first by date and then by time
dates.sort();
console.log(dates);