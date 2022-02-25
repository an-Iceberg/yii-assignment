<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

?>
<?php ActiveForm::begin([
  'method' => 'post',
  'action' => 'time-and-date'
]) ?>

  <h1>Choose a Treatment</h1>

  <hr>

  <?php foreach ($treatments as $treatment) { ?>

    <label style="display: block;">
      <input type="checkbox" name="treatment[<?= $treatment['id'] ?>]">&nbsp;<?= $treatment['treatment_name'] ?>
    </label>

  <?php } ?>

  <hr>

  <?= Html::hiddenInput('role', $role) ?>

  <div class="buttons">
    <?= Html::a('Back', Url::to('/booking/role'), ['class' => 'btn btn-outline-secondary']) ?>
    <?= Html::submitButton('Next', ['class' => 'btn btn-outline-primary']) ?>
  </div>

<?php ActiveForm::end() ?>
