<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "who_has_holidays".
 *
 * @property int $role_id
 * @property int $holiday_id
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
      [['role_id', 'holiday_id'], 'required'],
      [['role_id', 'holiday_id'], 'integer'],
      [['role_id', 'holiday_id'], 'unique', 'targetAttribute' => ['role_id', 'holiday_id']]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'role_id' => 'Role ID',
      'holiday_id' => 'Holiday ID'
    ];
  }
}
