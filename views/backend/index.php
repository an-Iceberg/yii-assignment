<?php

/**
 * This view expects:
 * @var string $errorMessage
 * @var string $username
 */

use app\assets\BackendIndexCSSAsset;
use app\models\BackendUsers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

$login = new BackendUsers();

$this->title = 'Backend Login';

BackendIndexCSSAsset::register($this);
?>
<div class="gradient-border"></div>

<?php $form = ActiveForm::begin([
  'method' => 'POST',
  'action' => '/backend/index'
]); ?>

  <?php // If the user is a guest, display a login form ?>
  <?php if (Yii::$app->user->isGuest) { ?>

    <h1>Backend Login</h1>

    <div class="form-group backend-login">
      <label for="username">Name</label>
      <input style="padding: 4px !important;" type="text" name="login[username]" id="username" class="form-control" required value="<?php if (isset($username)) {echo $username;} ?>">
    </div>

    <div class="form-group backend-login">
      <label for="password">Password</label>
      <input type="password" name="login[password]" id="password" class="form-control" required>
    </div>

    <div class="form-group">
      <?= Html::submitButton('Login', [
        'class' => 'btn btn-outline-primary',
        'name' => 'button',
        'value' => 'login'
      ]) ?>
    </div>

  <?php // If the user is logged in, display a logout button ?>
  <?php }
  else
  { ?>

    <h1>You are already logged in</h1>

    <div class="form-group">
      <?= Html::a('Go to backend', '/backend/bookings', [
        'class' => 'btn btn-outline-primary'
      ]) ?>

      <?= Html::submitButton('Logout', [
        'class' => 'btn btn-outline-primary',
        'name' => 'button',
        'value' => 'logout'
      ]) ?>
    </div>

  <?php } ?>

  <?php // Error message ?>
  <?php if (isset($errorMessage)) { ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
  <?php } ?>

<?php ActiveForm::end(); ?>


<?php
  // These interesting things are possible in php
  // $stringLength = rand(5, 60);
  // $string = Yii::$app->security->generateRandomString($stringLength);
  // $message = 'The string <br>%string%<br> is <br>%stringLength%<br> characters long.';
  // $message = strtr($message, [
  //   '%string%' => $string,
  //   '%stringLength%' => $stringLength
  // ]);

  // echo $message;
  // echo Yii::$app->name.'<br>';
  // echo Yii::$app->params['customName'].'<br>';
  // echo Yii::$app->requestedRoute.'<br>';

  // echo VarDumper::dump( Yii::$app->user->identity, 10, true);
  // echo '<hr>';
  // echo 'isGuest:'.Yii::$app->user->isGuest.'(empty if false)';
?>
