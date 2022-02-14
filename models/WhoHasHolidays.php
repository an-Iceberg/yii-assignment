<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "who_has_holidays".
 *
 * @property string $role
 * @property string $holiday_name
 * @property string|null $holiday_date
 */
class WhoHasHolidays extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'who_has_holidays';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['role', 'holiday_name'], 'required'],
      [['holiday_date'], 'safe'],
      [['role', 'holiday_name'], 'string', 'max' => 50],
      [['role', 'holiday_name'], 'unique', 'targetAttribute' => ['role', 'holiday_name']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'role' => 'Role',
      'holiday_name' => 'Holiday Name',
      'holiday_date' => 'Holiday Date',
    ];
  }
}
