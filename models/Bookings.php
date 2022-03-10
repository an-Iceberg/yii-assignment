<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bookings".
 *
 * @property int $id
 * @property int|null $duration
 * @property int|null $role_id
 * @property JSON|null $treatment_id
 * @property string|null $date
 * @property string|null $time
 * @property string|null $patient_salutation
 * @property string|null $patient_firstName
 * @property string|null $patient_lastName
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
 * @property int|null $status
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
      // TODO: treatment_id needs custom input validation (JSON)
      [['duration', 'role_id', 'patient_zipCode', 'status'], 'integer'],
      [['date', 'time', 'patient_birthdate'], 'safe'],
      [['patient_comment'], 'string'],
      [['newPatient', 'callback', 'send_confirmation'], 'boolean'],
      [['patient_salutation'], 'string', 'max' => 8],
      [['patient_firstName', 'patient_lastName', 'patient_street', 'patient_city'], 'string', 'max' => 50],
      [['patient_phoneNumber'], 'string', 'max' => 20],
      [['patient_email'], 'string', 'max' => 254],

      // Input validation with regex
      [['date'], 'match', 'pattern' => '/\d{4}-\d{2}-\d{2}/'],
      [['time'], 'match', 'pattern' => '/\d{2}:\d{2}:00/'],
      [['patient_firstName', 'patient_lastName'], 'match', 'pattern' => '/^[a-zA-Z\-\s]{1,50}$/'],
      [['patient_street'], 'match', 'pattern' => '/^[a-zA-Z0-9.\-\s]{1,50}$/'],
      [['patient_zipCode'], 'match', 'pattern' => '/^\d{1,10}$/'],
      [['patient_city'], 'match', 'pattern' => '/^[a-zA-Z0-9\-.\s]{1,50}$/'],
      [['patient_phoneNumber'], 'match', 'pattern' => '/^[0-9\-\s+]{1,16}$/'],
      [['patient_email'], 'match', 'pattern' => '/^[a-zA-Z.!#$%&\'*+\-\/=?^_`{|]{1,64}@[a-zA-Z0-9.\-]{1,255}\.[a-z]{1,255}$/'],
      [['newPatient', 'callback', 'send_confirmation'], 'match', 'pattern' => '/[0,1]/'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'duration' => 'Duration',
      'role_id' => 'Role ID',
      'treatment_id' => 'Treatment ID',
      'date' => 'Date',
      'time' => 'Time',
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
      'send_confirmation' => 'Send Confirmation',
      'status' => 'Status',
    ];
  }

  // Returns the name of the treatment
  public function getTreatment()
  {
    return $this->hasOne(Treatments::class, ['id' => 'treatment_id']);
  }

  // Returns the name of the role
  public function getRole()
  {
    return $this->hasOne(Roles::class, ['id' => 'role_id']);
  }

  // Returns all reserved times
  public static function getTimes($role, $date)
  {
    return Bookings::find()
    ->select('time, duration')
    ->where('role_id = :role_id AND date = :date', [':role_id' => $role, ':date' => $date])
    ->all();
  }

  // Returns the dates and times of the reserved bookings
  public static function getBookings($role_id, $treatment, $date, $time)
  {
    return Bookings::find()
    ->select('date')
    ->where('role_id=:role_id', [':role_id' => $role_id])
    ->andWhere('treatment=:treatment', [':treatment' => $treatment])
    ->andWhere('date LIKE :date', [':date' => '%'.$date.'%'])
    ->andWhere('time LIKE :time', [':time' => '%'.$time.'%'])
    ->all();
  }
}
