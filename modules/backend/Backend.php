<?php

namespace app\modules\backend;

class Backend extends \yii\base\Module
{
  public function init()
  {
    parent::init();
    $this->layout = '@app/modules/backend/views/layouts/main.php';
  }
}
