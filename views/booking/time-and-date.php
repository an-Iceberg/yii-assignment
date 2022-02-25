<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

?>

<?php ActiveForm::begin([
  'method' => 'post',
  'action' => 'personal-info'
]) ?>
  <h1>Time and Date</h1>

  <hr>

  <hr>

  <?= Html::hiddenInput('role', $role) ?>
  <?php foreach ($treatments as $key => $treatment) {
    echo Html::hiddenInput("treatments[$key]", $treatment);
  } ?>

  <div class="buttons">
    <?= Html::a('Back', Url::to('/booking/treatment'), ['class' => 'btn btn-outline-secondary']) ?>
<?php // TODO: create multiple submit buttons and redirect the user if necessary ?>
    <?= Html::submitButton('Next', ['class' => 'btn btn-outline-primary']) ?>
  </div>

<?php ActiveForm::end() ?>