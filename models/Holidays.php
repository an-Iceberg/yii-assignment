<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property string $name
 * @property string $date
 * @property string|null $beginning_time
 * @property string|null $end_time
 */
class Holidays extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'holidays';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['name', 'date'], 'required'],
      [['date', 'beginning_time', 'end_time'], 'safe'],
      [['name'], 'string', 'max' => 50],
      [['name', 'date'], 'unique', 'targetAttribute' => ['name', 'date']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'name' => 'Name',
      'date' => 'Date',
      'beginning_time' => 'Beginning Time',
      'end_time' => 'End Time',
    ];
  }

  // Returns all holidays
  public static function getHolidays()
  {
    return Holidays::find()
    ->all();
  }
}
