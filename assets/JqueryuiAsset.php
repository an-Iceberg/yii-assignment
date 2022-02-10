<?php

namespace app\assets;

use yii\web\AssetBundle;

class JqueryuiAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/jquery-ui-1.10.0.custom.css',
  ];
  public $js = [
    'js/jquery-ui.min.js',
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}