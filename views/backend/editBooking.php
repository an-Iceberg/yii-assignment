<?php

use yii\helpers\VarDumper;

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
  <label class="input-label"><span>Duration (min)</span>
    <select>
      <?php if ($booking->duration == '') { ?>
        <option selected disabled>Please select</option>
      <?php } ?>
      <option <?= ($booking->duration == 15) ? 'selected' : '' ?> value="15">15</option>
      <option <?= ($booking->duration == 30) ? 'selected' : '' ?> value="30">30</option>
      <option <?= ($booking->duration == 45) ? 'selected' : '' ?> value="45">45</option>
      <option <?= ($booking->duration == 60) ? 'selected' : '' ?> value="60">60</option>
      <option <?= ($booking->duration == 90) ? 'selected' : '' ?> value="90">90</option>
      <option <?= ($booking->duration == 120) ? 'selected' : '' ?> value="120">120</option>
      <option <?= ($booking->duration == 150) ? 'selected' : '' ?> value="150">150</option>
      <option <?= ($booking->duration == 180) ? 'selected' : '' ?> value="180">180</option>
      <option <?= ($booking->duration == 210) ? 'selected' : '' ?> value="210">210</option>
      <option <?= ($booking->duration == 240) ? 'selected' : '' ?> value="240">240</option>
      <option <?= ($booking->duration == 270) ? 'selected' : '' ?> value="270">270</option>
      <option <?= ($booking->duration == 300) ? 'selected' : '' ?> value="300">300</option>
      <option <?= ($booking->duration == 330) ? 'selected' : '' ?> value="330">330</option>
      <option <?= ($booking->duration == 360) ? 'selected' : '' ?> value="360">360</option>
      <option <?= ($booking->duration == 390) ? 'selected' : '' ?> value="390">390</option>
      <option <?= ($booking->duration == 420) ? 'selected' : '' ?> value="420">420</option>
      <option <?= ($booking->duration == 450) ? 'selected' : '' ?> value="450">450</option>
      <option <?= ($booking->duration == 480) ? 'selected' : '' ?> value="480">480</option>
      <option <?= ($booking->duration == 510) ? 'selected' : '' ?> value="510">510</option>
    </select>
  </label>

  <?php // TODO: whenever the user selects a new date, update the times with Ajax ?>
  <label class="input-label"><span>Time</span>
    <select>
      <?php if ($booking->time == '') { ?>
        <option selected disabled>Please select</option>
      <?php } ?>
      <option <?= ($booking->time == '08:00:00') ? 'selected' : '' ?> value="08:00">8:00</option>
      <option <?= ($booking->time == '08:15:00') ? 'selected' : '' ?> value="08:15">8:15</option>
      <option <?= ($booking->time == '08:30:00') ? 'selected' : '' ?> value="08:30">8:30</option>
      <option <?= ($booking->time == '08:45:00') ? 'selected' : '' ?> value="08:45">8:45</option>
      <option <?= ($booking->time == '09:00:00') ? 'selected' : '' ?> value="09:00">9:00</option>
      <option <?= ($booking->time == '09:15:00') ? 'selected' : '' ?> value="09:15">9:15</option>
      <option <?= ($booking->time == '09:30:00') ? 'selected' : '' ?> value="09:30">9:30</option>
      <option <?= ($booking->time == '09:45:00') ? 'selected' : '' ?> value="09:45">9:45</option>
      <option <?= ($booking->time == '10:00:00') ? 'selected' : '' ?> nalue="10:00">10:00</option>
      <option <?= ($booking->time == '10:15:00') ? 'selected' : '' ?> value="10:15">10:15</option>
      <option <?= ($booking->time == '10:30:00') ? 'selected' : '' ?> value="10:30">10:30</option>
      <option <?= ($booking->time == '10:45:00') ? 'selected' : '' ?> value="10:45">10:45</option>
      <option <?= ($booking->time == '11:00:00') ? 'selected' : '' ?> value="11:00">11:00</option>
      <option <?= ($booking->time == '11:15:00') ? 'selected' : '' ?> value="11:15">11:15</option>
      <option <?= ($booking->time == '11:30:00') ? 'selected' : '' ?> value="11:30">11:30</option>
      <option <?= ($booking->time == '11:45:00') ? 'selected' : '' ?> value="11:45">11:45</option>
      <option <?= ($booking->time == '12:00:00') ? 'selected' : '' ?> value="12:00">12:00</option>
      <option <?= ($booking->time == '12:15:00') ? 'selected' : '' ?> value="12:15">12:15</option>
      <option <?= ($booking->time == '12:30:00') ? 'selected' : '' ?> value="12:30">12:30</option>
      <option <?= ($booking->time == '12:45:00') ? 'selected' : '' ?> value="12:45">12:45</option>
      <option <?= ($booking->time == '13:00:00') ? 'selected' : '' ?> value="13:00">13:00</option>
      <option <?= ($booking->time == '13:15:00') ? 'selected' : '' ?> value="13:15">13:15</option>
      <option <?= ($booking->time == '13:30:00') ? 'selected' : '' ?> value="13:30">13:30</option>
      <option <?= ($booking->time == '13:45:00') ? 'selected' : '' ?> value="13:45">13:45</option>
      <option <?= ($booking->time == '14:00:00') ? 'selected' : '' ?> value="14:00">14:00</option>
      <option <?= ($booking->time == '14:15:00') ? 'selected' : '' ?> value="14:15">14:15</option>
      <option <?= ($booking->time == '14:30:00') ? 'selected' : '' ?> value="14:30">14:30</option>
      <option <?= ($booking->time == '14:45:00') ? 'selected' : '' ?> value="14:45">14:45</option>
      <option <?= ($booking->time == '15:00:00') ? 'selected' : '' ?> value="15:00">15:00</option>
      <option <?= ($booking->time == '15:15:00') ? 'selected' : '' ?> value="15:15">15:15</option>
      <option <?= ($booking->time == '15:30:00') ? 'selected' : '' ?> value="15:30">15:30</option>
      <option <?= ($booking->time == '15:45:00') ? 'selected' : '' ?> value="15:45">15:45</option>
      <option <?= ($booking->time == '16:00:00') ? 'selected' : '' ?> value="16:00">16:00</option>
      <option <?= ($booking->time == '16:15:00') ? 'selected' : '' ?> value="16:15">16:15</option>
      <option <?= ($booking->time == '16:30:00') ? 'selected' : '' ?> value="16:30">16:30</option>
      <option <?= ($booking->time == '16:45:00') ? 'selected' : '' ?> value="16:45">16:45</option>
      <option <?= ($booking->time == '17:00:00') ? 'selected' : '' ?> value="17:00">17:00</option>
      <option <?= ($booking->time == '17:15:00') ? 'selected' : '' ?> value="17:15">17:15</option>
      <option <?= ($booking->time == '17:30:00') ? 'selected' : '' ?> value="17:30">17:30</option>
      <option <?= ($booking->time == '17:45:00') ? 'selected' : '' ?> value="17:45">17:45</option>
      <option <?= ($booking->time == '18:00:00') ? 'selected' : '' ?> value="18:00">18:00</option>
      <option <?= ($booking->time == '18:15:00') ? 'selected' : '' ?> value="18:15">18:15</option>
      <option <?= ($booking->time == '18:30:00') ? 'selected' : '' ?> value="18:30">18:30</option>
      <option <?= ($booking->time == '18:45:00') ? 'selected' : '' ?> value="18:45">18:45</option>
      <option <?= ($booking->time == '19:00:00') ? 'selected' : '' ?> value="19:00">19:00</option>
      <option <?= ($booking->time == '19:15:00') ? 'selected' : '' ?> value="19:15">19:15</option>
      <option <?= ($booking->time == '19:30:00') ? 'selected' : '' ?> value="19:30">19:30</option>
      <option <?= ($booking->time == '19:45:00') ? 'selected' : '' ?> value="19:45">19:45</option>
    </select>
  </label>
  <label class="input-label"><span>Date</span>
    <input type="date" value="<?= $booking->date ?>" min="<?= date('Y-m-d') ?>">
  </label>

  <div class="break"></div>

