<?php

/**
 * This view expects:
 * @var int $role
 * @var array $treatments
 * @var array $selectedTreatments
 * @var bool $error
 */

use app\assets\NextAndBackButtonsAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = 'Treatment';

NextAndBackButtonsAsset::register($this);
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]) ?>

  <h1>Choose a Treatment</h1>

  <hr>

  <?php foreach ($treatments as $treatment) { ?>

    <label style="display: block;">
      <input
      type="checkbox"
      name="treatments[]"
      value="<?= $treatment['id'] ?>"
      <?php
        if (isset($selectedTreatments))
        {
          foreach ($selectedTreatments as $item)
          {
            if ($item == $treatment['id'])
            {
              echo 'checked';
            }
          }
        }
      ?>
      >
      &nbsp;<?= $treatment['treatment_name'] ?>
    </label>

  <?php } ?>

  <?php if (isset($error)) { ?>
    <div class="alert alert-danger" role="alert">Please select a treatment from the list above.</div>
  <?php } ?>

  <hr>

  <?= Html::hiddenInput('view', 'treatment') ?>
  <?= Html::hiddenInput('role', $role) ?>

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
