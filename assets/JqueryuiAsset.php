<?php

namespace app\assets;

use yii\web\AssetBundle;

class JqueryuiAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $js = [
    'js/jquery-ui.min.js',
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}