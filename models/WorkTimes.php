<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_times".
 *
 * @property string|null $role
 * @property string|null $from
 * @property string|null $til
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
      [['from', 'til'], 'safe'],
      [['has_free'], 'boolean'],
      [['role'], 'string', 'max' => 50],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'role' => 'Role',
      'from' => 'From',
      'til' => 'Untill',
      'has_free' => 'Has Free',
    ];
  }
}
