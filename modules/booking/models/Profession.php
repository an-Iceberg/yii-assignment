<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "professions".
 *
 * @property string|null $profession
 */
class Profession extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'professions';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['profession'], 'string', 'max' => 50],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'profession' => 'Profession',
    ];
  }

  // Retrieves all the different professions available from the db
  public static function getAllProfessions()
  {
    return Profession::find()
    ->all();
  }
}
