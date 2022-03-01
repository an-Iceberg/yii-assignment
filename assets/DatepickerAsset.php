<?php

namespace app\assets;

use yii\web\AssetBundle;

class DatepickerAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/date-and-time.css'
  ];
  public $js = [
    'js/date-and-time.js'
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}