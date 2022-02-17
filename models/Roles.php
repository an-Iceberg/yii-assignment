<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string|null $role_name
 * @property string|null $email
 * @property string|null $description
 * @property int|null $sort_order
 * @property int|null $duration
 * @property bool|null $status
 */
class Roles extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'roles';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['description'], 'string'],
      [['sort_order', 'duration'], 'integer'],
      [['status'], 'boolean'],
      [['role_name'], 'string', 'max' => 50],
      [['email'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'Role ID',
      'role_name' => 'Role Name',
      'email' => 'E-Mail',
      'description' => 'Description',
      'sort_order' => 'Sort Order',
      'duration' => 'Duration',
      'status' => 'Status',
    ];
  }

  // One role can be used by many bookings
  // public function getBooking()
  // {
  //   return $this->hasMany(Bookings::class, ['role_id' => 'id']);
  // }

  // One role has many treatments
  public function getTreatments()
  {
    return $this->hasMany(Treatments::class, ['role_id' => 'id']);
  }

  // One role hase work times
  public function getWorkTimes()
  {
    return $this->hasMany(WorkTimes::class, ['role_id' => 'id']);
  }

  // Retrieves all the different professions available from the db
  public static function getAllRoles()
  {
    return Roles::find()
    ->all();
  }
}
