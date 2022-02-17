<?php

use yii\helpers\VarDumper;

// VarDumper::dump($booking, 10, true);
// echo '<hr>';
// VarDumper::dump($roles, 10, true);
// echo '<hr>';
// VarDumper::dump($treatments, 10, true);
// exit;

$this->title = $booking->patient_lastName;
$this->params['currentPage'] = 'bookings';
?>

<div class="top-row">
  <a href="/backend/bookings">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ <?= $booking->patient_lastName ?></h1>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language active-language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<?php // Booking data ?>
<div class="grid-container">
<!-- <?= VarDumper::dump($treatments, 10, true) ?> -->
  <label class="input-label"><span>Duration (min)</span>
    <?= $this->render('partials/duration-select', [
      'model' => $booking
    ]) ?>
  </label>

  <?php // TODO: whenever the user selects a new date, update the times with Ajax ?>
  <label class="input-label"><span>Time</span>
    <?= $this->render('partials/booking-time-select', [
      'model' => $booking
    ]) ?>
  </label>
  <label class="input-label"><span>Date</span>
    <input type="date" value="<?= $booking->date ?>" min="<?= date('Y-m-d') ?>">
  </label>

  <div class="break"></div>

  <?php // These two have ids for the Ajax calls ?>
  <label class="input-label"><span>Role</span>
    <select name="" id="roles">

      <?php foreach ($roles as $key => $role) { ?>
        <?php // Shows the one as selected which is present in $booking ?>
        <option <?= ($role->id == $booking->role->id) ? 'selected' : '' ?> value="<?= $role->role_name ?>"><?= $role->role_name ?></option>
      <?php } ?>

    </select>
  </label>

  <?php // TODO: Ajax injection ?>
  <div class="input-label"><span>Treatment(s)</span>
    <div class="treatments">

      <?php // Shows all treatments
      foreach ($treatments as $treatment)
      {
        $mark_treatment = false;

        // Determines whether the current treatment needs to be checked or not
        foreach ($booking->treatment_id as $treatment_id) {
          if ($treatment_id == $treatment->id)
          {
            $mark_treatment = true;
          }
        } ?>
        <label class="sub-input time-checkbox">&nbsp;<?= $treatment->treatment_name ?>
          <input type="checkbox" name="" <?= ($mark_treatment) ? 'checked' : '' ?>>
        </label>
      <?php } ?>

    </div>
  </div>

  <div class="break"></div>

  <label class="input-label"><span>Salutation</span>
    <select name="">
      <option <?= ($booking->patient_salutation == 'mr') ? 'selected' : '' ?> value="mr">Mr.</option>
      <option <?= ($booking->patient_salutation == 'mrs') ? 'selected' : '' ?> value="mrs">Mrs.</option>
      <option <?= ($booking->patient_salutation == 'mystery') ? 'selected' : '' ?> value="mystery">Mystery</option>
      <option <?= ($booking->patient_salutation == 'other') ? 'selected' : '' ?> value="other">Other</option>
    </select>
  </label>
  <label class="input-label"><span>First Name</span>
    <input type="text" value="<?= $booking->patient_firstName ?>">
  </label>
  <label class="input-label"><span>Last Name</span>
    <input type="text" value="<?= $booking->patient_lastName ?>">
  </label>
  <label class="input-label"><span>Birth Date</span>
    <input type="date" value="<?= $booking->patient_birthdate ?>" max="<?= date('Y-m-d') ?>">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Street</span>
    <input type="text" value="<?= $booking->patient_street ?>">
  </label>
  <label class="input-label"><span>City</span>
    <input type="text" value="<?= $booking->patient_city ?>">
  </label>
  <label class="input-label"><span>Zip Code</span>
    <input type="number" value="<?= $booking->patient_zipCode ?>">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>E-Mail</span>
    <input type="email" value="<?= $booking->patient_email ?>">
  </label>
  <label class="input-label"><span>Telephone</span>
    <input type="tel" value="<?= $booking->patient_phoneNumber ?>">
  </label>

  <div class="break"></div>

  <label class="input-label description"><span>Description</span>
    <textarea rows="4"><?= $booking->patient_comment ?></textarea>
  </label>

  <div class="checkbox-row">
    <label class="input-label input-checkbox"><span>Reminder</span>
      <input type="checkbox" <?= ($booking->callback) ? 'checked' : '' ?>>
    </label>
    <label class="input-label input-checkbox"><span>New Patient</span>
      <input type="checkbox" <?= ($booking->newPatient) ? 'checked' : '' ?>>
    </label>
    <label class="input-label input-checkbox"><span>Send Confirmation E-Mail</span>
      <input type="checkbox" <?= ($booking->send_confirmation) ? 'checked' : '' ?>>
    </label>
  </div>

  <label class="input-label last-input-element"><span>Status</span>
    <input type="text">
  </label>
</div>

<div class="save">
  <a href="#" class="btn btn-warning">save</a>
</div>
