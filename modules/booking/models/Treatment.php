<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property string|null $role
 * @property string|null $treatment
 */
class Treatment extends \yii\db\ActiveRecord
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
    ];
  }

  // Retrieves all available treatments for the selected type
  public static function getTreatments($profession)
  {
    return Treatment::find()
    ->select('treatment')
    ->where('role=:role', [':role' => $profession])
    ->all();
  }
}
