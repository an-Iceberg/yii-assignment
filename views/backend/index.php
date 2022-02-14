<?php

use app\models\BackendUsers;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$login = new BackendUsers();
?>

<h1>Backend Login</h1>

<?php $form = ActiveForm::begin([
  'method' => 'POST',
  'action' => '/backend/backend/index'
]); ?>

  <div class="form-group backend-login">
    <label for="username">Name</label>
      <input style="padding: 4px !important;" type="text" name="backend-login[username]" id="username" class="form-control" required>
  </div>

  <div class="form-group backend-login">
    <label for="password">Password</label>
      <input type="password" name="backend-login[password]" id="password" class="form-control" required>
  </div>

  <div class="form-group">
    <?= Html::submitButton('Login', [
      'class' => 'btn btn-primary'
    ]) ?>
  </div>

<?php ActiveForm::end(); ?>

<pre>
  <?php
    if (isset($data))
    {
      echo VarDumper::dump($data, 10, true);
    }
  ?>
</pre>
