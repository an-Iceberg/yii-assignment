<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body class="d-flex flex-row h-100">
<?php $this->beginBody() ?>

<div style="width: 150px; background: red;">
  <ul>
    <a href="/backend/backend/bookings"><li>Bookings</li></a>
    <a href="/backend/backend/calendar"><li>Calendar</li></a>
    <a href="/backend/backend/roles"><li>Roles</li></a>
    <a href="/backend/backend/holidays"><li>Holidays</li></a>
  </ul>
</div>

<main role="main" class="flex-shrink-0">
  <?= $content ?>
</main>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
