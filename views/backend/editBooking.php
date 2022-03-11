<?php

/**
 * @var booking
 * @var roles
 * @var treatments
 * @var newEntry
 * @var id
 */

use app\assets\BackendEditCSSAsset;
use app\assets\TreatmentsAsset;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

TreatmentsAsset::register($this);
BackendEditCSSAsset::register($this);

$this->title = $booking->patient_lastName;
$this->params['currentPage'] = 'bookings';
?>

<div class="top-row">
  <a href="/backend/bookings" class="back-button">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ <?= $booking->patient_lastName ?></h1>

  <div class="flex-filler"></div>

  <?= Html::beginForm('delete-booking', 'post', [
    'class' => 'delete-form'
  ]) ?>
  <?= Html::hiddenInput('id', $booking->id) ?>
  <?= Html::submitButton('<i class="nf nf-fa-trash"></i>&nbsp;Delete this Booking', [
    'class' => 'btn delete-button',
    'data-confirm' => 'Are you sure you want to delete this booking?'
  ]) ?>
  <?= Html::endForm() ?>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language active-language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<?php
  $form = ActiveForm::begin([
    'action' => '/backend/edit-booking',
    'method' => 'post'
  ])
?>

<?php // Booking data ?>
<div class="grid-container">
  <label class="input-label"><span>Duration (min)</span>
    <input type="number" value="<?= $booking->duration ?>" name="duration">
  </label>

  <?php // TODO: whenever the user selects a new date, update the times with Ajax ?>
  <label class="input-label"><span>Time</span>
    <?= $this->render('partials/booking-time-select', [
      'model' => $booking
    ]) ?>
  </label>
  <label class="input-label"><span>Date</span>
    <input type="date" value="<?= $booking->date ?>" name="date"><!-- min="?= date('Y-m-d') ?" -->
  </label>

  <div class="break"></div>

  <?php // These two have ids for the Ajax calls ?>
  <label class="input-label"><span>Role</span>
    <select name="role" id="roles">

      <?php foreach ($roles as $key => $role) { ?>
        <?php // Shows the roles and marks the ones that are selected ?>
        <option
        class="role"
        <?= ($role->id == ($booking->role->id ?? null)) ? 'selected' : '' ?>
        <?= ($role->status == 0) ? 'disabled' : '' ?>
        value="<?= $role->id ?>"
        >
          <?= $role->role_name ?>
        </option>
      <?php } ?>

    </select>
  </label>

  <?php // Shows all the treatments that are available for the selected role ?>
  <div class="input-label"><span>Treatment(s)</span>
    <div class="treatments" id="treatments">

      <?php // Shows all treatments
      foreach ($treatments as $treatment)
      {
        $mark_treatment = false;

        // Determines whether the current treatment needs to be checked or not
        if (isset($booking->treatment_id))
        {
          foreach ($booking->treatment_id as $treatment_id) {
            if ($treatment_id == $treatment->id)
            {
              $mark_treatment = true;
            }
          }
        } ?>
        <label class="sub-input time-checkbox">&nbsp;<?= $treatment->treatment_name ?>
          <input type="checkbox" name="treatment[<?= $treatment->id ?>]" <?= ($mark_treatment) ? 'checked' : '' ?>>
        </label>
      <?php } ?>

    </div>
  </div>

  <div class="break"></div>

  <label class="input-label"><span>Salutation</span>
    <select name="salutation">
      <option <?= ($booking->patient_salutation == 'mr') ? 'selected' : '' ?> value="mr">Mr.</option>
      <option <?= ($booking->patient_salutation == 'mrs') ? 'selected' : '' ?> value="mrs">Mrs.</option>
      <option <?= ($booking->patient_salutation == 'mystery') ? 'selected' : '' ?> value="mystery">Mystery</option>
      <option <?= ($booking->patient_salutation == 'other') ? 'selected' : '' ?> value="other">Other</option>
    </select>
  </label>
  <label class="input-label"><span>First Name</span>
    <input type="text" value="<?= $booking->patient_firstName ?>" name="firstName">
  </label>
  <label class="input-label"><span>Last Name</span>
    <input type="text" value="<?= $booking->patient_lastName ?>" name="lastName">
  </label>
  <label class="input-label"><span>Birth Date</span>
    <input type="date" value="<?= $booking->patient_birthdate ?>" max="<?= date('Y-m-d') ?>" name="birthdate">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Street</span>
    <input type="text" value="<?= $booking->patient_street ?>" name="street">
  </label>
  <label class="input-label"><span>City</span>
    <input type="text" value="<?= $booking->patient_city ?>" name="city">
  </label>
  <label class="input-label"><span>Zip Code</span>
    <input type="number" value="<?= $booking->patient_zipCode ?>" name="zipCode">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>E-Mail</span>
    <input type="email" value="<?= $booking->patient_email ?>" name="email">
  </label>
  <label class="input-label"><span>Telephone</span>
    <input type="tel" value="<?= $booking->patient_phoneNumber ?>" name="telephone">
  </label>

  <div class="break"></div>

  <label class="input-label description"><span>Comment</span>
    <textarea rows="4" name="comment"><?= $booking->patient_comment ?></textarea>
  </label>

  <div class="checkbox-row">
    <label class="input-label input-checkbox"><span>Reminder</span>
      <input type="checkbox" <?= ($booking->callback) ? 'checked' : '' ?> name="reminder">
    </label>
    <label class="input-label input-checkbox"><span>New Patient</span>
      <input type="checkbox" <?= ($booking->newPatient) ? 'checked' : '' ?> name="newPatient">
    </label>
    <label class="input-label input-checkbox"><span>Send Confirmation E-Mail</span>
      <input type="checkbox" <?= ($booking->send_confirmation) ? 'checked' : '' ?> name="sendConfirmation">
    </label>
  </div>

  <label class="input-label last-input-element"><span>Status</span>
    <select name="status">
      <option <?= ($booking->status == 1) ? 'selected' : '' ?> value="1">Open</option>
      <option <?= ($booking->status == 2) ? 'selected' : '' ?> value="2">Cancelled</option>
      <option <?= ($booking->status == 3) ? 'selected' : '' ?> value="3">Booking is being processed</option>
      <option <?= ($booking->status == 0) ? 'selected' : '' ?> value="0">Booking has been processed</option>
    </select>
  </label>
</div>

<?= Html::hiddenInput('createNew', $newEntry, [
  'readonly' => true
]) ?>

<?= Html::hiddenInput('id', $id, [
  'readonly' => true
]) ?>

<div class="save">
  <?= Html::submitButton('Save Changes', ['class' => 'btn save-button']) ?>
</div>

<?php ActiveForm::end() ?>
