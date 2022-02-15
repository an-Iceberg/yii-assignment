<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "who_has_holidays".
 *
 * @property int|null $role_id
 * @property int|null $holiday_id
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
      [['role_id', 'holiday_id'], 'integer']
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
