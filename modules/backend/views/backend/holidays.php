<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Holidays';
$this->params['currentPage'] = 'holidays';

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

  <div class="grid grid-holiday-layout">

    <?php // Search fields ?>
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <div></div>

    <?php // Field titles ?>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Name</b>'.$nameArrow, [
        '/backend/backend/holidays',
         'nameSort' => (isset($getParams['nameSort']) && $getParams['nameSort'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Date</b>'.$dateArrow, [
        '/backend/backend/holidays',
         'dateSort' => (isset($getParams['dateSort']) && $getParams['dateSort'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">Actions</b>
    </div>

    <?php // Grid data ?>
    <?php foreach ($holidays as $holidayKey => $holiday) { ?>

      <div class="grid-data-padding <?= $holidayKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $holiday['name'] ?></div>
      <div class="grid-data-padding <?= $holidayKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $holiday['date'] ?></div>

      <div class="actions grid-data-padding <?= $holidayKey % 2 == 0 ? 'even' : 'odd' ?>">
        <a href="/backend/backend/edit-holiday">Edit</a>
        <a href="#">Delete</a>
      </div>

    <?php } ?>

  </div>

  <?php // Pagination for the grid ?>
  <div class="pagination">pagination goes here</div>

</div>