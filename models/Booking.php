<?php

namespace app\models;

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
      [['patient_zipCode', 'patient_city', 'patient_phoneNumber'], 'integer'],
      [['patient_comment'], 'string'],
      [['newPatient', 'recall'], 'boolean'],
      [['doctor', 'patient_firstName', 'patient_lastName', 'patient_street'], 'string', 'max' => 50],
      [['treatment'], 'string', 'max' => 100],
      [['patient_salutation'], 'string', 'max' => 8],
      [['patient_email'], 'string', 'max' => 254],
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
      'patient_salutation' => 'Patient Salutation',
      'patient_firstName' => 'Patient First Name',
      'patient_lastName' => 'Patient Last Name',
      'patient_birthdate' => 'Patient Birthdate',
      'patient_street' => 'Patient Street',
      'patient_zipCode' => 'Patient Zip Code',
      'patient_city' => 'Patient City',
      'patient_phoneNumber' => 'Patient Phone Number',
      'patient_email' => 'Patient Email',
      'patient_comment' => 'Patient Comment',
      'newPatient' => 'New Patient',
      'recall' => 'Recall',
    ];
  }
}
