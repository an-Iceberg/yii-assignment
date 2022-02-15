<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property int $id
 * @property string|null $holiday_name
 * @property string|null $date
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
      [['date', 'beginning_time', 'end_time'], 'safe'],
      [['holiday_name'], 'string', 'max' => 50],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'Holiday ID',
      'holiday_name' => 'Name',
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
