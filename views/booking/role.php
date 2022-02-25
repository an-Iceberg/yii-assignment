<?php

use app\models\Roles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => 'treatment'
]) ?>

  <h1>Choose a Role</h1>

  <hr>

  <?php foreach ($roles as $role) { ?>

    <label style="display: block;">
      <input type="radio" name="role" value="<?= $role['id'] ?>">&nbsp;<?= $role['role_name'] ?>
    </label>

  <?php } ?>

  <hr>

  <div class="buttons">
    <?= Html::a('Back', Url::to('/booking/role'), [
      'class' => 'btn btn-outline-secondary',
      'style' => 'visibility: hidden;'
    ]) ?>

    <?= Html::submitButton('Next', ['class' => 'btn btn-outline-primary']) ?>
  </div>

<?php ActiveForm::end() ?>
