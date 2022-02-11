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

$nameSort = 2;
$dateSort = 2;

// Setting the arrows only if the sorting criterium is present
if (isset($getParams['nameSort']))
{
  setArrow('nameSort', $nameArrow, $getParams);
  $nameSort = $getParams['nameSort'] == 2 ? 1 : 2;
}
elseif (isset($getParams['dateSort']))
{
  setArrow('dateSort', $dateArrow, $getParams);
  $dateSort = $getParams['dateSort'] == 2 ? 1 : 2;
}

// Returns the correct class based on the foreach key
function evenOrOdd(&$key)
{
  return ($key % 2 == 0) ? 'even' : 'odd';
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
    <label class="grid-margins input-label">
      <input type="text" class="search-field">
      <a href="#" class="search-link"><i class="nf nf-oct-search search-icon"></i></a>
    </label>
    <label class="grid-margins input-label">
      <input type="text" class="search-field">
      <a href="#" class="search-link"><i class="nf nf-oct-search search-icon"></i></a>
    </label>
    <label class="grid-margins input-label">
      <input type="text" class="search-field">
      <a href="#" class="search-link"><i class="nf nf-oct-search search-icon"></i></a>
    </label>
    <label class="grid-margins input-label">
      <input type="text" class="search-field">
      <a href="#" class="search-link"><i class="nf nf-oct-search search-icon"></i></a>
    </label>
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
         'nameSort' => $nameSort
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the dates shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Date and Time</b>'.$dateArrow, [
        '/backend/backend/booking',
         'dateSort' => $dateSort
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">actions</b>
    </div>

    <?php // grid data ?>
    <?php foreach ($bookings as $bookingKey => $booking) { ?>

      <div class="grid-data-padding <?= evenOrOdd($bookingKey) ?>"><?= $booking['role'] ?></div>
      <div class="grid-data-padding <?= evenOrOdd($bookingKey) ?>"><?= $booking['patient_salutation'] ?></div>
      <div class="grid-data-padding <?= evenOrOdd($bookingKey) ?>"><?= $booking['patient_lastName'] ?></div>
      <div class="grid-data-padding <?= evenOrOdd($bookingKey) ?>"><?= $booking['date'] ?></div>

      <div class="actions grid-data-padding <?= evenOrOdd($bookingKey) ?>">
        <a href="/backend/backend/edit-booking">Edit</a>
        <a href="#">Delete</a>
      </div>

    <?php } ?>

  </div>

  <?php // Pagination for the grid ?>
  <div class="pagination">pagination goes here</div>

</div>
