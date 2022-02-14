<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_times".
 *
 * @property string $role
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
      [['role'], 'required'],
      [['from', 'until'], 'safe'],
      [['has_free'], 'boolean'],
      [['role'], 'string', 'max' => 50],
      [['role'], 'unique'],
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
      'until' => 'Until',
      'has_free' => 'Has Free',
    ];
  }
}
