<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property string $role
 * @property string $email
 * @property string|null $description
 * @property int|null $sort_order
 * @property int|null $work_duration
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
      [['role', 'email'], 'required'],
      [['description'], 'string'],
      [['sort_order', 'work_duration'], 'integer'],
      [['status'], 'boolean'],
      [['role'], 'string', 'max' => 50],
      [['email'], 'string', 'max' => 255],
      [['role', 'email'], 'unique', 'targetAttribute' => ['role', 'email']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'role' => 'Role',
      'email' => 'Email',
      'description' => 'Description',
      'sort_order' => 'Sort Order',
      'work_duration' => 'Work Duration',
      'status' => 'Status',
    ];
  }

  // Retrieves all the different professions available from the db
  public static function getAllRoles()
  {
    return Roles::find()
    ->all();
  }
}
