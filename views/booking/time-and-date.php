<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 */

use app\assets\DatepickerAsset;
use app\assets\JQueryUIAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = 'Date and Time';

JQueryUIAsset::register($this);
DatepickerAsset::register($this);
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]) ?>

  <h1>Choose a Date and Time</h1>

  <hr>

  <div id="date-and-time">
    <div id="date">
    </div>
    <div id="time">
      <div id="time-container">
        <h2 class="h4">Please select a date</h2>
        <div id="times"></div>
      </div>
    </div>
  </div>

  <hr>

<?php // This is possible ?>
  <script>
    let dates = [
      '2022-03-06 13:30:00',
      '2022-07-30 11:30:00',
      '2022-05-21 13:15:00',
      '2022-03-26 19:30:00',
      '2022-08-09 11:15:00',
      '2022-09-30 17:45:00'
    ];
  </script>

  <?= Html::hiddenInput('view', 'time-and-date') ?>
  <?= Html::hiddenInput('role', $role) ?>
  <?php foreach ($treatments as $treatment) { ?>
    <?= Html::hiddenInput('treatments[]', $treatment) ?>
  <?php } ?>
  <?= Html::hiddenInput('totalDuration', $totalDuration, [
    'id' => 'totalDuration'
  ]) ?>
  <?= Html::hiddenInput('date', '', [
    'id' => 'selectedDate'
  ]) ?>
  <?= Html::hiddenInput('time', '', [
    'id' => 'selectedTime'
  ]) ?>

  <div class="buttons">
    <?= Html::submitButton('Back', [
      'class' => 'btn btn-outline-secondary form-back-btn',
      'name' => 'button',
      'value' => 'back'
    ]) ?>
    <?= Html::submitButton('Next', [
      'class' => 'btn btn-outline-primary form-next-btn',
      'name' => 'button',
      'value' => 'next'
    ]) ?>
  </div>

<?php ActiveForm::end() ?>
