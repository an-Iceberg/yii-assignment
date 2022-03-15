<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "backend_users".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $hashed_password
 */
class BackendUsers extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'backend_users';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['username'], 'string', 'max' => 50],
      [['hashed_password'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'User ID',
      'username' => 'Username',
      'hashed_password' => 'Password',
    ];
  }
}
