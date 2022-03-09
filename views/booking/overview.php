<?php

use app\assets\NextAndBackButtonsAsset;
use app\assets\OverviewCSSAsset;
use yii\helpers\Html;
use yii\helpers\VarDumper;
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

  <div class="grid-container">

    <div class="d-flex flex-row">
      <h2 class="h4">Role</h2>
      <p><?= $role ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">Treatment(s)</h2>
      <div class="treatments">
        <?php foreach ($treatments as $treatment)
        {
          echo '<p>'.$treatment.'</p>';
        } ?>
      </div>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">Date and Time</h2>
      <div class="date-and-time">
        <p><?= $postParams['date'] ?> at <?= $postParams['time'] ?></p>
      </div>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">Personal Information</h2>
      <div class="personal-information">
        <p><span class="capitalize"><?= $postParams['salutation'] ?></span>&nbsp;<?= $postParams['lastName'] ?>&nbsp;<?= $postParams['firstName'] ?> born <?= $postParams['birthdate'] ?></p>
        <p><?= $postParams['street'] ?></p>
        <p><?= $postParams['city'] ?>&nbsp;<?= $postParams['zipCode'] ?></p>
        <p><?= $postParams['email'] ?>&nbsp;<?= $postParams['telephone'] ?></p>
      </div>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">Comment</h2>
      <p><?= $postParams['comment'] ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">New Patient?</h2>
      <p><?= isset($postParams['newPatient']) ? 'Yes' : 'No' ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">Reminder?</h2>
      <p><?= isset($postParams['callback']) ? 'Yes' : 'No' ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h4">Send confirmation E-Mail?</h2>
      <p><?= isset($postParams['send_confirmation']) ? 'Yes' : 'No' ?></p>
    </div>

  </div>

  <hr>

  <?= Html::hiddenInput('lastName', $postParams['lastName']) ?>
  <?= Html::hiddenInput('firstName', $postParams['firstName']) ?>
  <?= Html::hiddenInput('birthdate', $postParams['birthdate']) ?>
  <?= Html::hiddenInput('street', $postParams['street']) ?>
  <?= Html::hiddenInput('zipCode', $postParams['zipCode']) ?>
  <?= Html::hiddenInput('city', $postParams['city']) ?>
  <?= Html::hiddenInput('telephone', $postParams['telephone']) ?>
  <?= Html::hiddenInput('email', $postParams['email']) ?>

  <?php if (isset($postParams['comment']))
  {
    echo Html::hiddenInput('comment', $postParams['comment']);
  } ?>

  <?php if (isset($postParams['newPatient']))
  {
    echo Html::hiddenInput('newPatient', $postParams['newPatient']);
  } ?>

  <?php if (isset($postParams['callback']))
  {
    echo Html::hiddenInput('callback', $postParams['callback']);
  } ?>

  <?php if (isset($postParams['send_confirmation']))
  {
    echo Html::hiddenInput('send_confirmation', $postParams['send_confirmation']);
  } ?>

  <?= Html::hiddenInput('role', $postParams['role']) ?>
  <?php foreach ($postParams['treatments'] as $treatment)
  {
    echo Html::hiddenInput('treatment[]', $treatment);
  } ?>
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
