<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 */

use app\assets\DateAndTimeCSSAsset;
use app\assets\DatepickerCSSAsset;
use app\assets\DatepickerJSAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = 'Date and Time';

DatepickerJSAsset::register($this);
DatepickerCSSAsset::register($this);
DateAndTimeCSSAsset::register($this);
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]) ?>

  <h1>Choose a Date and Time</h1>

  <hr>

  <div id="date-and-time">
    <div id="date">
      <input type="text" name="" class="datepicker-here" id="datepicker">
    </div>
    <div id="time"></div>
  </div>

  <hr>

  <?= Html::hiddenInput('view', 'time-and-date') ?>
  <?= Html::hiddenInput('role', $role) ?>
  <?php foreach ($treatments as $treatment) { ?>
    <?= Html::hiddenInput('treatments[]', $treatment) ?>
  <?php } ?>

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
