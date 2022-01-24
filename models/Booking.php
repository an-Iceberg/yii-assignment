<?php

namespace app\models;

class Booking extends \yii\db\ActiveRecord
{
  public $doctor;
  public $treatment;
  public $date;
  public $patient_salutation;
  public $patient_firstName;
  public $patient_lastName;
  public $patient_birthdate;
  public $patient_street;
  public $patient_zipCode;
  public $patient_city;
  public $patient_phoneNumber;
  public $patent_email;
  public $newPatient;
  public $recall;

  public static function tableName()
  {
    return 'bookings';
  }
}
