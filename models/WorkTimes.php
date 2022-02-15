<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_times".
 *
 * @property int $role_id
 * @property int $weekday
 * @property string|null $from
 * @property string|null $until
 * @property bool|null $has_free
 */
class WorkTimes extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'work_times';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['role_id', 'weekday'], 'required'],
      [['role_id', 'weekday'], 'integer'],
      [['from', 'until'], 'safe'],
      [['has_free'], 'boolean'],
      [['role_id', 'weekday'], 'unique', 'targetAttribute' => ['role_id', 'weekday']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'role_id' => 'Role ID',
      'from' => 'From',
      'until' => 'Until',
      'has_free' => 'Has Free',
    ];
  }
}
