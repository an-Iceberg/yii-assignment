<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\Roles;
use app\models\Treatments;
use app\models\Holidays;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class BookingController extends Controller
{
  /**
   * Displays the page to book an appointment
   *
   * @return string
   */
  public function actionIndex()
  {
    if (Yii::$app->request->getMethod() == 'POST')
    {
      $postParams = Yii::$app->request->post();

      // TODO: handle empty/no input with appropriate error messages
      // Rendering the next view depending on which view the user has been on previously
      switch ($postParams['view'])
      {
        // User has selected a role
        case 'role':
          // User moves on to select treatment
          if ($postParams['button'] == 'next')
          {
            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);

            return $this->render('treatment', [
              'treatments' => $treatments,
              'role' => $role,
            ]);
          }
        break;

        // User has selected a treatment
        case 'treatment':
          // User moves on to select date and time
          if ($postParams['button'] == 'next')
          {
            // * Alternative approach: send all present bookings of the selected role as a hidden input
            // * That would avoid the constant Ajax calls upon selecting a date
            // * But it would only work for a relatively small amount of clients

            $role = $postParams['role'];
            $treatments = $postParams['treatments'];

            $duration = Roles::getDuration($role);
            $totalDuration = $duration * count($treatments);

            return $this->render('time-and-date', [
              'role' => $role,
              'treatments' => $treatments,
              'totalDuration' => $totalDuration
            ]);
          }
          // User goes back to change the role
          elseif ($postParams['button'] == 'back')
          {
            $roles = Roles::getAllActiveRoles();

            $selectedRole = $postParams['role'];

            return $this->render('role', [
              'roles' => $roles,
              'selectedRole' => $selectedRole
            ]);
          }
        break;

        case 'time-and-date':
          if ($postParams['button'] == 'next')
          {
            # code ...
          }
          elseif ($postParams['button'] == 'back')
          {
            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);
            $selectedTreatments = $postParams['treatments'];

            return $this->render('treatment', [
              'role' => $role,
              'treatments' => $treatments,
              'selectedTreatments' => $selectedTreatments
            ]);
          }
        break;

        default:
          // Retrieving all available roles from the database
          $role = Roles::getAllActiveRoles();

          return $this->render('role', [
            'roles' => $role
          ]);
        break;
      }
    }
    else
    {
      // Retrieving all available roles from the database
      $role = Roles::getAllActiveRoles();

      return $this->render('role', [
        'roles' => $role
      ]);
    }
  }

  /**
   * Target for Ajax call; getting all the times for a specified date from the DB
   *
   * @return string
   */
  public function actionGetTimes()
  {
    // Only processing the request if the method is POST
    if (Yii::$app->request->method == 'POST')
    {
      $postParams = Yii::$app->request->post();

      $times = Bookings::getTimes($postParams['role'], $postParams['date']);

      return print_r($times);
    }

    return;
  }

  // User chooses the role
  public function actionRole()
  {
    $roles = Roles::find()
    ->select('id, role_name')
    ->where('status = true')
    ->all();

    return $this->render('role', [
      'roles' => $roles
    ]);
  }

  // User chooses the treatment available for the chosen role
  public function actionTreatment()
  {
    // TODO: redirect on GET
    if (Yii::$app->request->getMethod() == 'POST')
    {
      $postParams = Yii::$app->request->post();

      $role = $postParams['role'];

      // If the back button was clicked, redirect there
      // if ()
      // {}

      $treatments = Treatments::find()
      ->select('id, treatment_name')
      ->where('role_id = :role_id', [':role_id' => $postParams['role']])
      ->all();

      return $this->render('treatment', [
        'treatments' => $treatments,
        'role' => $role
      ]);
    }
    // Redirect on GET
    else
    {
      return $this->redirect('/booking');
    }
  }

  // User chooses appropriate time and date
  public function actionTimeAndDate()
  {
    // TODO: redirect on GET
    $postParams = Yii::$app->request->post();

    $role = $postParams['role'];
    $treatments = [];
    foreach ($postParams['treatment'] as $key => $value) {
      $treatments[] = $key;
    }

    // TODO: retrieve date and time

    return $this->render('time-and-date', [
      'treatments' => $treatments,
      'role' => $role
    ]);
  }

  public function actionPersonalInfo()
  {
    // TODO: redirect on get
    return $this->render('personal-info');
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
    $queryResults = Bookings::getBookings($booking['role'], $booking['treatment'], $booking['date'], $booking['time']);

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
    // Todo: User can create multiple DB entries by refreshing the page/going back to said page; fix that!
    // If this site is not accessed via POST method, redirect to the index site
    if (Yii::$app->request->method != 'POST')
    {
      return $this->redirect('/booking/booking');
    }

    $booking = new Bookings();

    $requestData = Yii::$app->request->bodyParams['booking'];

    // Assigning the request data to the Booking object
    $booking->role = $requestData['role'];
    $booking->treatment = $requestData['treatment'];
    $booking->date = $requestData['date'];
    $booking->time = $requestData['time'].':00';
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
        :role,
        :treatment,
        :date,
        :time,
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
      $insertQuery->bindValue(':role', $booking->role)
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
