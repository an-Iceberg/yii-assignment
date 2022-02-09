<?php

namespace app\modules\backend\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property string|null $doctor
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
      [['doctor', 'treatment'], 'string', 'max' => 100],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'doctor' => 'Doctor',
      'treatment' => 'Treatment',
    ];
  }

  // Retrieves all available treatments for the selected type
  public static function getTreatments($profession)
  {
    return Treatment::find()
    ->select('treatment')
    ->where('doctor=:doctor', [':doctor' => $profession])
    ->all();
  }
}
