<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\Roles;
use app\models\Treatments;
use app\models\Holidays;
use app\models\WhoHasHolidays;
use app\models\WorkTimes;
use DateInterval;
use DateTime;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class BookingController extends Controller
{
  /**
   * All booking views go through this action
   * The information between them is shared via hidden inputs
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
            // TODO: days, that are completetly booked and/or completely 'consumed' by a holiday should be disabled in the date picker
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
            return $this->render('personal-info', [
              'role' => $postParams['role'],
              'treatments' => $postParams['treatments'],
              'totalDuration' => $postParams['totalDuration'],
              'date' => $postParams['date'],
              'time' => $postParams['time']
            ]);
          }
          elseif ($postParams['button'] == 'back')
          {
            $role = $postParams['role'];
            $treatments = Treatments::getTreatments($role);
            $selectedTreatments = $postParams['treatments'];

            return $this->render('treatment', [
              'role' => $role,
              'treatments' => $treatments,
              'selectedTreatments' => $selectedTreatments,
              'date' => $postParams['date'],
              'time' => $postParams['time']
            ]);
          }
        break;

        case 'personal-info':
          if ($postParams['button'] == 'next')
          {
          }
          elseif ($postParams['button'] == 'back')
          {
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
   * Returns a HTML snippet to be inserted into #times so that the client machine can run as efficiently as possible
   *
   * @return string
   */
  public function actionGetTimes()
  {
    // Only processing the request if the method is POST
    if (Yii::$app->request->method == 'POST')
    {
      /**
       * The following values will come through the Ajax call:
       * @var string ['date']
       * @var string ['role']
       * @var string ['totalDuration']
       */
      $postParams = Yii::$app->request->post();

      // Retrieving the times if there's a holiday present for the current role
      $query = Yii::$app->db->createCommand(
        'SELECT holidays.beginning_time, holidays.end_time
        FROM roles
        JOIN who_has_holidays ON roles.id = who_has_holidays.role_id
        JOIN holidays ON who_has_holidays.holiday_id = holidays.id
        WHERE roles.id = :role_id AND holidays.date = :holiday_date;',
        [
          ':role_id' => intval($postParams['role']),
          ':holiday_date' => $postParams['date']
        ]
      );

      $holiday = $query->queryAll();
      $bookedTimes = Bookings::getTimes($postParams['role'], $postParams['date']);

      // Retrieving the work times of the current role for the selected weekday
      $weekday = new DateTime($postParams['date']);
      $workTimes = WorkTimes::getWorkTime(intval($postParams['role']), (intval($weekday->format('N')) - 1));
      $workTimeFrom = new DateTime($workTimes['from']);
      $workTimeUntil = new DateTime($workTimes['until']);

      // TODO: {optional} build the array instead of subtracting from it
      // ! Be careful about the array indices, they might change when deleting array elements
      // * We can use that to our advantage
      $times = [];

      array_push($times, $workTimeFrom->format('H:i:00'));

      // There are 96 15-minute intervals in a 24 hour day ((24 * 60) / 15)
      // This variable prevents an infinite loop
      $infiniteLoopSafeguard = 0;

      // Generating the times from the working hours
      while($workTimeFrom <= $workTimeUntil && $infiniteLoopSafeguard < 97)
      {
        $infiniteLoopSafeguard++;

        // Adding 15 minutes to the date and appending it to the times array
        $workTimeFrom->add(new DateInterval('PT15M'));
        array_push($times, $workTimeFrom->format('H:i:00'));
      }

      $HTMLsnippet = '';

      // Removing all holidays
      foreach ($times as $key => &$time) {
        // If the time falls withing the range of a holiday, it gets removed from the array
        if (isset($holiday[0]['beginning_time']) && $holiday[0]['end_time'])
        {
          if ($time >= $holiday[0]['beginning_time'] && $time <= $holiday[0]['end_time'])
          {
            // TODO: {optional} make this work without the $key
            unset($times[$key]);
            unset($time); // ! This will be redundant in the future
          }
        }

        // If the time falls within the range of a booking, it gets removed
        foreach ($bookedTimes as $booking) {
          // Creating the beginning time
          $beginning = new DateTime($booking['time']);
          $end = new DateTime($booking['time']);

          // Modifying the end time by adding the amount of minutes to the beginning time
          $timePeriod = 'PT'.$booking['duration'].'M';
          $end->add(new DateInterval($timePeriod));

          if ($time >= $beginning->format('H:i:00') && $time <= $end->format('H:i:00'))
          {
            unset($times[$key]);
            unset($time); // ! This will be redundant in the future
          }
        }

        // Only writing the remaining times into the HTML snippet
        if (isset($time))
        {
          $HTMLsnippet .= '<label class="input-label times">'.substr($time, 0, 5).'<input type="radio" name="time" value="'.$time.'"></label>';
        }
      }
      unset($time);

      // TODO: Go through each time again and remove any times where the $totalDuration doesn't fit
      // Removing any time slots that would not fit the $totalDuration
      // foreach ($times as $key => &$time) {
        // Calculate the destination time using DateTime object

        // Calculate the number of 15 minute segments needed to reserve for said duration

        // Retrieve the time at said offset

        // If the time at the offset is smaller than the DateTime object, remove the time from the array
      // }

      // return json_encode($times);
      return $HTMLsnippet;
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
