<?php

namespace app\models;

class Profession extends \yii\db\ActiveRecord
{
  public $doctor;

  public static function tableName()
  {
    return 'professions';
  }
}