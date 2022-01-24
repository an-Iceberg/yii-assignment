<?php

namespace app\models;

class Service extends \yii\db\ActiveRecord
{
  public $treatment;

  public static function tableName()
  {
    return 'services';
  }
}