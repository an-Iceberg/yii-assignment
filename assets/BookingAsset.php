<?php

namespace app\assets;

use yii\web\AssetBundle;

class BookingAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $js = [
    'js/booking.js',
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}