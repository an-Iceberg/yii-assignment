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

  public static function getHolidaysForRole($role)
  {
      $query = Yii::$app->db->createCommand(
        'SELECT holidays.date, holidays.beginning_time, holidays.end_time
        FROM roles
        JOIN who_has_holidays ON roles.id = who_has_holidays.role_id
        JOIN holidays ON who_has_holidays.holiday_id = holidays.id
        WHERE roles.id = :role_id;',
        [
          ':role_id' => intval($role)
        ]
      );

      return $query->queryAll();
  }
}
