<?php

$this->title = 'Role Name';
$this->params['currentPage'] = 'roles';
?>

<div class="top-row">
  <a href="/backend/backend/roles">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ Role Name</h1>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<div class="grid-container">
  <label class="input-label"><span>Designation</span>
    <input type="text">
  </label>
  <label class="input-label"><span>E-Mail</span>
    <input type="email">
  </label>
  <label class="input-label description"><span>Description</span>
    <textarea rows="4"></textarea>
  </label>
  <label class="input-label"><span>Sort Order</span>
    <input type="text">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Treatments</span>
    <input type="text">
  </label>

  <label class="input-label"><span>Working Hours</span>
    <input type="text">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Status</span>
    <input type="text">
  </label>
</div>

<div class="save">
  <a href="#" class="btn btn-warning">save</a>
</div>
