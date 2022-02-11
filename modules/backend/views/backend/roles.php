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

// Setting the arrows only if the sorting criterium is present
if (isset($getParams['roleSort']))
{
  setArrow('roleSort', $roleArrow, $getParams);
}
elseif (isset($getParams['emailSort']))
{
  setArrow('emailSort', $emailArrow, $getParams);
}
elseif (isset($getParams['statusSort']))
{
  setArrow('statusSort', $statusArrow, $getParams);
}
elseif (isset($getParams['sortOrder']))
{
  setArrow('sortOrder', $sortOrderArrow, $getParams);
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
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <input type="text" class="grid-margins search-field">
    <div></div>

    <?php // Field titles ?>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Role</b>'.$roleArrow, [
        '/backend/backend/roles',
         'roleSort' => (isset($getParams['roleSort']) && $getParams['roleSort'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">E-Mail</b>'.$emailArrow, [
        '/backend/backend/roles',
         'emailSort' => (isset($getParams['emailSort']) && $getParams['emailSort'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Status</b>'.$statusArrow, [
        '/backend/backend/roles',
         'statusSort' => (isset($getParams['statusSort']) && $getParams['statusSort'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <?php // Generates a link with URL parameters according to which the roles shall be sorted ?>
      <?= Html::a('<b class="grid-margins">Sort Order</b>'.$sortOrderArrow, [
        '/backend/backend/roles',
         'sortOrder' => (isset($getParams['sortOrder']) && $getParams['sortOrder'] == 2) ? 1 : 2
        ]);
      ?>
    </div>
    <div class="field-title grid-margins-top">
      <b class="grid-margins">Actions</b>
    </div>

    <?php // Grid data ?>
    <?php foreach ($roles as $roleKey => $role) { ?>

      <div class="grid-data-padding <?= $roleKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $role['role'] ?></div>
      <div class="grid-data-padding <?= $roleKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $role['email'] ?></div>
      <div class="grid-data-padding <?= $roleKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $role['status'] ? '<span class="badge badge-pill badge-success">Active</span>' : '<span class="badge badge-pill badge-secondary">Inactive</span>' ?></div>
      <div class="grid-data-padding <?= $roleKey % 2 == 0 ? 'even' : 'odd' ?>"><?= $role['sort_order'] ?></div>

      <div class="actions grid-data-padding <?= $roleKey % 2 == 0 ? 'even' : 'odd' ?>">
        <a href="/backend/backend/edit-role">Edit</a>
        <a href="#">Delete</a>
      </div>

    <?php } ?>

  </div>

  <?php // Pagination for the grid ?>
  <div class="pagination">pagination goes here</div>

</div>
