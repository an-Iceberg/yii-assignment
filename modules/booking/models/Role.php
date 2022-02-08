<?php

namespace app\modules\booking\models;

/**
 * This is the model class for table "professions".
 *
 * @property string|null $profession
 */
class Role extends \yii\db\ActiveRecord
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
    ];
  }

  // Retrieves all the different professions available from the db
  public static function getAllRoles()
  {
    return Role::find()
    ->all();
  }
}
