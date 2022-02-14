<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "backend_users".
 *
 * @property string $username
 * @property string|null $password
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
      [['username'], 'required'],
      [['username'], 'string', 'max' => 50],
      [['password'], 'string', 'max' => 255],
      [['username'], 'unique'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'username' => 'Username',
      'password' => 'Password',
    ];
  }
}
