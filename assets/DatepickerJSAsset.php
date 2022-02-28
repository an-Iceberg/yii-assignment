<?php

namespace app\assets;

use yii\web\AssetBundle;

class DatepickerJSAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
  ];
  public $js = [
    'js/datepicker.min.js'
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
  ];
}
