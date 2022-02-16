<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = $holiday->holiday_name;
$this->params['currentPage'] = 'holidays';
?>

<div class="top-row">
  <a href="/backend/holidays">
    <i class="nf nf-fa-chevron_left"></i>
  </a>

  <h1 class="h3">&nbsp;/ <?= $holiday->holiday_name ?></h1>
</div>

<?php // Language switcher ?>
<div class="language-switcher">
  <a href="#" class="language active-language">Deutsch</a>
  <a href="#" class="language">English</a>
  <a href="#" class="language">Français</a>
</div>

<?php
  $form = ActiveForm::begin([
    'action' => '/backend/edit-holiday',
    'method' => 'post'
  ])
?>

<div class="grid-container">
  <?php // Name ?>
  <label class="input-label"><span>Name</span>
    <input type="text" value="<?= $holiday->holiday_name ?>" name="holiday_name">
  </label>

  <?php // Date ?>
  <label class="input-label"><span>Date</span>
    <input type="date" value="<?= $holiday->date ?>" name="date">
  </label>

  <?php // Beginning time ?>
  <label class="input-label"><span>From</span>
    <?= $this->render('partials/holiday-time-select', [
      'holiday' => $holiday,
      'label' => 'beginning_time'
    ]) ?>
  </label>

  <?php // End time ?>
  <label class="input-label last-input-element"><span>Until</span>
    <?= $this->render('partials/holiday-time-select', [
      'holiday' => $holiday,
      'label' => 'end_time'
    ]) ?>
  </label>

  <input type="hidden" name="id" value="<?= $holiday->id ?>" readonly>

</div>

<div class="save">
  <?= Html::submitButton('Save Changes', ['class' => 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end() ?>
