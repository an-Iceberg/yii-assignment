<?php

use yii\helpers\Html;
?>

<?= $message ?>
<br>

<?= Html::a('Try again', '/site/booking', [
  'class' => 'mt-3 btn btn-primary'
]) ?>