<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "treatments".
 *
 * @property string|null $role
 * @property string|null $treatment
 * @property int|null $sort_order
 */
class Treatments extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'treatments';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['sort_order'], 'integer'],
      [['role', 'treatment'], 'string', 'max' => 100],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'role' => 'Role',
      'treatment' => 'Treatment',
      'sort_order' => 'Sort Order',
    ];
  }

  // Retrieves all available treatments for the selected type
  public static function getTreatments($profession)
  {
    return Treatments::find()
    ->select('treatment')
    ->where('role=:role', [':role' => $profession])
    ->all();
  }
}
