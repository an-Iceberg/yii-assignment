// Delete buttons event listeners
$('#treatments').click(function (e) {
  e.preventDefault();

  let target = e.target;
  let treatment_name = 'treatment_name';

  // Sometimes the icon is selected, sometimes the button

  // This makes sure that the target is always set to be the button
  if (target.classList.contains('nf'))
  {
    target = target.parentElement;
  }

  // Selecting the id
  target = target.id;

  // Getting the name of the treatment present in the input field
  treatment_name = $(`input[name="treatments[${target.substr(14)}][treatment_name]"]`).val();

  // Only act, if the delete button has been clicked and the user has confirmed to delete the treatment
  if (target.substring(0, 13) == 'delete-button' && confirm(`Delete treatment ${treatment_name}?`))
  {
    // Removing the selected element form the DOM
    $('#treatment-'+target.substr(14)).remove();
  }
});

// Create button event listener
$('#create-button').click(function (e) {
  e.preventDefault();

  // In order to create a new treatment, we need to create a new ID for it in the DOM
  // The only important thing is for the ID to be larger than any preceeding ones

  // Retrieving the ID of the last treatment (in the DOM, not the actual ID in the DB)
  let treatments = $('#treatments');
  let lastTreatment = treatments.children();
  lastTreatment = parseInt(lastTreatment[lastTreatment.length - 1].id.substr(10));
  lastTreatment++;

  let template = `
    <div id="treatment-${lastTreatment}">
      <label class="sub-input"><span>Treatment</span>
        <input type="text" name="treatments[${lastTreatment}][treatment_name]" value="">
      </label>
      <label class="sub-input"><span>Sort Order</span>
        <input type="number" name="treatments[${lastTreatment}][sort_order]" value="">
      </label>
      <button type="button" class="sub-input treatment-delete-button" id="delete-button-${lastTreatment}">
        <i class="nf nf-fa-times"></i>
      </button>
    </div>
  `;

  treatments.append(template);
});
