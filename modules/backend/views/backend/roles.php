<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Roles';
$this->params['currentPage'] = 'roles';

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

$roleArrow = '';
$emailArrow = '';
$statusArrow = '';
$sortOrderArrow = '';

$roleSort = 2;
$emailSort = 2;
$statusSort = 2;
$sortOrder = 2;

// Setting the arrow and sort order only if the sorting criterium is present
if (isset($getParams['roleSort']))
{
  setArrow('roleSort', $roleArrow, $getParams);
  $roleSort = ($getParams['roleSort']) == 2 ? 1 : 2;
}
elseif (isset($getParams['emailSort']))
{
  setArrow('emailSort', $emailArrow, $getParams);
  $emailSort = $getParams['emailSort'] == 2 ? 1 : 2;
}
elseif (isset($getParams['statusSort']))
{
  setArrow('statusSort', $statusArrow, $getParams);
  $statusSort = $getParams['statusSort'] == 2 ? 1 : 2;
}
elseif (isset($getParams['sortOrder']))
{
  setArrow('sortOrder', $sortOrderArrow, $getParams);
  $sortOrder = $getParams['sortOrder'] == 2 ? 1 : 2;
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

  <div class="grid grid-role-layout">

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
      <select class="search-field">
        <option value="">All</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
      <a href="#" class="search-link"><i class="nf nf-oct-search search-icon"></i></a>
    </label>
    <label class="grid-margins input-label">
      <input type="text" class="search-field">
      <a href="#" class="search-link"><i class="nf nf-oct-search search-icon"></i></a>
    </label>
    <div></div>

    <?php // Field titles ?>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Role</b>'.$roleArrow, [
        '/backend/backend/roles',
        'roleSort' => $roleSort
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the emails shall be sorted ?>
      <?= Html::a('<b class="grid-margins">E-Mail</b>'.$emailArrow, [
        '/backend/backend/roles',
        'emailSort' => $emailSort
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the statuses shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Status</b>'.$statusArrow, [
        '/backend/backend/roles',
        'statusSort' => $statusSort
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the order shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Sort Order</b>'.$sortOrderArrow, [
        '/backend/backend/roles',
        'sortOrder' => $sortOrder
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">Actions</b>
    </div>

    <?php // Grid data ?>
    <?php foreach ($roles as $roleKey => $role) { ?>

      <div class="grid-data-padding <?= evenOrOdd($roleKey) ?>"><?= $role['role'] ?></div>
      <div class="grid-data-padding <?= evenOrOdd($roleKey) ?>"><?= $role['email'] ?></div>
      <div class="grid-data-padding <?= evenOrOdd($roleKey) ?>"><?= $role['status'] ? '<span class="badge badge-pill badge-success">Active</span>' : '<span class="badge badge-pill badge-secondary">Inactive</span>' ?></div>
      <div class="grid-data-padding <?= evenOrOdd($roleKey) ?>"><?= $role['sort_order'] ?></div>

      <div class="actions grid-data-padding <?= evenOrOdd($roleKey) ?>">
        <a href="/backend/backend/edit-role">Edit</a>
        <a href="#">Delete</a>
      </div>

    <?php } ?>

  </div>

  <?php // Pagination for the grid ?>
  <div class="pagination">pagination goes here</div>

</div>
