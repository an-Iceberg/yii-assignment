<?php

use app\modules\backend\models\Booking;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Bookings';
$this->params['currentPage'] = 'bookings';

// Setting the arrow according to the sort order selected
function setArrow($sortingField, &$arrow, &$getParams)
{
  switch ($getParams[$sortingField])
  {
    case 2: $arrow = '&xvee;'; break;
    case 1: $arrow = '&xwedge;'; break;
    default: break;
  }
}

$nameArrow = '';
$dateArrow = '';

// Setting the arrows only if the sorting criterium is present
if (isset($getParams['nameSort']))
{
  setArrow('nameSort', $nameArrow, $getParams);
}
elseif (isset($getParams['dateSort']))
{
  setArrow('dateSort', $dateArrow, $getParams);
}
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
      <?php // Generates a link with URL parameters according to which the names shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Name</b>'.$nameArrow, [
        '/backend/backend/booking',
         'nameSort' => (isset($getParams['nameSort']) && $getParams['nameSort'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the dates shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Date and Time</b>'.$dateArrow, [
        '/backend/backend/booking',
         'dateSort' => (isset($getParams['dateSort']) && $getParams['dateSort'] == 2) ? 1 : 2
        ]);
      ?>
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
