<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\VarDumper;

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

<?php // The navigation bar on the left side ?>
<div class="backend-nav">
  <ul>
    <?php // Applying conditional formatting to the selected nav element
    // TODO: find a better solution, this is very janky ?>
    <a class="backend-nav-link" href="/backend/bookings">
      <li class="<?= $this->params['currentPage'] == 'bookings' ? 'selected-nav' : '' ?>">
        Bookings
      </li>
    </a>
    <a class="backend-nav-link" href="/backend/calendar">
      <li class="<?= $this->params['currentPage'] == 'calendar' ? 'selected-nav' : '' ?>">
        Calendar
      </li>
    </a>
    <a class="backend-nav-link" href="/backend/roles">
      <li class="<?= $this->params['currentPage'] == 'roles' ? 'selected-nav' : '' ?>">
        Roles
      </li>
    </a>
    <a class="backend-nav-link" href="/backend/holidays">
      <li class="<?= $this->params['currentPage'] == 'holidays' ? 'selected-nav' : '' ?>">
        Holidays
      </li>
    </a>
  </ul>
</div>

<main role="main" class="main backend-main flex-shrink-0">
  <?= $content ?>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
