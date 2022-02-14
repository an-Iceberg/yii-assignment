<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings".
 *
 * @property int|null $duration
 * @property string $role
 * @property string|null $treatment
 * @property string $date
 * @property string $time
 * @property string|null $patient_salutation
 * @property string|null $patient_firstName
 * @property string $patient_lastName
 * @property string|null $patient_birthdate
 * @property string|null $patient_street
 * @property int|null $patient_zipCode
 * @property string|null $patient_city
 * @property string|null $patient_phoneNumber
 * @property string|null $patient_email
 * @property string|null $patient_comment
 * @property bool|null $newPatient
 * @property bool|null $callback
 * @property bool|null $send_confirmation
 * @property bool|null $status
 */
class Bookings extends \yii\db\ActiveRecord
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
      [['duration', 'patient_zipCode'], 'integer'],
      [['role', 'date', 'time', 'patient_lastName'], 'required'],
      [['date', 'time', 'patient_birthdate'], 'safe'],
      [['patient_comment'], 'string'],
      [['newPatient', 'callback', 'send_confirmation', 'status'], 'boolean'],
      [['role', 'patient_firstName', 'patient_lastName', 'patient_street', 'patient_city'], 'string', 'max' => 50],
      [['treatment'], 'string', 'max' => 100],
      [['patient_salutation'], 'string', 'max' => 8],
      [['patient_phoneNumber'], 'string', 'max' => 20],
      [['patient_email'], 'string', 'max' => 254],
      [['role', 'date', 'time', 'patient_lastName'], 'unique', 'targetAttribute' => ['role', 'date', 'time', 'patient_lastName']],

      // Input validation with regex
      [['date'], 'match', 'pattern' => '/\d{4}-\d{2}-\d{2}/'],
      [['time'], 'match', 'pattern' => '/\d{2}:\d{2}:00/'],
      [['patient_firstName', 'patient_lastName'], 'match', 'pattern' => '/^[a-zA-Z\-\s]{1,50}$/'],
      [['patient_street'], 'match', 'pattern' => '/^[a-zA-Z0-9.\-\s]{1,50}$/'],
      [['patient_zipCode'], 'match', 'pattern' => '/^\d{1,10}$/'],
      [['patient_city'], 'match', 'pattern' => '/^[a-zA-Z0-9\-.\s]{1,50}$/'],
      [['patient_phoneNumber'], 'match', 'pattern' => '/^[0-9\-\s+]{1,16}$/'],
      [['patient_email'], 'match', 'pattern' => '/^[a-zA-Z.!#$%&\'*+\-\/=?^_`{|]{1,64}@[a-zA-Z0-9.\-]{1,255}\.[a-z]{1,255}$/'],
      [['newPatient', 'callback', 'send_confirmation', 'status'], 'match', 'pattern' => '/[0,1]/'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'duration' => 'Duration',
      'role' => 'Role',
      'treatment' => 'Treatment',
      'date' => 'Date',
      'time' => 'Time',
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
      'callback' => 'Callback',
      'send_confirmation' => 'Send Confirmation',
      'status' => 'Status',
    ];
  }

  // Returns all data for all bookings
  public static function getAllBookings()
  {
    return Bookings::find()
    ->select(['role', 'patient_salutation', 'patient_lastName', 'date'])
    ->all();
  }

  // Returns the dates and times of the reserved bookings
  public static function getBookings($role, $treatment, $date, $time)
  {
    return Bookings::find()
    ->select('date')
    ->where('role=:role', [':role' => $role])
    ->andWhere('treatment=:treatment', [':treatment' => $treatment])
    ->andWhere('date LIKE :date', [':date' => '%'.$date.'%'])
    ->andWhere('time LIKE :time', [':time' => '%'.$time.'%'])
    ->all();
  }
}
