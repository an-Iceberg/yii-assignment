<?php

$this->title = 'Roles';
$this->params['currentPage'] = 'roles';
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
      <a href="#">
        <b class="grid-margins">Role</b>
      </a>
    </div>
    <div class="field-title grid-margins-top">
      <a href="#">
        <b class="grid-margins">E-Mail</b>
      </a>
    </div>
    <div class="field-title grid-margins-top">
      <a href="#">
        <b class="grid-margins">Status</b>
      </a>
    </div>
    <div class="field-title grid-margins-top">
      <a href="#">
        <b class="grid-margins">Sort Order</b>
      </a>
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