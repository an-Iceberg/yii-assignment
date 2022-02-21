// If the user changes the roles, update the list of treatments using Ajax
$('#roles').change(function (e)
{
  e.preventDefault();

  let treatments = $('#treatments');

  // Ajax call to get the data
  $.ajax('/backend/get-treatments',
    {
      type: "get",
      data: {role: e.target.value},
      success: function (data, textStatus, jqXHR) {
        // Injecting HTML data into correct HTML element
        treatments.fadeOut(300, () => {
          treatments.html(data)
        })
      },
      error: (jqXHR, textStatus, errorThrown) => {
        console.log('error');
        console.log(jqXHR, textStatus, errorThrown);
      },
      complete: () => {
        treatments.fadeIn(300);
      }
    }
  );
});
