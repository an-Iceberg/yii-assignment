<?php

namespace app\modules\booking\controllers;

use Yii;
use yii\web\Controller;
use app\models\Holidays;
use app\models\Profession;
use app\models\Treatment;
use app\models\Booking;

class BookingController extends Controller
{
  /**
   * Displays the page to book an appointment
   *
   * @return string
   */
  public function actionIndex()
  {
    // Retrieving all available professions from the database
    $profession = Profession::getAllProfessions();

    return $this->render('index', [
      'data' => $profession
    ]);
  }

  /**
   * Target for Ajax call
   * Returns all treatments for the selected type
   *
   * @return void|string
   */
  public function actionTreatment()
  {
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    // Extracting the relevant input data from the request
    $booking = Yii::$app->request->bodyParams['booking'];

    // Retrieving treatments from database
    $queryResults = Treatment::getTreatments($booking['doctor']);

    // Extracting the treatments from $queryResults and applying HTML formatting to it so it can just be injected into the correct place without any additional editing
    $treatments = '';
    for ($i = 0; $i < sizeof($queryResults); $i++)
    {
      $treatments .=
      '<label>'.
      '<input type="radio" name="booking[treatment]" value="'.
      $queryResults[$i]->treatment.
      '"> '.
      $queryResults[$i]->treatment.
      '</label>';

      if ($i < sizeof($queryResults) - 1)
      {
        $treatments .= '<br>';
      }
    }

    return $treatments;
  }

  /**
   * Target for Ajax call
   * Returns all holidays
   *
   * @return void|string
   */
  public function actionGetHolidays()
  {
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    // Retrieving holidays and bookings from the database
    $holidays = Holidays::getHolidays();

    $responseData = [];

    // Populating the response data array with the dates
    foreach ($holidays as $date)
    {
      $responseData[] = $date->date;
    }

    return json_encode($responseData);
  }

  /**
   * Target for Ajax call
   * Returns all bookings for a specific date
   *
   * @return void|string
   */
  public function actionGetBookings()
  {
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    $booking = Yii::$app->request->bodyParams['booking'];

    // Retrieving all existing bookings in the relevant categories
    $queryResults = Booking::getBookings($booking['doctor'], $booking['treatment'], $booking['date']);

    $responseData = [];

    // Extracting the date and appending it to the array
    foreach ($queryResults as $value)
    {
      $responseData[] = substr($value->date, 11, 5);
    }

    return json_encode($responseData);
  }

  /**
   * Displays booked appointment on successful booking
   *
   * @return void|string
   */
  public function actionInputValidation()
  {
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    $booking = new Booking();

    $requestData = Yii::$app->request->bodyParams['booking'];

    // Assigning the request data to the Booking object
    $booking->doctor = $requestData['doctor'];
    $booking->treatment = $requestData['treatment'];
    $booking->date = $requestData['date'].' '.$requestData['time'].':00';
    $booking->patient_salutation = $requestData['patient_salutation'];
    $booking->patient_firstName = $requestData['patient_firstName'];
    $booking->patient_lastName = $requestData['patient_lastName'];
    $booking->patient_birthdate = $requestData['patient_birthdate'];
    $booking->patient_street = $requestData['patient_street'];
    $booking->patient_zipCode = $requestData['patient_zipCode'];
    $booking->patient_city = $requestData['patient_city'];
    $booking->patient_phoneNumber = $requestData['patient_phoneNumber'];
    $booking->patient_email = $requestData['patient_email'];
    $booking->patient_comment = $requestData['patient_comment'];
    $booking->newPatient = $requestData['newPatient'] == '1' ? 1 : 0;
    $booking->recall = $requestData['recall'] == '1' ? 1 : 0;

    // If the validation is successful, insert values into database
    if ($booking->validate()) {

      // Creating insert query
      $insertQuery = Yii::$app->db->createCommand('INSERT INTO bookings VALUES (
        :doctor,
        :treatment,
        :date,
        :patient_salutation,
        :patient_firstName,
        :patient_lastName,
        :patient_birthdate,
        :patient_street,
        :patient_zipCode,
        :patient_city,
        :patient_phoneNumber,
        :patient_email,
        :patient_comment,
        :newPatient,
        :recall
      );');

      // Binding values
      $insertQuery->bindValue(':doctor', $booking->doctor)
      ->bindValue(':treatment', $booking->treatment)
      ->bindValue(':date', $booking->date)
      ->bindValue(':patient_salutation', $booking->patient_salutation)
      ->bindValue(':patient_firstName', $booking->patient_firstName)
      ->bindValue(':patient_lastName', $booking->patient_lastName)
      ->bindValue(':patient_birthdate', $booking->patient_birthdate)
      ->bindValue(':patient_street', $booking->patient_street)
      ->bindValue(':patient_zipCode', $booking->patient_zipCode)
      ->bindValue(':patient_city', $booking->patient_city)
      ->bindValue(':patient_phoneNumber', $booking->patient_phoneNumber)
      ->bindValue(':patient_email', $booking->patient_email)
      ->bindValue(':patient_comment', $booking->patient_comment)
      ->bindValue(':newPatient', $booking->newPatient)
      ->bindValue(':recall', $booking->recall);

      // Executing query
      $insertQuery->execute();

      return $this->render('bookingSuccess', [
        'message' => 'Your booking has been saved.'
      ]);
    }

    $inputErrors = $booking->errors;
    $displayErrors = [];

    // Extracts all the errors from the object into a separate array
    foreach ($inputErrors as $errors) {
      foreach ($errors as $error) {
        $displayErrors[] = $error;
      }
    }

    return $this->render('bookingFailiure', [
      'message' => implode('<br>', $displayErrors)
    ]);
  }
}
