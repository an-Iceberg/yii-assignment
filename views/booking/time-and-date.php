<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 * @var int $totalDuration
 */

use app\assets\DatepickerAsset;
use app\assets\JQueryUIAsset;
use app\assets\NextAndBackButtonsAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = 'Date and Time';

JQueryUIAsset::register($this);
DatepickerAsset::register($this);
NextAndBackButtonsAsset::register($this);
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

  <div class="legend">
    <div class="square-container"><div class="square selected-day"></div><span>Selected Day</span></div>
    <div class="square-container"><div class="square open-days"></div><span>Open Days</span></div>
    <div class="square-container"><div class="square today"></div><span>Today</span></div>
  </div>

  <hr>

  <?= Html::hiddenInput('view', 'time-and-date') ?>
  <?= Html::hiddenInput('role', $role, [
    'id' => 'role'
  ]) ?>
  <?php foreach ($treatments as $treatment) { ?>
    <?= Html::hiddenInput('treatments[]', $treatment) ?>
  <?php } ?>
  <?= Html::hiddenInput('totalDuration', $totalDuration, [
    'id' => 'totalDuration'
  ]) ?>
  <?= Html::hiddenInput('date', '', [
    'id' => 'selectedDate'
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

<script>
  // Initializes the holidays as a JSON object
  let holidays = [
    <?php foreach ($holidays as $holiday) {
      echo '{';
      echo '"year": '.$holiday['year'].',';
      echo '"month": '.$holiday['month'].',';
      echo '"day": '.$holiday['day'];
      echo '},';
    } ?>
  ];
</script>
