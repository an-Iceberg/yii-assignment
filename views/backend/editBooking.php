<?php

$this->title = 'Last Name';
$this->params['currentPage'] = 'bookings';
?>

<div class="top-row">
  <a href="/backend/bookings">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ Last Name</h1>
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
      <option value="15">15</option>
      <option value="30">30</option>
      <option value="45">45</option>
      <option value="60">60</option>
      <option value="90">90</option>
      <option value="120">120</option>
      <option value="150">150</option>
      <option value="180">180</option>
      <option value="210">210</option>
      <option value="240">240</option>
    </select>
  </label>
  <label class="input-label"><span>Time</span>
    <select>
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
  </label>
  <label class="input-label"><span>Date</span>
    <input type="date">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Role</span>
    <input type="text">
  </label>
  <label class="input-label"><span>Treatment</span>
    <input type="text">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Salutation</span>
    <input type="text">
  </label>
  <label class="input-label"><span>First Name</span>
    <input type="text">
  </label>
  <label class="input-label"><span>Last Name</span>
    <input type="text">
  </label>
  <label class="input-label"><span>Birth Date</span>
    <input type="date">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Street</span>
    <input type="text">
  </label>
  <label class="input-label"><span>City</span>
    <input type="text">
  </label>
  <label class="input-label"><span>Zip Code</span>
    <input type="text">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>E-Mail</span>
    <input type="email">
  </label>
  <label class="input-label"><span>Telephone</span>
    <input type="text">
  </label>

  <div class="break"></div>

  <label class="input-label description"><span>Description</span>
    <textarea rows="4"></textarea>
  </label>
  <label class="input-label input-checkbox"><span>Callback</span>
    <input type="checkbox">
  </label>
  <label class="input-label"><span>Status</span>
    <input type="text">
  </label>
</div>

<div class="save">
  <a href="#" class="btn btn-warning">save</a>
</div>
