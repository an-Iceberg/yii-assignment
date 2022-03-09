<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "treatments".
 *
 * @property int $id
 * @property int|null $role_id
 * @property string|null $treatment_name
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
      [['role_id', 'sort_order'], 'integer'],
      [['treatment_name'], 'string', 'max' => 100]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'Treatment ID',
      'role_id' => 'Role ID',
      'treatment_name' => 'Treatment Name',
      'sort_order' => 'Sort Order',
    ];
  }

  // One treatment can be used by many bookings
  public function getBooking()
  {
    return $this->hasMany(Bookings::class, ['treatment_id' => 'id']);
  }

  // One treatment can be used by one role
  public function getRole()
  {
    return $this->hasOne(Roles::class, ['treatment_id' => 'id']);
  }

  /**
   * Retrieves all available treatments for the selected role
   *
   * @param int $role The selected role
   * @return array\Treatments All available roles for said treatment
   */
  public static function getTreatments($role)
  {

    return Treatments::find()
    ->select('id, treatment_name')
    ->where('role_id = :role_id', [':role_id' => $role])
    ->all();
  }

  /**
   * Retrieves the names of the treatments
   *
   * @param array $treatments The ids of the treatments
   * @return array The names of the treatments
   */
  public static function getTreatmentNames($treatments)
  {
    $names = Treatments::find()
    ->select('treatment_name')
    ->where(['id' => $treatments])
    ->all();

    $nameArray = [];

    // Extracting all the name strings from the active record objects
    foreach ($names as $name)
    {
      array_push($nameArray, $name['treatment_name']);
    }

    return $nameArray;
  }
}
