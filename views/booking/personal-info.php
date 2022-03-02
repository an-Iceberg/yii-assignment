<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 * @var int $totalDuration
 * @var string $time
 * @var string $date
 */

use app\assets\NextAndBackButtonsAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

NextAndBackButtonsAsset::register($this);
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]) ?>

  <h1>Please enter your personal Information</h1>

  <hr>

  <p>Inputs go here</p>

  <hr>

  <?= Html::hiddenInput('view', 'personal-info') ?>
  <?= Html::hiddenInput('role', $role, [
    'id' => 'role'
  ]) ?>
  <?php foreach ($treatments as $treatment) { ?>
    <?= Html::hiddenInput('treatments[]', $treatment) ?>
  <?php } ?>
  <?= Html::hiddenInput('totalDuration', $totalDuration) ?>
  <?= Html::hiddenInput('date', $date) ?>
  <?= Html::hiddenInput('time', $time) ?>

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