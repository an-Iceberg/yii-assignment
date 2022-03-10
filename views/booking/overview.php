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
      <h2 class="h6">Role</h2>
      <p><?= $role ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">Treatment(s)</h2>
      <div class="treatments">
        <?php foreach ($treatments as $treatment)
        {
          echo '<p>'.$treatment.'</p>';
        } ?>
      </div>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">Date and Time</h2>
      <div class="date-and-time">
        <p><?= $postParams['date'] ?> at <?= $postParams['time'] ?></p>
      </div>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">Personal Information</h2>
      <div class="personal-information">
        <p><span class="capitalize"><?= $postParams['client']['salutation'] ?></span>&nbsp;<?= $postParams['client']['lastName'] ?>&nbsp;<?= $postParams['client']['firstName'] ?> born <?= $postParams['client']['birthdate'] ?></p>
        <p><?= $postParams['client']['street'] ?></p>
        <p><?= $postParams['client']['city'] ?>&nbsp;<?= $postParams['client']['zipCode'] ?></p>
        <p><?= $postParams['client']['email'] ?>&nbsp;<?= $postParams['client']['telephone'] ?></p>
      </div>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">Comment</h2>
      <p><?= $postParams['client']['comment'] ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">New Patient?</h2>
      <p><?= isset($postParams['client']['newPatient']) ? 'Yes' : 'No' ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">Reminder?</h2>
      <p><?= isset($postParams['client']['callback']) ? 'Yes' : 'No' ?></p>
    </div>

    <div class="d-flex flex-row">
      <h2 class="h6">Send confirmation E-Mail?</h2>
      <p><?= isset($postParams['client']['send_confirmation']) ? 'Yes' : 'No' ?></p>
    </div>

  </div>

  <hr>

  <?= Html::hiddenInput('client[salutation]', $postParams['client']['salutation']) ?>
  <?= Html::hiddenInput('client[lastName]', $postParams['client']['lastName']) ?>
  <?= Html::hiddenInput('client[firstName]', $postParams['client']['firstName']) ?>
  <?= Html::hiddenInput('client[birthdate]', $postParams['client']['birthdate']) ?>
  <?= Html::hiddenInput('client[street]', $postParams['client']['street']) ?>
  <?= Html::hiddenInput('client[zipCode]', $postParams['client']['zipCode']) ?>
  <?= Html::hiddenInput('client[city]', $postParams['client']['city']) ?>
  <?= Html::hiddenInput('client[telephone]', $postParams['client']['telephone']) ?>
  <?= Html::hiddenInput('client[email]', $postParams['client']['email']) ?>

  <?php if (isset($postParams['client']['comment']))
  {
    echo Html::hiddenInput('client[comment]', $postParams['client']['comment']);
  } ?>

  <?php if (isset($postParams['client']['newPatient']))
  {
    echo Html::hiddenInput('client[newPatient]', $postParams['client']['newPatient']);
  } ?>

  <?php if (isset($postParams['client']['callback']))
  {
    echo Html::hiddenInput('client[callback]', $postParams['client']['callback']);
  } ?>

  <?php if (isset($postParams['client']['send_confirmation']))
  {
    echo Html::hiddenInput('client[send_confirmation]', $postParams['client']['send_confirmation']);
  } ?>

  <?= Html::hiddenInput('role', $postParams['role']) ?>
  <?php foreach ($postParams['treatments'] as $treatment)
  {
    echo Html::hiddenInput('treatments[]', $treatment);
  } ?>
  <?= Html::hiddenInput('totalDuration', $postParams['totalDuration']) ?>
  <?= Html::hiddenInput('date', $postParams['date']) ?>
  <?= Html::hiddenInput('time', $postParams['time']) ?>
  <?= Html::hiddenInput('view', 'overview') ?>

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
