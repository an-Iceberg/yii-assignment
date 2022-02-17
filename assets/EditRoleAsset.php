<?php

namespace app\assets;

use yii\web\AssetBundle;

class EditRoleAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $js = [
    'js/edit-role.js',
  ];
  public $depends = [
    'yii\web\YiiAsset'
  ];
}