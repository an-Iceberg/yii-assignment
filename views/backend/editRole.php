<?php

use yii\helpers\VarDumper;

$this->title = $role->role_name;
$this->params['currentPage'] = 'roles';
?>

<div class="top-row">
  <a href="/backend/roles">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ <?= $role->role_name ?></h1>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language active-language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<div class="grid-container">
<!-- <?= VarDumper::dump($role, 10, true) ?> -->
  <label class="input-label"><span>Designation</span>
    <input type="text" value="<?= $role->role_name ?>">
  </label>
  <label class="input-label"><span>E-Mail</span>
    <input type="email" value="<?= $role->email ?>">
  </label>
  <label class="input-label description"><span>Description</span>
    <textarea rows="4"><?= $role->description ?></textarea>
  </label>
  <label class="input-label"><span>Sort Order</span>
    <input type="text" value="<?= $role->sort_order ?>">
  </label>

  <div class="break"></div>

  <label class="input-label"><span>Duration (min)</span>
    <select name="">
      <option value="15">15</option>
      <option value="30">30</option>
      <option value="60">60</option>
      <option value="90">90</option>
      <option value="120">120</option>
      <option value="150">150</option>
      <option value="180">180</option>
      <option value="210">210</option>
      <option value="240">240</option>
      <option value="270">270</option>
      <option value="300">300</option>
      <option value="330">330</option>
      <option value="360">360</option>
      <option value="390">390</option>
      <option value="420">420</option>
      <option value="450">450</option>
      <option value="480">480</option>
      <option value="510">510</option>
    </select>
  </label>

  <label class="input-label"><span>Treatments</span>
    <input type="text">
  </label>

<!-- Here, the working hours can be filled in statically -->
  <div class="input-label"><span>Working Hours</span>
    <div>
      <div>Monday</div>
        <label>From</label><label>Until</label><label>Has Free</label>
      <div>Tuesday</div>
      <div>Wednesday</div>
      <div>Thursday</div>
      <div>Friday</div>
      <div>Saturday</div>
      <div>Sunday</div>
    </div>
  </div>

  <div class="break"></div>

  <label class="input-label last-input-element"><span>Status</span>
    <input type="text">
  </label>
</div>

<div class="save">
  <a href="#" class="btn btn-warning">save</a>
</div>
