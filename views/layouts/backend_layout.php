<?php

use app\assets\AppAsset;
use app\assets\BackendCSSAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

AppAsset::register($this);
BackendCSSAsset::register($this);
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
    <?php // Applying conditional formatting to the selected nav element ?>
    <li>
      <a href="/backend/bookings">
        <div class="backend-nav-link <?= $this->params['currentPage'] == 'bookings' ? 'selected-nav' : '' ?>">Bookings</div>
      </a>
    </li>
    <li>
      <a href="/backend/calendar">
        <div class="backend-nav-link <?= $this->params['currentPage'] == 'calendar' ? 'selected-nav' : '' ?>">Calendar</div>
      </a>
    </li>
    <li>
      <a href="/backend/roles">
        <div class="backend-nav-link <?= $this->params['currentPage'] == 'roles' ? 'selected-nav' : '' ?>">Roles</div>
      </a>
    </li>
    <li>
      <a href="/backend/holidays">
        <div class="backend-nav-link <?= $this->params['currentPage'] == 'holidays' ? 'selected-nav' : '' ?>">Holidays</div>
      </a>
    </li>

    <li class="spacer"></li>

    <li class="logout-button-container">
      <?php $form = ActiveForm::begin([
        'method' => 'POST',
        'action' => '/backend/index'
      ]); ?>

      <?= Html::submitButton('<i class="nf nf-mdi-logout logout-icon"></i> Logout', [
        'class' => 'logout-button',
        'name' => 'button',
        'value' => 'logout'
      ]) ?>

      <?php ActiveForm::end(); ?>
    </li>

  </ul>

</div>

<main role="main" class="main backend-main flex-shrink-0">
  <?= $content ?>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
