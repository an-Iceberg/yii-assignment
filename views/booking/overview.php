<?php

use app\assets\NextAndBackButtonsAsset;
use app\assets\OverviewCSSAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

NextAndBackButtonsAsset::register($this);
OverviewCSSAsset::register($this);
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]); ?>

  <h1>Overview</h1>

  <hr>

  <h2 class="h4">Role</h2>
  <h2 class="h4">Treatment(s)</h2>
  <h2 class="h4">Date and Time</h2>
  <h2 class="h4">Personal Information</h2>
  <h2 class="h4">Comment</h2>
  <h2 class="h4">New Patient?</h2>
  <h2 class="h4">Reminder?</h2>
  <h2 class="h4">Send confirmation E-Mail?</h2>

  <hr>

  <?= Html::hiddenInput('lastName', $postParams['lastName']) ?>
  <?= Html::hiddenInput('firstName', $postParams['firstName']) ?>
  <?= Html::hiddenInput('birthdate', $postParams['birthdate']) ?>
  <?= Html::hiddenInput('street', $postParams['street']) ?>
  <?= Html::hiddenInput('zipCode', $postParams['zipCode']) ?>
  <?= Html::hiddenInput('city', $postParams['city']) ?>
  <?= Html::hiddenInput('telephone', $postParams['telephone']) ?>
  <?= Html::hiddenInput('email', $postParams['email']) ?>

  <?php
    if (isset($postParams['comment']))
    {
      echo Html::hiddenInput('comment', $postParams['comment']);
    }
  ?>

  <?php
    if (isset($postParams['newPatient']))
    {
      echo Html::hiddenInput('newPatient', $postParams['newPatient']);
    }
  ?>

  <?php
    if (isset($postParams['callback']))
    {
      echo Html::hiddenInput('callback', $postParams['callback']);
    }
  ?>

  <?php
    if (isset($postParams['send_confirmation']))
    {
      echo Html::hiddenInput('send_confirmation', $postParams['send_confirmation']);
    }
  ?>

  <?= Html::hiddenInput('role', $postParams['role']) ?>
  <?php foreach ($postParams['treatments'] as $treatment)
  {
    echo Html::hiddenInput('treatment[]', $treatment);
  }
  ?>
  <?= Html::hiddenInput('totalDuration', $postParams['totalDuration']) ?>
  <?= Html::hiddenInput('date', $postParams['date']) ?>
  <?= Html::hiddenInput('time', $postParams['time']) ?>

  <div class="buttons">
    <?= Html::submitButton('Back', [
      'class' => 'btn btn-outline-secondary form-back-btn',
      'name' => 'button',
      'value' => 'back'
    ]) ?>
    <?= Html::submitButton('Submit', [
      'class' => 'btn btn-outline-primary form-next-btn',
      'name' => 'button',
      'value' => 'submit'
    ]) ?>
  </div>

<?php ActiveForm::end() ?>
