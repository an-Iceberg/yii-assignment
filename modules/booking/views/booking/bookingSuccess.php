<?php

use yii\helpers\Html;
?>
<?= $message ?>
<br>

<?= Html::a('Back to homepage', '/site/index', [
  'class' => 'mt-3 btn btn-primary'
]) ?>