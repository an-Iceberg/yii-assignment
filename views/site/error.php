<?php

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;

?>
<div class="site-error">

  <h1><?= Html::encode($this->title) ?></h1>
  <p><?= nl2br(Html::encode($message)) ?></p>

  <br><hr><br>

  <p>Why don't you enjoy a cup of calming jasmin tea.</p>
  <img src="<?= Url::to('@web/css/images/uncle_iroh.jpg') ?>" alt="Uncle Iroh" style="max-width: 347px;">

</div>
