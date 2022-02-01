<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "bookings".
 *
 * @property string|null $doctor
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
 * @property bool|null $recall
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
      [['newPatient', 'recall'], 'boolean'],
      [['doctor', 'patient_firstName', 'patient_lastName', 'patient_street', 'patient_city'], 'string', 'max' => 50],
      [['treatment'], 'string', 'max' => 100],
      [['patient_salutation'], 'string', 'max' => 8],
      [['patient_email'], 'string', 'max' => 254],

      // Input validation with regular expressions
      [['patient_firstName', 'patient_lastName'], 'match', 'pattern' => '/^[a-zA-Z\-\ ]{1,50}$/'],
      [['patient_street'], 'match', 'pattern' => '/^[a-zA-Z0-9\.\-\ ]{1,50}$/'],
      [['patient_zipCode'], 'match', 'pattern' => '/^\d{1,10}$/'],
      [['patient_city'], 'match', 'pattern' => '/^[a-zA-Z0-9\-\.\ ]{1,50}$/'],
      [['patient_phoneNumber'], 'match', 'pattern' => '/^[0-9\-\ \+]{1,16}$/'],
      [['patient_email'], 'match', 'pattern' => '/^[a-zA-Z\.\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|]{1,64}@[a-zA-Z0-9\.\-]{1,255}\.[a-z]{1,255}$/'],
      [['newPatient', 'recall'], 'match', 'pattern' => '/[0,1]/'],
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
      'recall' => 'Recall',
    ];
  }

  // Returns the dates and times of the reserved bookings
  public static function getBookings($doctor, $treatment, $date)
  {
    return Booking::find()
    ->select('date')
    ->where('doctor=:doctor', [':doctor' => $doctor])
    ->andWhere('treatment=:treatment', [':treatment' => $treatment])
    ->andWhere('date LIKE :date', [':date' => '%'.$date.'%'])
    ->all();
  }
}