<?php // TODO: these need to be selects with Ajax injection ?>
  <label class="input-label"><span>Role</span>
    <input type="text" value="<?= $booking->role->role_name ?>">
  </label>
  <label class="input-label"><span>Treatment</span>
    <input type="text" value="<?= $booking->treatment->treatment_name ?>">
  </label>

  <div class="break"></div>

  <?php // TODO: needs to be a select ?>
  <label class="input-label"><span>Salutation</span>
    <!-- <input type="text" value="<?= $booking->patient_salutation ?>"> -->
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
    <input type="text" value="<?= $booking->patient_zipCode ?>">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>E-Mail</span>
    <input type="email" value="<?= $booking->patient_email ?>">
  </label>
  <label class="input-label"><span>Telephone</span>
    <input type="text" value="<?= $booking->patient_phoneNumber ?>">
  </label>

  <div class="break"></div>

  <label class="input-label description"><span>Description</span>
    <textarea rows="4"><?= $booking->patient_comment ?></textarea>
  </label>
  <label class="input-label input-checkbox"><span>Callback</span>
    <input type="checkbox">
  </label>
  <label class="input-label last-input-element"><span>Status</span>
    <input type="text">
  </label>
</div>

<div class="save">
  <a href="#" class="btn btn-warning">save</a>
</div>
