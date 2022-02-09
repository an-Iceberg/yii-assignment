<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings".
 *
 * @property int|null $duration
 * @property string|null $role
 * @property string|null $treatment
 * @property string|null $date2
 * @property string|null $time
 * @property string|null $date
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
            [['date2', 'time', 'date', 'patient_birthdate'], 'safe'],
            [['patient_comment'], 'string'],
            [['newPatient', 'callback', 'send_confirmation'], 'boolean'],
            [['role', 'patient_firstName', 'patient_lastName', 'patient_street', 'patient_city'], 'string', 'max' => 50],
            [['treatment'], 'string', 'max' => 100],
            [['patient_salutation'], 'string', 'max' => 8],
            [['patient_phoneNumber'], 'string', 'max' => 20],
            [['patient_email'], 'string', 'max' => 254],
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
            'date2' => 'Date2',
            'time' => 'Time',
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
            'callback' => 'Callback',
            'send_confirmation' => 'Send Confirmation',
        ];
    }
}
