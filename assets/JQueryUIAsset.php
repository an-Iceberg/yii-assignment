<?php

namespace app\assets;

use yii\web\AssetBundle;

class JQueryUIAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
  ];
  public $js = [
    'js/jquery-ui.min.js'
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}