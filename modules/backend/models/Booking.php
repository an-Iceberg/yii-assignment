<?php

namespace app\modules\backend\models;

/**
 * This is the model class for table "bookings".
 *
 * @property string|null $role
 * @property string|null $treatment
 * @property string|null $date
 * @property string|null $patient_salutation
 * @property string|null $patient_firstName
 * @property string|null $patient_lastName
 * @property string|null $patient_birthdate
 * @property string|null $patient_street
 * @property int|null $patient_zipCode
 * @property int|null $patient_city
 * @property int|null $patient_phoneNumber
 * @property string|null $patient_email
 * @property string|null $patient_comment
 * @property bool|null $newPatient
 * @property bool|null $callback
 */
class Booking extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bookings';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['date', 'patient_birthdate'], 'safe'],
      [['patient_zipCode'], 'integer'],
      [['patient_phoneNumber'], 'string', 'max' => 20],
      [['patient_comment'], 'string'],
      [['newPatient', 'callback'], 'boolean'],
      [['role', 'patient_firstName', 'patient_lastName', 'patient_street', 'patient_city'], 'string', 'max' => 50],
      [['treatment'], 'string', 'max' => 100],
      [['patient_salutation'], 'string', 'max' => 8],
      [['patient_email'], 'string', 'max' => 254],

      // Input validation with regular expressions
      [['date'], 'match', 'pattern' => '/\d{4}-\d{2}-\d{2}/'],
      [['patient_firstName', 'patient_lastName'], 'match', 'pattern' => '/^[a-zA-Z\-\s]{1,50}$/'],
      [['patient_street'], 'match', 'pattern' => '/^[a-zA-Z0-9.\-\s]{1,50}$/'],
      [['patient_zipCode'], 'match', 'pattern' => '/^\d{1,10}$/'],
      [['patient_city'], 'match', 'pattern' => '/^[a-zA-Z0-9\-.\s]{1,50}$/'],
      [['patient_phoneNumber'], 'match', 'pattern' => '/^[0-9\-\s+]{1,16}$/'],
      [['patient_email'], 'match', 'pattern' => '/^[a-zA-Z.!#$%&\'*+\-\/=?^_`{|]{1,64}@[a-zA-Z0-9.\-]{1,255}\.[a-z]{1,255}$/'],
      [['newPatient', 'callback'], 'match', 'pattern' => '/[0,1]/'],
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
      'date' => 'Date',
      'patient_salutation' => 'Salutation',
      'patient_firstName' => 'First Name',
      'patient_lastName' => 'Last Name',
      'patient_birthdate' => 'Birthdate',
      'patient_street' => 'Street',
      'patient_zipCode' => 'Zip Code',
      'patient_city' => 'City',
      'patient_phoneNumber' => 'Phone Number',
      'patient_email' => 'Email',
      'patient_comment' => 'Comment',
      'newPatient' => 'New Patient',
      'callback' => 'Callback',
    ];
  }

  // Returns all data for all bookings
  public static function getAllBookings()
  {
    return Booking::find()
    ->select(['role', 'patient_salutation', 'patient_lastName', 'date'])
    ->all();
  }
}
