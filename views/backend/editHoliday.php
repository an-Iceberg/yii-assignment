<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = 'Holiday Name';
$this->params['currentPage'] = 'holidays';
?>

<div class="top-row">
  <a href="/backend/holidays">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ Holiday Name</h1>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language active-language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<?php
  $form = ActiveForm::begin([
    'action' => '/backend/edit-holiday'
  ])
?>

<div class="grid-container">
  <label class="input-label"><span>Name</span>
    <input type="text" value="<?= $holiday['name'] ?>" name="name">
  </label>

  <label class="input-label"><span>Date</span>
    <input type="date" value="<?= $holiday['date'] ?>" name="date">
  </label>

  <label class="input-label"><span>From</span>
    <select name="beginning_time">
      <option value="08:00" <?= ($holiday['beginning_time'] == '08:00:00') ? 'selected' : '' ?>>8:00</option>
      <option value="08:30" <?= ($holiday['beginning_time'] == '08:30:00') ? 'selected' : '' ?>>8:30</option>
      <option value="09:00" <?= ($holiday['beginning_time'] == '09:00:00') ? 'selected' : '' ?>>9:00</option>
      <option value="09:30" <?= ($holiday['beginning_time'] == '09:30:00') ? 'selected' : '' ?>>9:30</option>
      <option value="10:00" <?= ($holiday['beginning_time'] == '10:00:00') ? 'selected' : '' ?>>10:00</option>
      <option value="10:30" <?= ($holiday['beginning_time'] == '10:30:00') ? 'selected' : '' ?>>10:30</option>
      <option value="11:00" <?= ($holiday['beginning_time'] == '11:00:00') ? 'selected' : '' ?>>11:00</option>
      <option value="11:30" <?= ($holiday['beginning_time'] == '11:30:00') ? 'selected' : '' ?>>11:30</option>
      <option value="12:00" <?= ($holiday['beginning_time'] == '12:00:00') ? 'selected' : '' ?>>12:00</option>
      <option value="12:30" <?= ($holiday['beginning_time'] == '12:30:00') ? 'selected' : '' ?>>12:30</option>
      <option value="13:00" <?= ($holiday['beginning_time'] == '13:00:00') ? 'selected' : '' ?>>13:00</option>
      <option value="13:30" <?= ($holiday['beginning_time'] == '13:30:00') ? 'selected' : '' ?>>13:30</option>
      <option value="14:00" <?= ($holiday['beginning_time'] == '14:00:00') ? 'selected' : '' ?>>14:00</option>
      <option value="14:30" <?= ($holiday['beginning_time'] == '14:30:00') ? 'selected' : '' ?>>14:30</option>
      <option value="15:00" <?= ($holiday['beginning_time'] == '15:00:00') ? 'selected' : '' ?>>15:00</option>
      <option value="15:30" <?= ($holiday['beginning_time'] == '15:30:00') ? 'selected' : '' ?>>15:30</option>
      <option value="16:00" <?= ($holiday['beginning_time'] == '16:00:00') ? 'selected' : '' ?>>16:00</option>
      <option value="16:30" <?= ($holiday['beginning_time'] == '16:30:00') ? 'selected' : '' ?>>16:30</option>
      <option value="17:00" <?= ($holiday['beginning_time'] == '17:00:00') ? 'selected' : '' ?>>17:00</option>
      <option value="17:30" <?= ($holiday['beginning_time'] == '17:30:00') ? 'selected' : '' ?>>17:30</option>
      <option value="18:00" <?= ($holiday['beginning_time'] == '18:00:00') ? 'selected' : '' ?>>18:00</option>
      <option value="18:30" <?= ($holiday['beginning_time'] == '18:30:00') ? 'selected' : '' ?>>18:30</option>
      <option value="19:00" <?= ($holiday['beginning_time'] == '19:00:00') ? 'selected' : '' ?>>19:00</option>
      <option value="19:30" <?= ($holiday['beginning_time'] == '19:30:00') ? 'selected' : '' ?>>19:30</option>
      <option value="20:00" <?= ($holiday['beginning_time'] == '20:00:00') ? 'selected' : '' ?>>20:00</option>
    </select>
  </label>

  <label class="input-label"><span>Until</span>
    <select name="end_time">
      <option value="08:00" <?= ($holiday['end_time'] == '08:00:00') ? 'selected' : '' ?>>8:00</option>
      <option value="08:30" <?= ($holiday['end_time'] == '08:30:00') ? 'selected' : '' ?>>8:30</option>
      <option value="09:00" <?= ($holiday['end_time'] == '09:00:00') ? 'selected' : '' ?>>9:00</option>
      <option value="09:30" <?= ($holiday['end_time'] == '09:30:00') ? 'selected' : '' ?>>9:30</option>
      <option value="10:00" <?= ($holiday['end_time'] == '10:00:00') ? 'selected' : '' ?>>10:00</option>
      <option value="10:30" <?= ($holiday['end_time'] == '10:30:00') ? 'selected' : '' ?>>10:30</option>
      <option value="11:00" <?= ($holiday['end_time'] == '11:00:00') ? 'selected' : '' ?>>11:00</option>
      <option value="11:30" <?= ($holiday['end_time'] == '11:30:00') ? 'selected' : '' ?>>11:30</option>
      <option value="12:00" <?= ($holiday['end_time'] == '12:00:00') ? 'selected' : '' ?>>12:00</option>
      <option value="12:30" <?= ($holiday['end_time'] == '12:30:00') ? 'selected' : '' ?>>12:30</option>
      <option value="13:00" <?= ($holiday['end_time'] == '13:00:00') ? 'selected' : '' ?>>13:00</option>
      <option value="13:30" <?= ($holiday['end_time'] == '13:30:00') ? 'selected' : '' ?>>13:30</option>
      <option value="14:00" <?= ($holiday['end_time'] == '14:00:00') ? 'selected' : '' ?>>14:00</option>
      <option value="14:30" <?= ($holiday['end_time'] == '14:30:00') ? 'selected' : '' ?>>14:30</option>
      <option value="15:00" <?= ($holiday['end_time'] == '15:00:00') ? 'selected' : '' ?>>15:00</option>
      <option value="15:30" <?= ($holiday['end_time'] == '15:30:00') ? 'selected' : '' ?>>15:30</option>
      <option value="16:00" <?= ($holiday['end_time'] == '16:00:00') ? 'selected' : '' ?>>16:00</option>
      <option value="16:30" <?= ($holiday['end_time'] == '16:30:00') ? 'selected' : '' ?>>16:30</option>
      <option value="17:00" <?= ($holiday['end_time'] == '17:00:00') ? 'selected' : '' ?>>17:00</option>
      <option value="17:30" <?= ($holiday['end_time'] == '17:30:00') ? 'selected' : '' ?>>17:30</option>
      <option value="18:00" <?= ($holiday['end_time'] == '18:00:00') ? 'selected' : '' ?>>18:00</option>
      <option value="18:30" <?= ($holiday['end_time'] == '18:30:00') ? 'selected' : '' ?>>18:30</option>
      <option value="19:00" <?= ($holiday['end_time'] == '19:00:00') ? 'selected' : '' ?>>19:00</option>
      <option value="19:30" <?= ($holiday['end_time'] == '19:30:00') ? 'selected' : '' ?>>19:30</option>
      <option value="20:00" <?= ($holiday['end_time'] == '20:00:00') ? 'selected' : '' ?>>20:00</option>
    </select>
  </label>

  <!-- This input is not safe from user manipulation -->
  <input type="hidden" name="old_name" value="<?=$holiday['name']?>" readonly>

</div>

<div class="save">
  <?= Html::submitButton('Save Changes', ['class' => 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end() ?>
<?php
  if (isset($getInput))
  {
    echo VarDumper::dump($getInput, 10, true);
  }
?>
