<?php

use app\modules\backend\models\Booking;
use yii\grid\GridView;
use yii\helpers\VarDumper;

$this->title = 'Bookings';
$this->params['currentPage'] = 'bookings';
?>

<?php // Create button ?>
<div class="create-link-container">
  <a href="#" class="btn btn-primary">+ create</a>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<div class="grid-container">

  <div class="grid grid-booking-layout">

    <?php // Search fields ?>
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <div></div>

    <?php // Field titles ?>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">Role</b>
    </div>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">Salutation</b>
    </div>
    <div class="field-title grid-margins-top">
      <a href="#">
        <b class="grid-margins">Last Name</b>
      </a>
    </div>
    <div class="field-title grid-margins-top">
      <a href="#">
        <b class="grid-margins">Date and Time</b>
      </a>
    </div>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">Actions</b>
    </div>

    <?php // Grid data ?>
    <?php foreach ($bookings as $bookingKey => $booking) { ?>

      <div class="grid-data-padding <?= $bookingKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $booking['role'] ?></div>
      <div class="grid-data-padding <?= $bookingKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $booking['patient_salutation'] ?></div>
      <div class="grid-data-padding <?= $bookingKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $booking['patient_lastName'] ?></div>
      <div class="grid-data-padding <?= $bookingKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $booking['date'] ?></div>

      <div class="actions grid-data-padding <?= $bookingKey % 2 == 0 ? 'even' : 'odd' ?>">
        <a href="/backend/backend/edit-booking">Edit</a>
        <a href="#">Delete</a>
      </div>

    <?php } ?>

  </div>

  <?php // Pagination for the grid ?>
  <div class="pagination">pagination goes here</div>

</div>
