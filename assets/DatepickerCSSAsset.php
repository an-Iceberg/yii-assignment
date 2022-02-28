<?php

namespace app\assets;

use yii\web\AssetBundle;

class DatepickerCSSAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/datepicker.min.css'
  ];
  public $js = [
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
  ];
}
