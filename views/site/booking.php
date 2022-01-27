<?php
use app\assets\BookingAsset;
use app\assets\JqueryuiAsset;
use app\models\Booking;
use yii\helpers\Html;
// use yii\helpers\VarDumper;
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
  'action' => '/site/input-validation',
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

    <?php // Treatment ?>

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

    <?php // Date ?>

    <div id="date-content" class="input-group mb-3">
      <!-- <input aria-label="date" type="date" name="booking[date]" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" max="<?php
      $date = new DateTime();
      $date->modify('+6 month');
      echo $date->format('Y-m-d');
      ?>" step="0.71" class="form-control"> -->

      <input readonly type="text" id="datepicker" class="form-control" name="booking[date]" placeholder="Pick a date *">

      <select name="booking[hours]" class="form-control">
        <option value="" selected disabled>Select an hour *</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
      </select>

      <select name="booking[minutes]" class="form-control">
        <option value="" selected disabled>Select a minute *</option>
        <option value="00">00</option>
        <option value="15">15</option>
        <option value="30">30</option>
        <option value="45">45</option>
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
            <input type="text" aria-label="Postal code" class="form-control" name="booking[patient_zipCode]" placeholder="Postal Code *" pattern="\d{1,10}" required>
            <input type="text" aria-label="City" class="form-control" name="booking[patient_city]" placeholder="City *" pattern="[a-zA-Z0-9\-\.\ ]{1,50}" required>
          </div>

          <?php // Phone and E-Mail ?>
          <div class="input-group mb-3">
            <input type="tel" aria-label="Phone number" class="form-control" name="booking[patient_phoneNumber]" placeholder="Telephone Number *" pattern="[0-9\-\ \+]{1,16}" maxlength="20" required>
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

    <?php // Overview ?>

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
