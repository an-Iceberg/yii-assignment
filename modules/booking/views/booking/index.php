<?php
use app\assets\BookingAsset;
use app\assets\JqueryuiAsset;
use app\modules\booking\models\Booking;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

JqueryuiAsset::register($this);
BookingAsset::register($this);

$booking = new Booking();
?>

<h1>Booking Form</h1>
<hr>

<?php // Booking form
$bookingForm = ActiveForm::begin([
  'id' => 'booking-form',
  'action' => '/booking/booking/input-validation',
  'method' => 'post'
]); ?>

  <div id="treatment-type">

    <h2 class="h3">Choose a treatment type</h2>

    <?php // Type of treatment
    // Prints all treatment types present in $data
    foreach ($data as $entry) { ?>

      <label class="capitalize">
        <input type="radio" name="booking[doctor]" value="<?= $entry['profession']?>">
        <?= $entry['profession'] ?>
      </label>
      <br>

    <?php } ?>

    <div class="alert alert-danger" id="treatment-type-error" role="alert">
      Please select one of the options.
    </div>

    <hr>
    <div class="form-group col-lg-offset-1 col-lg-11 pl-0">
      <span class="btn btn-secondary not-visible">Back</span>
      <span id="type-next-btn" class="btn btn-primary">Next</span>
    </div>

  </div>


  <div id="treatment">

    <h2 class="h3">Choose a treatment</h2>

    <?php // Treatment
    // The data gets injected via JS ?>

    <div class="capitalize" id="treatment-content"></div>

    <div class="alert alert-danger" id="treatment-error" role="alert">
      Please select one of the options.
    </div>

    <hr>
    <div class="form-group col-lg-offset-1 col-lg-11 pl-0">
      <span id="treatment-back-btn" class="btn btn-outline-secondary">Back</span>
      <span id="treatment-next-btn" class="btn btn-primary">Next</span>
    </div>

  </div>


  <div id="date">

    <h2 class="h3">Pick a date and time that's suitable for you</h2>

    <?php // Date
    // Additional data gets injected via JS ?>

    <div id="date-content" class="input-group mb-3">

      <input readonly type="text" id="datepicker" class="form-control" name="booking[date]" placeholder="Pick a date *">

      <select name="booking[time]" class="form-control">
        <option value="" selected disabled>Select a time *</option>

        <option value="08:00">8:00</option>
        <option value="08:15">8:15</option>
        <option value="08:30">8:30</option>
        <option value="08:45">8:45</option>

        <option value="09:00">9:00</option>
        <option value="09:15">9:15</option>
        <option value="09:30">9:30</option>
        <option value="09:45">9:45</option>

        <option value="10:00">10:00</option>
        <option value="10:15">10:15</option>
        <option value="10:30">10:30</option>
        <option value="10:45">10:45</option>

        <option value="11:00">11:00</option>
        <option value="11:15">11:15</option>
        <option value="11:30">11:30</option>
        <option value="11:45">11:45</option>

        <option value="12:00">12:00</option>
        <option value="12:15">12:15</option>
        <option value="12:30">12:30</option>
        <option value="12:45">12:45</option>

        <option value="13:00">13:00</option>
        <option value="13:15">13:15</option>
        <option value="13:30">13:30</option>
        <option value="13:45">13:45</option>

        <option value="14:00">14:00</option>
        <option value="14:15">14:15</option>
        <option value="14:30">14:30</option>
        <option value="14:45">14:45</option>

        <option value="15:00">15:00</option>
        <option value="15:15">15:15</option>
        <option value="15:30">15:30</option>
        <option value="15:45">15:45</option>

        <option value="16:00">16:00</option>
        <option value="16:15">16:15</option>
        <option value="16:30">16:30</option>
        <option value="16:45">16:45</option>

        <option value="17:00">17:00</option>
        <option value="17:15">17:15</option>
        <option value="17:30">17:30</option>
        <option value="17:45">17:45</option>

        <option value="18:00">18:00</option>
        <option value="18:15">18:15</option>
        <option value="18:30">18:30</option>
        <option value="18:45">18:45</option>

        <option value="19:00">19:00</option>
        <option value="19:15">19:15</option>
        <option value="19:30">19:30</option>
        <option value="19:45">19:45</option>
      </select>
    </div>

    <div class="alert alert-danger" id="date-error" role="alert">
      Please pick a date and time.
    </div>

    <hr>
    <div class="form-group col-lg-offset-1 col-lg-11 pl-0">
      <span id="date-back-btn" class="btn btn-outline-secondary">Back</span>
      <span id="date-next-btn" class="btn btn-primary">Next</span>
    </div>

  </div>


  <div id="personal-data">

    <h2 class="h3">Please enter your personal data</h2>

      <div class="d-flex flex-row w-100 container">

        <?php // Left input block ?>
        <div class="mr-3 flex-fill">

          <?php // Personal data ?>
          <div class="input-group mb-3">

            <?php // Salutation ?>
            <select aria-label="saluation" class="custom-select" name="booking[patient_salutation]" required>
              <option value="" selected disabled>Salutation *</option>
              <option value="mr">Mr.</option>
              <option value="mrs">Mrs.</option>
              <option value="mystery">Mystery</option>
              <option value="other">Other</option>
            </select>
          </div>

          <?php // First and last name ?>
          <div class="input-group mb-3">
            <input type="text" aria-label="First name" class="form-control" name="booking[patient_firstName]" placeholder="First Name *" pattern="[a-zA-Z]{1,50}" required>
            <input type="text" aria-label="Last name" class="form-control" name="booking[patient_lastName]" placeholder="Last Name *" pattern="[a-zA-Z]{1,50}" required>
          </div>

          <?php // Birthdate ?>
          <div class="input-group mb-3">
            <input type="date" min="1900-01-01" max="<?= date('Y-m-d') ?>" aria-label="birthdate" class="form-control" name="booking[patient_birthdate]" required>
          </div>

          <?php // Street name ?>
          <div class="input-group mb-3">
            <input type="text" aria-label="Street" class="form-control" name="booking[patient_street]" placeholder="Street *" pattern="[a-zA-Z0-9\.\-\ ]{1,50}" required>
          </div>

          <?php // Postal code and city ?>
          <div class="input-group mb-3">
            <input type="text" aria-label="Postal code" class="form-control" name="booking[patient_zipCode]" placeholder="Postal Code *" required> <!-- pattern="\d{1,10}" -->
            <input type="text" aria-label="City" class="form-control" name="booking[patient_city]" placeholder="City *" pattern="[a-zA-Z0-9\-\.\ ]{1,50}" required>
          </div>

          <?php // Phone and E-Mail ?>
          <div class="input-group mb-3">
            <input type="tel" aria-label="Phone number" class="form-control" name="booking[patient_phoneNumber]" placeholder="Telephone Number *" maxlength="20" required> <!-- pattern="[0-9\-\ \+]{1,16}" -->
            <input type="email" aria-label="E-Mail address" class="form-control" name="booking[patient_email]" placeholder="E-Mail Address *" pattern="[a-zA-Z\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|]{1,64}@[a-zA-Z0-9\.\-]{1,255}\.[a-z]{1,255}" required>
          </div>
        </div>

        <?php // Right input block ?>
        <div class="flex-fill">

          <?php // Comment ?>
          <div class="input-group mb-3">
            <textarea name="booking[patient_comment]" aria-label="Comment" class="form-control" placeholder="Comment" style="height: 200px;"></textarea>
          </div>

          <?php // New patient ?>
          <div class="input-group mb-3">
            <select class="form-control" name="booking[newPatient]" required>
              <option value="" selected disabled>Are you a new patient? *</option>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>

          <?php // Recall ?>
          <div class="input-group mb-3">
            <select class="form-control" name="booking[recall]" required>
              <option value="" selected disabled>Should we call you back? *</option>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
        </div>
      </div>

      <hr>
      <div class="form-group col-lg-offset-1 col-lg-11 pl-0">
        <span id="data-back-btn" class="btn btn-outline-secondary">Back</span>
        <span id="data-next-btn" class="btn btn-primary">Next</span>
      </div>

  </div>


  <div id="overview">

    <h2 class="h3">Overview</h2>

    <?php // Overview
    // Gets injected via JS ?>

    <dl class="content row capitalize"></dl>

    <hr>
    <div class="form-group col-lg-offset-1 col-lg-11 pl-0">
      <span id="overview-back-btn" class="btn btn-outline-secondary">Back</span>
      <?= Html::submitButton('Submit', [
        'class' => 'btn btn-primary submit-button',
        'id' => 'overview-submit-btn'
      ]) ?>
    </div>

  </div>

<?php ActiveForm::end(); ?>
