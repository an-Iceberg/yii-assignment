<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "backend_users".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $auth_key
 */
class BackendUsers extends \yii\db\ActiveRecord implements IdentityInterface
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
      [['password', 'auth_key'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'username' => 'Username',
      'password' => 'Password',
      'auth_key' => 'Auth Key',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public static function findIdentity($id)
  {
    return static::findOne($id);
  }

  /**
   * {@inheritDoc}
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
  }

  /**
   * {@inheritDoc}
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * {@inheritDoc}
   */
  public function getAuthKey()
  {
    return $this->auth_key;
  }

  /**
   * {@inheritDoc}
   */
  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  }
}
