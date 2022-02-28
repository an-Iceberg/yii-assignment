<?php

/**
 * This view expects:
 * @var array $roles
 * @var int $selectedRole
 */

use app\models\Roles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$this->title = 'Role';
?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => '/booking'
]) ?>

  <h1>Choose a Role</h1>

  <hr>

  <?php foreach ($roles as $role) { ?>

    <label style="display: block;">
      <input
      type="radio"
      name="role"
      value="<?= $role['id'] ?>"
      <?php
        if (isset($selectedRole) && intval($selectedRole) == $role['id'])
        {
          echo 'checked';
        }
      ?>
      >
      &nbsp;<?= $role['role_name'] ?>
    </label>

  <?php } ?>

  <hr>

  <?= Html::hiddenInput('view', 'role') ?>

  <div class="buttons">
    <?= Html::submitButton('Back', [
      'class' => 'btn btn-outline-secondary form-back-btn',
      'name' => 'button',
      'value' => 'back',
      'style' => 'visibility: hidden;'
    ]) ?>
    <?= Html::submitButton('Next', [
      'class' => 'btn btn-outline-primary form-next-btn',
      'name' => 'button',
      'value' => 'next'
    ]) ?>
  </div>

<?php ActiveForm::end() ?>
