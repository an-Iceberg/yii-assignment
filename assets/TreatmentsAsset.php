<?php

namespace app\assets;

use yii\web\AssetBundle;

class TreatmentsAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $js = [
    'js/treatments.js',
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}